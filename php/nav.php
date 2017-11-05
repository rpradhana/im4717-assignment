<?php
    if ($conn->connect_error) {

    }

    include_once('./php/countries-list.php') ;
    $country_options = '';
    foreach ($countries as $country) {
        $country_options .= '<option value=\"' . $country . '\">' . $country . '</option>';
    }

    echo '  <script type="text/javascript">
                var country_options = "' . $country_options . '";
            </script>';


    if (isset($_POST["todo"])) {
        if ($_POST["todo"] == "register") {
            $name = trim($_POST["name"]);
            $address = trim($_POST["address"]);
            $phone = trim($_POST["phone"]);
            $country = trim($_POST["country"]);
            $gender = ucfirst(trim($_POST["gender"]));
            $birthday = trim($_POST["birthday"]);

            $shouldProcessFurther = true;
            preg_match('/^[A-Za-z]+(\s[A-Za-z]*)*$/', $name, $matches_name);
            preg_match('/\+?(\d-?){8,16}/', $phone, $matches_phone);

            //Validate name, address, phone, country
            if ( empty($name) || empty($address) || empty($country) || empty($phone)
                || empty($matches_name) || empty($matches_phone) || !in_array($country, $countries)) {
                $shouldProcessFurther = false;
            }

            $email = trim($_POST["email"]);
            $password = $_POST["password"];

            preg_match('/^[\w-_\.]+@[\w_-]+(\.[\w_-]+){0,2}\.\w{2,3}$/', $email, $matches_email);

            //Validate email
            if (empty($matches_email)) {
                $shouldProcessFurther = false;
            }

            if (!$shouldProcessFurther) {
                //Input is not valid
            } else {
                $query = "START TRANSACTION;";
                $conn->query($query);

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

                if(!$result) {
                    //Unable to insert into customers table
                    $shouldProcessFurther = false;
                }

                $customer_id = $conn->insert_id;

                if($shouldProcessFurther){
                    $query = 'INSERT INTO accounts (customersID, email, password, role) VALUES(' . $customer_id . ',"' . $email . '","' . $password . '","USER");';
                    $result = $conn->query($query);
                    if(!$result) {
                        //Unable to insert into accounts table
                        $shouldProcessFurther = false;
                        $emailregistered = true;
                    }
                }

                if ($shouldProcessFurther) {
                    //Passed all checks
                    $query = 'COMMIT;';
                    $conn->query($query);
                    echo 'SUCCESS!';
                    //Auto login
                    $_SESSION["username"] = $name;
                    $_SESSION["email"] = $email;
                    $_SESSION["role"] = "USER";

                    //Send email to notify success registration
                    $msg = "We have received your application for membership at PRALLIE. We hope you enjoy your stay.\n\n*** This is an automatically generated email, please do not reply ***";
                    $msg = wordwrap($msg,70);
                    mail($email,"Registration at PRALLIE Successful",$msg);
                } else {
                    $query = 'ROLLBACK;';
                    $conn->query($query);
                    if ($emailregistered) {
                        echo 'Email Registered';
                    } else {
                        echo 'Facing problem';
                    }
                    echo 'FAILED!';
                }
            }

        } else if ($_POST["todo"] == "login") {
            if (isset($_POST["email"]) && isset($_POST["password"])) {
                $email = trim($_POST["email"]);
                $password = $_POST["password"];
                $query = 'SELECT c.fullName, a.email, a.role FROM accounts AS a, customers AS c WHERE c.id = a.customersID AND a.email="' . $email . '" AND password="' . $password . '";';
                $result = $conn->query($query);
                $num_rows = $result->num_rows;
                if ($num_rows != 1) {
                    //Email not found or wrong password
                } else {
                    $row = $result->fetch_assoc();
                    $_SESSION["username"] = $row["fullName"];
                    $_SESSION["email"] = $row["email"];
                    $_SESSION["role"] = $row["role"];
                }
            }
        } else if ($_POST["todo"] == "logout") {
            unset($_SESSION["username"]);
            unset($_SESSION["email"]);
            unset($_SESSION["role"]);
        }
    }

    echo '<nav class="nav">
            <div class="nav--secondary">
                <div class="container">
                    <div class="row">
                        <div class="twelve column" >
                            <div class="row nav__submenu">
                                <a href="./contact.php" class="button submenu__button">Contact</a>
                                <a href="./support.php" class="button submenu__button">Support</a>';
    if (isset($_SESSION["username"])) {
        echo '<a href="profile.php" class="button submenu__button"><strong>Welcome, '.
            $_SESSION["username"] .
            '</strong></a>
             <form name="form-signout" method="post"><input type="hidden" name="todo" value="logout"><span class="button submenu__button" id="submenu__button--logout" onclick="document.forms[\'form-signout\'].submit();"><strong>Sign Out</strong></span></form>';
    } else {
        echo '<span class="button submenu__button" id="submenu__button--register"><strong>Register</strong></span>
              <span class="button submenu__button" id="submenu__button--login"><strong>Sign In</strong></span>';
    }
