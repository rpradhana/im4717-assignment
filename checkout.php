<!DOCTYPE html>
<html lang="en-GB">
<?php include './php/head.php'; ?>
<body class="debug o f h d">
	<?php
        include './php/cart-item.php';
        session_start();
        //Connect to database
        $conn = new mysqli("localhost", "f36im", "f36im", "f36im");

        if ($conn->connect_error) {
            //Fallback if unable to connect to database
            exit();
        }

        include_once ('./php/countries-list.php');

        $outofstock = array();
        $emailregistered = false;
        $isvalidcard = true;
        $isSuccessTransaction = false;

        if (isset($_POST["buy"])) {
            //After checkout form is submitted
            $items = $_POST["items"];

            $is_logged_in = true;
            if (!isset($_SESSION["username"]) || empty(trim($_SESSION["username"])) || !isset($_SESSION["email"]) || empty(trim($_SESSION["email"]))) {
                $is_logged_in = false;
            }

            $shouldProcessFurther = true;
            $customer_id = -1;


            //Begin transaction. Commit to database only if all queries are successful.
            $query = "START TRANSACTION;";
            $conn->query($query);

            //Logged in
            if ($is_logged_in) {
                $query = 'SELECT c.id FROM customers AS c, accounts AS a WHERE c.id = a.customersID AND c.fullName="' . $_SESSION["username"] . '" AND 
                a.email = "' . $_SESSION["email"] . '";';
                $result = $conn->query($query);
                $num_rows = $result->num_rows;
                if ($num_rows != 1) {
                    //Email not found or name not correct
                    $shouldProcessFurther = false;
                } else {
                    $row = $result->fetch_assoc();
                    $customer_id = $row["id"];
                }
                $result->free();
            } else {
                //Not logged in, add record into customers (and accounts if needed)
                $name = trim($_POST["name"]);
                $address = trim($_POST["address"]);
                $phone = trim($_POST["phone"]);
                $country = trim($_POST["country"]);
                $create_account = $_POST["create-account"];
                $gender = ucfirst(trim($_POST["gender"]));
                $birthday = trim($_POST["birthday"]);

                preg_match('/^[A-Za-z]+(\s[A-Za-z]*)*$/', $name, $matches_name);
                preg_match('/\+?(\d-?){8,16}/', $phone, $matches_phone);

                //Validate name, address, phone, country
                if (!isset($items) || empty($name) || empty($address) || empty($country) || empty($phone)
                   || empty($matches_name) || empty($matches_phone) || !in_array($country, $countries)) {
                    $shouldProcessFurther = false;
                }


                if ($shouldProcessFurther) {
                    $query = "INSERT INTO customers (fullName, address, country, phone";

                    $insert_gender = false;
                    if ($gender[0] == 'M' || $gender[0] == 'W') {
                        $query .= ', gender';
                        $insert_gender = true;
                    }

                    $insert_birthday = false;
                    if (!empty($birthday)) {
                        preg_match('/^\d{4,4}-\d{1,2}-\d{1,2}$/', $birthday, $matches_birthday);
                        if (empty($matches_birthday)) {
                            $shouldProcessFurther = false;
                        }

                        $query .= ', birthday';
                        $insert_birthday = true;
                    }

                    $query .= ') VALUES ("' . $name . '","' . $address . '","' . $country . '","' . $phone;
                    if ($insert_gender) {
                        $query .= '","' . $gender[0];
                    }

                    if ($insert_birthday) {
                        $query .= '","' . $birthday;
                    }

                    $query .= '");';
                    $result;
                    if ($shouldProcessFurther) {
                        $result = $conn->query($query);
                    }
                    if(!$result || $conn->affected_rows != 1) {
                        //Unable to insert into customers table
                        $shouldProcessFurther = false;
                    }

                    $customer_id = $conn->insert_id;
                }

                if($shouldProcessFurther && $create_account){
                    $email = trim($_POST["email"]);
                    $password = $_POST["password"];
                    $password_verify = $_POST["password--verify"];

                    preg_match('/^[\w-_\.]+@[\w_-]+(\.[\w_-]+){0,2}\.\w{2,3}$/', $email, $matches_email);

                    //Validate email
                    if (empty($matches_email)) {
                        $shouldProcessFurther = false;
                    }

                    //Validate password
                    if ($password != $password_verify) {
                        $shouldProcessFurther = false;
                    }

                    if ($shouldProcessFurther) {
                        //Generate salt
                        $salt = $customer_id . $name;
                        $password_salted = hash('sha256',$salt.$password);

                        $query = 'INSERT INTO accounts (customersID, email, password, role) VALUES(' . $customer_id . ',"' . $email . '","' . $password_salted . '","USER");';
                        $result = $conn->query($query);
                        if(!$result) {
                            //Unable to insert into accounts table
                            $shouldProcessFurther = false;
                        } else if ($conn->affected_rows != 1) {
                            $emailregistered = true;
                            $shouldProcessFurther = false;
                        }
                    }
                }
            }

            if ($shouldProcessFurther) {
                //Validate shipping
                $shipping = trim($_POST["shipping"]);
                if  ($shipping != "standard" && $shipping != "express") {
                    $shouldProcessFurther = false;
                }
            }

            //Validate items format
            $product_ids = array();
            $product_color = array();
            $product_size = array();
            $product_qty = array();
            $unique_product_ids = array();
            if ($shouldProcessFurther) {
                foreach ($items as $item) {
                    preg_match('/^(\d+)_([a-z]+)_([A-Z]+)_(\d+)/', $item, $matches_item);
                    if (empty($matches_item)) {
                        $shouldProcessFurther = false;
                        break;
                    } else {
                        $id = $matches_item[1];
                        array_push($product_ids, $id);
                        array_push($product_color, ucfirst($matches_item[2]));
                        array_push($product_size, $matches_item[3]);
                        array_push($product_qty, $matches_item[4]);
                    }
                }
                $unique_product_ids = array_unique($product_ids);
            }

            //Get product prices
            $product_prices = array();
            if ($shouldProcessFurther) {
                //Build an array of product IDs in the cart to facilitate single query only
                $field = '(';
                $first = true;
                foreach ($unique_product_ids as $id) {
                    if($first) {
                        $field .= $id;
                        $first = false;
                    } else {
                        $field .= ',' . $id;
                    }
                }
                $field .= ')';

                $query = 'SELECT p.id, p.price, p.discount FROM products AS p WHERE p.id IN ' . $field . ';';
                $result = $conn->query($query);

                if($result) {
                    $num_rows = $result->num_rows;
                    //Expect to get same number of records as there are unique IDs. Otherwise some IDs are invalid.
                    if ($num_rows == sizeof($unique_product_ids)) {
                        for ($i = 0; $i < $num_rows; $i++) {
                            $row = $result->fetch_assoc();
                            $id = $row["id"];
                            $price_after_discount = (1 - $row["discount"]/(float)100) * $row["price"];

                            $product_prices[$id] = $price_after_discount;
                        }
                    } else {
                        $shouldProcessFurther = false;
                    }
                    $result->free();
                } else {
                    //Unable to query for price
                    $shouldProcessFurther = false;
                }
            }

            //Simulation for bank verification
            if (!isset($_POST["card-type"]) || !isset($_POST["card-number"]) || !isset($_POST["card-month"]) || !isset($_POST["card-year"]) ||
                !isset($_POST["card-cvv"])) {
                $shouldProcessFurther = false;
            } else {
                $query = 'SELECT name FROM bank_simulation WHERE type = ' . $_POST["card-type"] . ' AND number = "' . $_POST["card-number"] . '" AND 
                CVV = "' . $_POST["card-cvv"] . '" AND YEAR(expiry) = "' . $_POST["card-year"] . '" AND MONTH (expiry) = "' . $_POST["card-month"] . '" AND
                YEAR(expiry) > YEAR(CURRENT_TIMESTAMP) OR (YEAR(expiry) = YEAR(CURRENT_TIMESTAMP) AND MONTH(expiry) >= MONTH(CURRENT_TIMESTAMP));';
                $result = $conn->query($query);
                if (!$result || $result->num_rows != 1) {
                    $isvalidcard = false;
                    $shouldProcessFurther = false;
                }
                $result->free();
            }


            if ($shouldProcessFurther) {
                $query = 'INSERT INTO orders (customersID, ordersDate, shipping) VALUES(' . $customer_id . ', NOW(),"' . strtoupper($shipping[0]) . '");';
                $result = $conn->query($query);
                if(!$result || $conn->affected_rows != 1) {
                    //Unable to insert into orders table
                    $shouldProcessFurther = false;
                }
            }


            $order_id = $conn->insert_id;

            if ($shouldProcessFurther) {
                for ($i = 0; $i < sizeof($product_ids); $i++) {
                    $id = $product_ids[$i];

                    //Get inventory id
                    $query = 'SELECT i.id FROM inventory AS i WHERE i.productsID = '. $id . ' AND i.color = "' . $product_color[$i] .
                        '" AND i.size = "' . $product_size[$i] . '";';
                    $result = $conn->query($query);
                    if(!$result || $result->num_rows != 1) {
                        $shouldProcessFurther = false;
                        break;
                    }
                    $row = $result->fetch_assoc();
                    $inventory_id = $row["id"];
                    $result->free();
                    //Populate orders_inventory table
                    $query = 'INSERT INTO orders_inventory (inventoryID, ordersID, pricePerItem, quantity) VALUES (' . $inventory_id . ',' . $order_id .
                        ',' . $product_prices[$id] . ',' . $product_qty[$i] . ');';
                    $result = $conn->query($query);
                    if(!$result || $conn->affected_rows != 1) {
                        //Unable to insert into orders_inventory table
                        $shouldProcessFurther = false;
                        break;
                    }
                    $query = 'UPDATE inventory SET stock = stock - ' . $product_qty[$i] . ' WHERE id=' . $inventory_id .' AND stock >= ' . $product_qty[$i]
                        . ';';
                    $result = $conn->query($query);
                    if(!$result) {
                        //Unable to update inventory table
                        $shouldProcessFurther = false;
                        break;
                    } else if ($conn->affected_rows != 1) {
                        //Stock is exhausted, check for all 0 stocks to show in form
                        $shouldProcessFurther = false;
                        array_push($outofstock, $id . '_' . lcfirst($product_color[$i]) . '_' . $product_size[$i]);
                    }
                }
            }

            if ($shouldProcessFurther) {
                //Passed all checks
                $query = 'COMMIT;';
                $conn->query($query);

                if ($create_account || isset($_SESSION["email"])) {
                    //Send email to notify success orders
                    $msg = "We have received your transaction at PRALLIE. Thank you for shopping with us.\r\n\r\n*** This is an automatically generated email, please do not reply ***";
                    $msg = wordwrap($msg,70);
                    mail($email,"Transaction at PRALLIE Successful",$msg);
                }

                $msg = "A customer (ID:" . $customer_id . ") has made a transaction (ID:" . $order_id . ").\r\n\r\n*** This is an automatically generated email, please do not reply ***";
                $msg = wordwrap($msg,70);
                mail( "f36im@EE-IM-4717","New Transaction at PRALLIE",$msg);

                //Remove cart items that are purchased
                array_splice($_SESSION["cart"],0,sizeof($items));

                //Auto login if account is created
                if ($create_account) {
                    $_SESSION["username"] = $name;
                    $_SESSION["email"] = $email;
                    $_SESSION["role"] = "USER";
                }

                $isSuccessTransaction = true;
            } else {
                $query = 'ROLLBACK;';
                $conn->query($query);
                if (!$emailregistered && empty($outofstock) && $isvalidcard) {
                  include_once ('./php/error.php');
                  exit();
                }
            }
        }

        if (!isset($_POST["buy"]) || $emailregistered || !empty($outofstock) || !$isvalidcard || $isSuccessTransaction) {
            //Before checkout form is submitted
            include_once('./php/nav.php') ;
            $empty_cart = false;
            if (!isset($_SESSION["cart"]) || empty($_SESSION["cart"])) {
                //Nothing to check out
                $empty_cart = true;
            } else {
                //Build an array of product IDs in the cart to facilitate single query only
                $product_ids = array();
                foreach ($_SESSION["cart"] as $cart_item) {
                    $product_id = $cart_item->id;
                    if (!in_array($product_id, $product_ids)) {
                        array_push($product_ids, $product_id);
                    }
                }

                $field = '(';
                $first = true;
                foreach ($product_ids as $product_id) {
                    if($first) {
                        $field .= $product_id;
                        $first = false;
                    } else {
                        $field .= ',' . $product_id;
                    }
                }
                $field .= ')';

                $query = 'SELECT p.id, p.name, p.price, p.discount FROM products AS p WHERE p.id IN ' . $field . ';';
                $result = $conn->query($query);

                $product_names = array();
                $product_prices = array();
                if($result) {
                    $num_rows = $result->num_rows;
                    if ($num_rows > 0) {
                        for ($i = 0; $i < $num_rows; $i++) {
                            $row = $result->fetch_assoc();
                            $id = $row["id"];
                            $name = $row["name"];
                            $price_after_discount = (1 - $row["discount"]/(float)100) * $row["price"];
                            $product_prices[$id] = $price_after_discount;
                            $product_names[$id] = $name;
                        }
                    }
                    $result->free();
                } else {
                    //Unable to query database for products price
                    include_once ('./php/error.php');
                    exit();
                }
            }

            //Handle page display
            $is_logged_in = true;
            $row;
            if (!isset($_SESSION["username"]) || empty(trim($_SESSION["username"])) || !isset($_SESSION["email"]) || empty(trim($_SESSION["email"]))) {
                $is_logged_in = false;
            } else {
                $query = 'SELECT c.address, c.gender, c.phone, c.country, c.birthday FROM customers AS c, accounts AS a WHERE c.id = a.customersID  AND a.email="' . $_SESSION["email"] . '" AND c.fullName="' . $_SESSION["username"] . '";';
                $result = $conn->query($query);
                if (!result) {
                    //Failed to query
                    $is_logged_in = false;
                }

                if ($result->num_rows != 1) {
                    //echo $query;
                    $is_logged_in = false;
                } else {
                    $row = $result->fetch_assoc();
                }
                $result->free();
            }
            echo '  <section class="checkout">
                    <div class="container">
                        <form id="checkout" method="post" action="checkout.php" onsubmit="return validateCheckout();">
                            <input type="hidden" name="buy">
                            <div class="row">
                                <div class="four column">
                                    <section class="stepper">
                                        <div class="stepper__header">
                                            <div class="stepper__index">
                                                <h3>1</h3>
                                            </div>
                                            <div class="stepper__step-name">
                                                <h3>Billing Address</h3>
                                            </div>
                                        </div>
                                        <div class="stepper__content">' .
                ($is_logged_in ? '' : '<div class="u-m-medium--bottom">Already registered? <a onclick="spawnModal(HTML_LOGIN)">Sign in to your account.</a></div>
                                            <div class="u-m-medium--bottom">Or enter new billing address</div>') .
                                            '<table class="u-fill">
                                                <tbody class="checkout__section">
                                                    <tr class="checkout__row">
                                                        <td>
                                                            <label class="label--required">Full Name</label>
                                                        </td>
                                                        <td>
                                                            <span class="input">
                                                                <input type="text" name="name" id="name" class="input--text u-fill" placeholder="Your full name"' . ($is_logged_in ? (' value="' . $_SESSION["username"] . '" disabled') : (!empty(trim($_POST["name"])) ? ' value="' . $_POST["name"] . '"' : '')) . ' onblur="validateName()" required>
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    <tr class="checkout__row">
                                                        <td>
                                                            <label class="label--required">Address</label>
                                                        </td>
                                                        <td>
                                                            <span class="input">
                                                                <input type="text" name="address" id="address" class="input--text u-fill" placeholder="Delivery address"' . ($is_logged_in ? (' value="' . $row["address"] . '" disabled') : (!empty(trim($_POST["address"])) ? ' value="' . $_POST["address"] . '"' : '')) . ' required>
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    <tr class="checkout__row">
                                                        <td>
                                                            <label>Gender</label>
                                                        </td>
                                                        <td>
                                                            <span class="input">
                                                                <label for="gender--men" class="label--radio u-inline-block u-m-medium--right">
                                                                    <input type="radio" name="gender" value="men" id="gender--men" class="input--radio"' . ($is_logged_in ? ($row["gender"] == "M" ? ' checked disabled' : ' disabled') : (isset($_POST["gender"]) && $_POST["gender"] == "men" ? ' checked' : '')) . '>
                                                                    Men
                                                                </label>
                                                                <label for="gender--women" class="label--radio u-inline-block">
                                                                    <input type="radio" name="gender" value="women" id="gender--women" class="input--radio"' . ($is_logged_in ? ($row["gender"] == "W" ? ' checked disabled' : ' disabled') : (isset($_POST["gender"]) && $_POST["gender"] == "women" ? ' checked' : '')) . '>
                                                                    Women
                                                                </label>
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    <tr class="checkout__row">
                                                        <td>
                                                            <label class="label--required">Phone No.</label>
                                                        </td>
                                                        <td>
                                                            <span class="input">
                                                                <input type="text" name="phone" id="phone" class="input--text u-fill" placeholder="Phone number"' . ($is_logged_in ? (' value="' . $row["phone"] . '" disabled') : (!empty(trim($_POST["phone"])) ? ' value="' . $_POST["phone"] . '"' : '')) . ' onblur="validatePhone()" required>
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    <tr class="checkout__row">
                                                        <td>
                                                            <label class="label--required">Country</label>
                                                        </td>
                                                        <td>
                                                            <span class="input">';

            if ($is_logged_in ) {
                echo '                                          <input type="text" name="country" id="country" class="input--text u-fill" placeholder="Country of residence" value="' . $row["country"] . '" disabled>';
            } else {
                echo '                                          <select name="country" id="country" class="input--text u-fill">';
                foreach ($countries as $country) {
                    echo '                                          <option value="' . $country . '"' . (isset($_POST["country"]) && $_POST["country"] == $country ? ' selected ' : '') . '>' . $country . '</option>';
                }
                echo '                                          </select>';
            }


            echo '                                          </span>
                                                        </td>
                                                    </tr>
                                                    <tr class="checkout__row">
                                                        <td>
                                                            <label>Birthday</label>
                                                        </td>
                                                        <td>
                                                            <span class="input">
                                                                <input type="text" name="birthday" id="birthday" onblur="validateBirthday()" class="input--date u-fill"' . ($is_logged_in ? (' value="' . $row["birthday"] . '" disabled') : (!empty(trim($_POST["birthday"])) ? ' value="' . $_POST["birthday"] . '"' : '')) . '>
                                                            </span>
                                                        </td>
                                                    </tr>
                                                </tbody>';

            if (!$is_logged_in) {
                echo '                          <tbody>
                                                    <tr class="checkout__row">
                                                        <td colspan="2">
                                                            <label for="create-account" class="label--checkbox">
                                                                <input type="checkbox" name="create-account" id="create-account" class="input--checkbox" onchange="toggleAccountCheckout(this)"' . (isset($_POST["create-account"]) ? ' checked' : '') . ' >
                                                                Create account for later use.
                                                            </label>
                                                        </td>
                                                    </tr>
                                                    <!-- HIDE IF #create-account !checked -->
                                                    <!-- default not checked -->
                                                    <!-- add `required` attribute if checked -->
                                                    <!-- remove `u-is-hidden` class if checked -->
                                                    <tr class="checkout__row' . (isset($_POST["create-account"]) ? '' : ' u-is-hidden')  . '" id="checkout-email">
                                                        <td>
                                                            <label class="label--required">Email</label>
                                                        </td>
                                                        <td>
                                                            <span class="input' . ($emailregistered ? ' input--invalid" data-attr="Email already registered"' : '"') . '>
                                                                <input type="text" name="email" id="email" class="input--text u-fill" placeholder="name@email.com" onblur="validateEmail()"' . (!empty(trim($_POST["email"])) ? ' value="' . $_POST["email"] . '" ' : '') . '>
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    <tr class="checkout__row' . (isset($_POST["create-account"]) ? '' : ' u-is-hidden')  . '" id="checkout-password">
                                                        <td>
                                                            <label class="label--required">Password</label>
                                                        </td>
                                                        <td>
                                                            <span class="input">
                                                                <input type="password" name="password" id="password" class="input--text u-fill" placeholder="Enter password" onblur="validatePassword()">
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    <tr class="checkout__row' . (isset($_POST["create-account"]) ? '' : ' u-is-hidden')  . '" id="checkout-password-verify">
                                                        <td>
                                                            <label class="label--required">Verify Password</label>
                                                        </td>
                                                        <td>
                                                            <span class="input">
                                                                <input type="password" name="password--verify" id="password--verify" class="input--text u-fill" placeholder="Re-enter password" onblur="verifyPassword()">
                                                            </span>
                                                        </td>
                                                    </tr>
                                                </tbody>';
            }

            echo '                          </table>
                                        </div>
                                    </section>
                                </div>
                                <div class="four column">
                                    <section class="stepper">
                                        <div class="stepper__header">
                                            <div class="stepper__index">
                                                <h3>2</h3>
                                            </div>
                                            <div class="stepper__step-name">
                                                <h3>Shipping Address</h3>
                                            </div>
                                        </div>
                                        <div>
                                            <label for="shipping--standard" class="label--radio u-inline-block u-m-medium--bottom">
                                                <input type="radio" name="shipping" value="standard" id="shipping--standard" class="input--radio" onchange="updateShipping(this)"' . (isset($_POST["shipping"]) && $_POST["shipping"] == "standard" ? ' checked ' : '') .  'required>
                                                <span><strong>Standard</strong></span>
                                                <br>
                                                <span>Delivery fee $6.00, 1-3 working days</span>
                                            </label>
                                            <label for="shipping--express" class="label--radio u-inline-block u-m-medium--bottom">
                                                <input type="radio" name="shipping" value="express" id="shipping--express" class="input--radio" onchange="updateShipping(this)"' . (isset($_POST["shipping"]) && $_POST["shipping"] == "express" ? ' checked' : '') .  '>
                                                <span><strong>Express</strong></span>
                                                <br>
                                                <span>Delivery fee $18.00, next day</span>
                                            </label>
                                        </div>
                                    </section>
                                    <section class="stepper">
                                        <div class="stepper__header">
                                            <div class="stepper__index">
                                                <h3>3</h3>
                                            </div>
                                            <div class="stepper__step-name">
                                                <h3>Payment Method</h3>
                                            </div>
                                        </div>
                                        <h4 class="u-m-medium--bottom">Secure Payment</h4>
                                        <span' . ($isvalidcard ? '' : ' data-attr="Invalid credit card" class="input input--invalid" ') . '><h4 id="credit-card-header" class="u-m-medium--bottom">Credit Card</h4></span>
                                        <table class="u-fill">
                                            <tbody class="checkout__section">
                                                <tr class="checkout__row" class="label--required">
                                                    <td>
                                                        <label class="label--required">Card Type</label>
                                                    </td>
                                                    <td>
                                                        <span class="input">
                                                            <select onchange="removeCardError()" name="card-type" class="select u-fill">
                                                                <option value="0"' . (isset($_POST["card-type"]) && $_POST["card-type"] == "0" ? ' selected ' : '') . '>VISA</option>
                                                                <option value="1"' . (isset($_POST["card-type"]) && $_POST["card-type"] == "1" ? ' selected ' : '') . '>MasterCard</option>
                                                            </select>
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr class="checkout__row">
                                                    <td>
                                                        <label class="label--required">Card Number</label>
                                                    </td>
                                                    <td>
                                                        <span class="input">
                                                            <input type="text" onblur="validateCardNumber()" name="card-number" id="card-number" class="input--text u-fill"' . (!empty(trim($_POST["card-number"])) ? ' value="' . $_POST["card-number"] . '" ' : '') . 'required>
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr class="checkout__row">
                                                    <td>
                                                        <label class="label--required">Expiry Date</label>
                                                    </td>
                                                    <td>
                                                        <span class="input">
                                                            <div id="payment__expiry" class="payment__expiry">
                                                                <select onchange="removeCardError()" name="card-month" class="select u-m-medium--right u-flex-2">
                                                                    <option value="1"' . (isset($_POST["card-month"]) ? ($_POST["card-month"] == "1" ? ' selected ' : '') : ' selected ') . '>January</option>
                                                                    <option value="2"' . (isset($_POST["card-month"]) && $_POST["card-month"] == "2" ? ' selected ' : '') . '>February</option>
                                                                    <option value="3"' . (isset($_POST["card-month"]) && $_POST["card-month"] == "3" ? ' selected ' : '') . '>March</option>
                                                                    <option value="4"' . (isset($_POST["card-month"]) && $_POST["card-month"] == "4" ? ' selected ' : '') . '>April</option>
                                                                    <option value="5"' . (isset($_POST["card-month"]) && $_POST["card-month"] == "5" ? ' selected ' : '') . '>May</option>
                                                                    <option value="6"' . (isset($_POST["card-month"]) && $_POST["card-month"] == "6" ? ' selected ' : '') . '>June</option>
                                                                    <option value="7"' . (isset($_POST["card-month"]) && $_POST["card-month"] == "7" ? ' selected ' : '') . '>July</option>
                                                                    <option value="8"' . (isset($_POST["card-month"]) && $_POST["card-month"] == "8" ? ' selected ' : '') . '>August</option>
                                                                    <option value="9"' . (isset($_POST["card-month"]) && $_POST["card-month"] == "9" ? ' selected ' : '') . '>September</option>
                                                                    <option value="10"' . (isset($_POST["card-month"]) && $_POST["card-month"] == "10" ? ' selected ' : '') . '>October</option>
                                                                    <option value="11"' . (isset($_POST["card-month"]) && $_POST["card-month"] == "11" ? ' selected ' : '') . '>November</option>
                                                                    <option value="12"' . (isset($_POST["card-month"]) && $_POST["card-month"] == "12" ? ' selected ' : '') . '>December</option>
                                                                </select>
                                                                <input type="text" onblur="validateCardYear()" id="card-year" class="input--text" name="card-year" size="5" maxlength="4" placeholder="Year"' . (!empty(trim($_POST["card-year"])) ? ' value="' . $_POST["card-year"] . '" ' : '') . '>
                                                            </div>
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr class="checkout__row">
                                                    <td>
                                                        <label class="label--required">CVV</label>
                                                    </td>
                                                    <td>
                                                        <input type="text" onblur="validateCardCVV()" name="card-cvv" id="card-cvv"  maxlength="4" class="input--text"' . (!empty(trim($_POST["card-cvv"])) ? ' value="' . $_POST["card-cvv"] . '" ' : '') . 'required>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </section>
                                </div>
                                <div class="four column">
                                    <section class="stepper">
                                        <div class="stepper__header">
                                            <div class="stepper__index">
                                                <h3>4</h3>
                                            </div>
                                            <div class="stepper__step-name">
                                                <h3>Order Confirmation</h3>
                                            </div>
                                        </div>
                                        <table class="u-fill">
                                            <tr class="table__row">
                                                <th>Item</th>
                                                <th class="u-align--center">Quantity</th>
                                                <th class="u-align--right">Subtotal</th>
                                            </tr>';

            if (!$empty_cart) {
                $price_sum = 0;
                foreach ($_SESSION["cart"] as $cart_item) {
                    $id = $cart_item->id;
                    $name = $product_names[$id];
                    $color = $cart_item->color;
                    $size = $cart_item->size;
                    $qty = $cart_item->quantity;
                    $prices_per_item = $product_prices[$id];
                    $price_subtotal = $qty*$prices_per_item;
                    $price_sum += $price_subtotal;
                    if (in_array($id . '_' . $color . '_' . $size , $outofstock)) {
                        echo '      <tr style="color:red;" class="table__row">
                                      <td>' . $name . ' (' . ucfirst($color) . ',' . $size . ')</td>
                                      <td class="u-align--center">Out of Stock</td>
                                      <td class="u-align--right">N/A</td>
                                    </tr>';
                        echo '      <input type="hidden" name="items[]" value="' . $id . '_' . $color . '_' . $size . '_' . $qty . '">';
                    } else {
                        echo '  <tr class="table__row">
                                                      <td>' . $name . ' (' . ucfirst($color) . ',' . $size . ')</td>
                                                      <td class="u-align--center">' . $qty . '</td>
                                                      <td class="u-align--right">$' . number_format($price_subtotal,2) . '</td>
                                                    </tr>';
                        echo '<input type="hidden" name="items[]" value="' . $id . '_' . $color . '_' . $size . '_' . $qty . '">';
                    }

                }

                if (empty($outofstock)) {
                    echo '                <tr class="table__row">
                                                    <td colspan="2" class="u-align--left">
                                                        <div>Subtotal</div>
                                                        <div>Shipping</div>
                                                        <div><h3 class="header u-m-medium--top">Grand Total</h3></div>
                                                    </td>
                                                    <td class="u-align--right">
                                                        <div>$ <span id="subtotal-price">' . number_format($price_sum,2) . '</span></div>
                                                        <div>$ <span id="shipping-price">0.00</span></div>
                                                        <div><h3 class="header u-m-medium--top">$ <span id="grandtotal-price">' . number_format($price_sum, 2) . '</span></h3></div>
                                                    </td>
                                                </tr>
                                            </table>
                                            <div class="bag__order">
                                                <button type="submit" class="button button--primary button--large">
                                                    Place Order Now
                                                </button>
                                            </div>';
                } else {
                    echo '                      <tr class="table__row"><td colspan="3">Unable to make transaction. Some items are out of stock.</td></tr>
                                            </table>';
                }

            } else {
                echo '                          <tr class="table__row">' . ($isSuccessTransaction ? '<td colspan="3" style="color:green;">Items successfuly purchased</td>' :  '<td colspan="3">No item found.</td></tr>' ) .
                                            '</table>';
            }

            echo '                      </section>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </section>';
        }
        $conn->close();
	    include './php/footer.php';
    ?>
	<script type="text/javascript" src='./js/global.js'></script>
</body>
</html>