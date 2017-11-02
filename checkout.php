<!DOCTYPE html>
<html lang="en-GB">
<?php include './php/head.php'; ?>
<body class="debug o f h d">
	<?php
        /* To-do:
         * -Price for shipping appears only after shipping type is selected
         * -Real time compute total value
         * -Input validation
         * -Create account for later use
         * -Auto-fill if logged in
         */
        include './php/cart-item.php';
        session_start();
        //Connect to database
        $conn = new mysqli("localhost", "f36im", "f36im", "f36im");

        if ($conn->connect_error) {
            //Fallback if unable to connect to database
            exit();
        }

        $countries = array("Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola",
            "Anguilla", "Antarctica", "Antigua and Brarbuda", "Argentina", "Armenia", "Aruba", "Australia",
            "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium",
            "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island",
            "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi",
            "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile",
            "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the",
            "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti",
            "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia",
            "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana",
            "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland",
            "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands",
            "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)",
            "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati",
            "Korea, Democratic People's Republic of", "Korea, Republic of",
            "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya",
            "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia",
            "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico",
            "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique",
            "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua",
            "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama",
            "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania",
            "Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino",
            "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia",
            "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena",
            "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland",
            "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo",
            "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda",
            "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan",
            "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara",
            "Yemen", "Yugoslavia", "Zambia", "Zimbabwe");

        if (isset($_POST["buy"])) {
            $items = $_POST["items"];
            $name = $_POST["name"];
            $address = $_POST["address"];
            $phone = $_POST["phone"];
            $country = $_POST["country"];
            $create_account = $_POST["create-account"];
            $shipping = $_POST["shipping"];
            $validinput = true;


            preg_match('/[a-zA-Z\s]+/', $name, $matches_name);
            preg_match('/^\+?[\d-]+$/', $phone, $matches_phone);

            //Validate name, address, phone, country, shipping
            if (!isset($items) || empty(trim($name)) || empty(trim($address)) || empty(trim($country)) || empty(trim($phone)) ||
            ($shipping != "standard" && $shipping != "express") || empty($matches_name) || empty($matches_phone) || !in_array($country, $countries)) {
                $validinput = false;
            }

            //Validate items format
            $product_ids = array();
            $product_color = array();
            $product_size = array();
            $product_qty = array();
            $unique_product_ids = array();
            if ($validinput) {
                foreach ($items as $item) {
                    preg_match('/^(\d+)_([a-z]+)_([A-Z]+)_(\d+)/', $item, $matches_item);
                    if (empty($matches_item)) {
                        $validinput = false;
                        break;
                    } else {
                        $id = $matches_item[1];
                        array_push($product_ids, $id);
                        array_push($product_color, ucfirst($matches_item[2]));
                        array_push($product_size, $matches_item[3]);
                        array_push($product_qty, $matches_item[4]);
                        if (!in_array($id, $unique_product_ids)) {
                            array_push($unique_product_ids, $id);
                        }
                    }
                }
            }

            //Get product prices
            $product_prices = array();
            if ($validinput) {
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
                        $validinput = false;
                    }
                } else {
                    //Unable to query for price
                    exit();
                }
            }

            //Begin transaction. Commit to database only if all queries are successful.
            if ($validinput) {
                $query = "START TRANSACTION;";
                $conn->query($query);

                $gender = ucfirst(trim($_POST["gender"]));
                $birthday = trim($_POST["birthday"]);

                $query = "INSERT INTO customers (fullName, address, country, phone";

                $insert_gender = false;
                if ($gender[0] == 'M' || $gender[0] == 'W') {
                    $query .= ', gender';
                    $insert_gender = true;
                }

                $insert_birthday = false;
                if (!empty($birthday)) {
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
                $result = $conn->query($query);
                if(!$result) {
                    //Unable to insert into customers table

                    $conn->query("ROLLBACK;");
                    exit();
                }

                if ($conn->affected_rows != 1) {

                    $conn->query("ROLLBACK;");
                    exit();
                }

                $customer_id = $conn->insert_id;

                if ($create_account) {
                    $email = trim($_POST["email"]);
                    $password = $_POST["password"];
                    $query = 'INSERT INTO accounts (customersID, email, password, role) VALUES(' . $customer_id . ',"' . $email . '","' . $password . '","USER");';
                    $result = $conn->query($query);
                    if(!$result) {

                        //Unable to insert into accounts table
                        $conn->query("ROLLBACK;");
                        exit();
                    }

                    if ($conn->affected_rows != 1) {
                        $conn->query("ROLLBACK;");
                        exit();
                    }
                }

                $query = 'INSERT INTO orders (customersID, ordersDate, shipping) VALUES(' . $customer_id . ', NOW(),"' . strtoupper($shipping[0]) . '");';
                $result = $conn->query($query);
                if(!$result) {
                    //Unable to insert into orders table
                    $conn->query("ROLLBACK;");
                    exit();
                }

                if ($conn->affected_rows != 1) {
                    $conn->query("ROLLBACK;");
                    exit();
                }

                $order_id = $conn->insert_id;

                for ($i = 0; $i < sizeof($product_ids); $i++) {
                    $id = $product_ids[$i];

                    //Get inventory id
                    $query = 'SELECT i.id FROM inventory AS i WHERE i.productsID = '. $id . ' AND i.color = "' . $product_color[$i] .
                        '" AND i.size = "' . $product_size[$i] . '";';
                    $result = $conn->query($query);
                    if(!$result) {
                        //Unable to get from inventory table
                        $conn->query("ROLLBACK;");
                        exit();
                    }
                    if ($result->num_rows != 1) { //Inconsistencies in database?
                        $conn->query("ROLLBACK;");
                        exit();
                    }
                    $row = $result->fetch_assoc();
                    $inventory_id = $row["id"];

                    //Populate orders_inventory table
                    $query = 'INSERT INTO orders_inventory (inventoryID, ordersID, pricePerItem, quantity) VALUES (' . $inventory_id . ',' . $order_id .
                        ',' . $product_prices[$id] . ',' . $product_qty[$i] . ');';
                    $result = $conn->query($query);
                    if(!$result) {
                        //Unable to insert into orders table
                        $conn->query("ROLLBACK;");
                        exit();
                    }

                    if ($conn->affected_rows != 1) {
                        $conn->query("ROLLBACK;");
                        exit();
                    }

                    $query = 'UPDATE inventory SET stock = stock - ' . $product_qty[$i] . ' WHERE id=' . $inventory_id .' AND stock >= ' . $product_qty[$i]
                    . ';';
                    $result = $conn->query($query);
                    if(!$result) {
                        //Unable to insert into orders table
                        $conn->query("ROLLBACK;");
                        exit();
                    }

                    if ($conn->affected_rows != 1) {
                        $conn->query("ROLLBACK;");
                        exit();
                    }
                }

                $query = 'COMMIT;';
                $conn->query($query);
                echo 'SUCCESS!';
                //Remove cart items that are purchased
                array_splice($_SESSION["cart"],0,sizeof($items));
            } else {
                //Some input is not valid
            }
        }

        include './php/nav.php';

        if (!isset($_SESSION["cart"]) || empty($_SESSION["cart"])) {
            //Nothing to check out, also to display successful transaction result
            echo 'Nothing to check out';
            exit();
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
            } else {
                //Unable to query database for products price
                exit();
            }
        }
    ?>
	<section class="checkout">
		<div class="container">
			<form id="checkout" method="post" action="checkout.php">
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
							<div class="stepper__content">
								<div class="u-m-medium--bottom">Already registered? <a onclick="spawnModal(HTML_LOGIN)">Sign in to your account.</a></div>
								<div class="u-m-medium--bottom">Or enter new billing address</div>
								<table class="u-fill">
									<tbody class="checkout__section">
										<tr class="checkout__row">
											<td>
												<label class="label--required">Full Name</label>
											</td>
											<td>
												<span class="input">
													<input type="text" name="name" id="name" class="input--text u-fill" placeholder="Your full name" required>
												</span>
											</td>
										</tr>
										<tr class="checkout__row">
											<td>
												<label class="label--required">Address</label>
											</td>
											<td>
												<span class="input">
													<input type="text" name="address" id="address" class="input--text u-fill" placeholder="Delivery address" required>
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
														<input type="radio" name="gender" value="men" id="gender--men" class="input--radio">
														Women
													</label>
													<label for="gender--women" class="label--radio u-inline-block">
														<input type="radio" name="gender" value="women" id="gender--women" class="input--radio">
														Men
													</label>
												</span>
											</td>
										</tr>
										<tr class="checkout__row" class="label--required">
											<td>
												<label>Phone No.</label>
											</td>
											<td>
												<span class="input">
													<input type="text" name="phone" id="phone" class="input--text u-fill" placeholder="Phone number" required>
												</span>
											</td>
										</tr>
										<tr class="checkout__row">
											<td>
												<label>Country</label>
											</td>
											<td>
												<!-- <span class="popup">Input is invalid</span> -->
												<span class="input">
													<input type="text" name="country" id="country" class="input--text u-fill" placeholder="Country of residence">
												</span>
											</td>
										</tr>
										<tr class="checkout__row">
											<td>
												<label>Birthday</label>
											</td>
											<td>
												<span class="input">
													<input type="date" name="birthday" id="birthday" class="input--date u-fill">
												</span>
											</td>
										</tr>
									</tbody>
									<tbody>
										<tr class="checkout__row">
											<td colspan="2">
												<label for="create-account" class="label--checkbox">
													<input type="checkbox" name="create-account" id="create-account" class="input--checkbox">
													Create account for later use.
												</label>
											</td>
										</tr>
										<!-- HIDE IF #create-account !checked -->
										<!-- default not checked -->
										<!-- add `required` attribute if checked -->
										<!-- remove `u-is-hidden` class if checked -->
										<tr class="checkout__row u-is-hidden">
											<td>
												<label class="label--required">Email</label>
											</td>
											<td>
												<span class="input">
													<input type="text" name="email" id="email" class="input--text u-fill" placeholder="name@email.com">
												</span>
											</td>
										</tr>
										<tr class="checkout__row u-is-hidden">
											<td>
												<label class="label--required">Password</label>
											</td>
											<td>
												<span class="input">
													<input type="password" name="password" id="password" class="input--text u-fill" placeholder="Enter password">
												</span>
											</td>
										</tr>
										<tr class="checkout__row u-is-hidden">
											<td>
												<label class="label--required">Verify Password</label>
											</td>
											<td>
												<span class="input">
													<input type="password" name="password--verify" id="password--verify" class="input--text u-fill" placeholder="Re-enter password">
												</span>
											</td>
										</tr>
									</tbody>
								</table>
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
									<input type="radio" name="shipping" value="standard" id="shipping--standard" class="input--radio">
									<span><strong>Standard</strong></span>
									<br>
									<span>Delivery fee $6.00, 1-3 working days</span>
								</label>
								<label for="shipping--express" class="label--radio u-inline-block u-m-medium--bottom">
									<input type="radio" name="shipping" value="express" id="shipping--express" class="input--radio">
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
							<h4 class="u-m-medium--bottom">Credit Card</h4>
							<table class="u-fill">
								<tbody class="checkout__section">
									<tr class="checkout__row" class="label--required">
										<td>
											<label class="label--required">Card Type</label>
										</td>
										<td>
											<span class="input">
												<select class="select u-fill">
													<option value="visa">VISA</option>
													<option value="mastercard">MasterCard</option>
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
												<input type="text" name="card-number" id="card-number" class="input--text u-fill" required>
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
													<select class="select u-m-medium--right u-flex-2">
														<option value="January" selected="selected">January</option>
														<option value="February">February</option>
														<option value="March">March</option>
														<option value="April">April</option>
														<option value="May">May</option>
														<option value="June">June</option>
														<option value="July">July</option>
														<option value="August">August</option>
														<option value="September">September</option>
														<option value="October">October</option>
														<option value="November">November</option>
														<option value="December">December</option>
													</select>
													<select class="select u-flex-1">
														<!-- Day option is based on selected month -->
														<option value="1" selected="selected">1</option>
													</select>
												</div>
											</span>
										</td>
									</tr>
									<tr class="checkout__row">
										<td>
											<label class="label--required">CVV</label>
										</td>
										<td>
											<input type="text" name="vcc" id="vcc" class="input--text" required>
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
								</tr>
                                <?php
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
                                        echo '<tr class="table__row">
                                                  <td>' . $name . ' (' . ucfirst($color) . ',' . $size . ')</td>
                                                  <td class="u-align--center">' . $qty . '</td>
                                                  <td class="u-align--right">$' . number_format($price_subtotal,2) . '</td>
                                              </tr>
                                              ';
                                        echo '<input type="hidden" name="items[]" value="' . $id . '_' . $color . '_' . $size . '_' . $qty . '">
                                             ';
                                    }
                                ?>
								<tr class="table__row">
									<td colspan="2" class="u-align--left">
										<div>Subtotal</div>
										<div>Shipping</div>
										<div><h3 class="header u-m-medium--top">Grand Total</h3></div>
									</td>
									<td class="u-align--right">
										<div><?php echo '$'. number_format($price_sum,2); ?></div>
										<div>$6.00</div>
										<div><h3 class="header u-m-medium--top">$45.80</h3></div>
									</td>
								</tr>
							</table>
							<div class="bag__order">
								<button type="submit" class="button button--primary button--large">
									Place Order Now
								</button>
							</div>
						</section>
					</div>
				</div>
			</form>
		</div>
	</section>
	<?php include './php/footer.php' ?>
	<script type="text/javascript" src='./js/global.js'></script>
</body>
</html>