?>

					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="nav--primary">
		<div class="container">
			<div class="row">
				<div class="twelve column">
					<div class="row nav__menu">
						<a href="./index.php" class="nav__logo"><img src="./images/logo.svg" width="7.5rem"></a>
						<a href="./shop.php?gender[]=W" id="menu__button--women" class="button menu__button">Women</a>
						<a href="./shop.php?gender[]=M" id="menu__button--men" class="button menu__button">Men</a>
						<form class="menu__search" method="get" action="shop.php">
							<input type="text" name="searchstring" class="input--text search__input u-flex-1" placeholder="Search collection">
							<button type="submit" class="button button--secondary search__button">
								<div class="icon">
									<i class="material-icons">search</i>
								</div>
							</button>
						</form>
						<a href="./bag.php" class="button menu__button">
							<!-- <div class="icon button__icon">
								<i class="material-icons">shopping_basket</i>
							</div> -->
							Shopping Bag
							<div class="badge badge--empty button__badge">
                                <?php
                                    /*
                                     * To-do:
                                     * -String search
                                     */
                                    $cart_size = sizeof($_SESSION["cart"]);
                                    echo $cart_size;
                                ?>
							</div>
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="nav--women" class="nav--tertiary">
		<div class="container">
			<div class="row">
				<div class="twelve column u-p-zero">
					<div class="row nav__category">
<!--						<a href="./shop.php?gender[]=W&tag=popular"-->
<!--						   class="button category__button">Popular</a>-->
<!--						<a href="./shop.php?gender[]=W&tag=new"-->
<!--						   class="button category__button">New</a>-->
						<a href="./shop.php?gender[]=W&category[]=SHRT"
						   class="button category__button">Shirts &amp; Blouses</a>
						<a href="./shop.php?gender[]=W&category[]=TSHT"
						   class="button category__button">T-Shirts</a>
						<a href="./shop.php?gender[]=W&category[]=DRSS"
						   class="button category__button">Dresses</a>
						<a href="./shop.php?gender[]=W&category[]=PNTS"
						   class="button category__button">Pants</a>
						<a href="./shop.php?gender[]=W&category[]=SHTS"
						   class="button category__button">Shorts</a>
						<a href="./shop.php?gender[]=W&category[]=SKTS"
						   class="button category__button">Skirts</a>
						<a href="./shop.php?gender[]=W&category[]=OTWR"
						   class="button category__button">Outerwear</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="nav--men" class="nav--tertiary">
		<div class="container">
			<div class="row">
				<div class="twelve column u-p-zero">
					<div class="row nav__category">
<!--						<a href="./shop.php?gender[]=M&tag=popular"-->
<!--						   class="button category__button">Popular</a>-->
<!--						<a href="./shop.php?gender[]=M&tag=new"-->
<!--						   class="button category__button">New</a>-->
						<a href="./shop.php?gender[]=M&category[]=SHRT"
						   class="button category__button">Shirts</a>
						<a href="./shop.php?gender[]=M&category[]=TSHT"
						   class="button category__button">T-Shirts</a>
						<a href="./shop.php?gender[]=M&category[]=PNTS"
						   class="button category__button">Pants</a>
						<a href="./shop.php?gender[]=M&category[]=SHTS"
						   class="button category__button">Shorts</a>
						<a href="./shop.php?gender[]=M&category[]=OTWR"
						   class="button category__button">Outerwear</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</nav>
<div class="nav--fix"></div>
