<?php
    if ($conn->connect_error) {

    }

    if (isset($_POST["register"])) {
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

        $name = $_POST["name"];
        $address = $_POST["address"];
        $phone = $_POST["phone"];
        $country = $_POST["country"];
        $validinput = true;

        preg_match('/[a-zA-Z\s]+/', $name, $matches_name);
        preg_match('/^\+?[\d-]+$/', $phone, $matches_phone);

        //Validate name, address, phone, country, shipping
        if (empty(trim($name)) || empty(trim($address)) || empty(trim($country)) || empty(trim($phone)) ||
            empty($matches_name) || empty($matches_phone) || !in_array($country, $countries)) {
            $validinput = false;
        }


        if (!$validinput) {
            //Input is not valid
            exit();
        }
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

        $query = "COMMIT;";
        $conn->query($query);
        echo 'Success!';
    } else if (isset($_POST["login"])) {
        if (isset($_POST["email"]) && isset($_POST["password"])) {
            $email = trim($_POST["email"]);
            $password = $_POST["password"];
            $query = 'SELECT c.fullName, a.cart, a.role FROM accounts AS a, customers AS c WHERE c.id = a.customersID AND a.email="' . $email . '" AND password="' . $password . '";';
            $result = $conn->query($query);
            $num_rows = $result->num_rows;
            if ($num_rows != 1) {
                //Email not found or wrong password
            } else {
                $row = $result->fetch_assoc();
                $_SESSION["username"] = $row["fullName"];
                //Get cart, get role, etc
            }
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
        echo '<span><strong>Welcome, '. $_SESSION["username"]. '</strong></span>
              <span class="button submenu__button" id="submenu__button--logout"><strong>Sign Out</strong></span>';
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
						<form class="menu__search">
							<input type="text" class="input--text search__input u-flex-1" placeholder="Search collection">
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
						<a href="./shop.php?gender[]=W&tag=popular"
						   class="button category__button">Popular</a>
						<a href="./shop.php?gender[]=W&tag=new"
						   class="button category__button">New</a>
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
						<a href="./shop.php?gender[]=M&tag=popular"
						   class="button category__button">Popular</a>
						<a href="./shop.php?gender[]=M&tag=new"
						   class="button category__button">New</a>
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
