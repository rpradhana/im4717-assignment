<!DOCTYPE html>
<html lang="en-GB">
<?php include './php/head.php'; ?>
<body class="debug o f h d">

	<?php
        session_start();

        //Connect to database
        $conn = new mysqli("localhost", "f36im", "f36im", "f36im");

        if ($conn->connect_error) {
            //Fallback if unable to connect to database
            include_once ('./php/error.php');
            exit();
        }

        include './php/nav.php';
        include_once ('./php/countries-list.php');


        if (isset($_SESSION["username"]) && !empty(trim($_SESSION["username"]))&& isset($_SESSION["email"]) && !empty(trim($_SESSION["email"])) && $_SESSION["role"] == "ADMN") {
                if (isset($_POST["add"])) {
                    $query = "START TRANSACTION";
                    $conn->query($query);

                    $shouldProgress = true;

                    $query = 'INSERT INTO products (name, category, gender, description, price, discount) VALUES ("' . $_POST["name"] . '", "' . $_POST["category"] .
                        '","' . $_POST["gender"] . '","' . $_POST["description"] . '",' . $_POST["price"] . ', ' . $_POST["discount"] . ');';
                    $result = $conn->query($query);

                    if (!result || $conn->affected_rows != 1) {
                        //Fail in inserting product
                        $shouldProgress = false;
                    }

                    $product_id = $conn->insert_id;
                    //Need to chown ./images/ to allow uploads
                    $target_dir = "./images/";

                    if ($shouldProgress) {
                        for ($i = 0; $i < sizeof($_POST["color"]); $i++) {
                            $color = $_POST["color"][$i];
                            $size = $_POST["size"][$i];
                            $stock = $_POST["stock"][$i];

                            //Insert into inventory
                            $query = 'INSERT INTO inventory (productsID, color, size, stock) VALUES("' . $product_id . '", "' . $color . '","' . $size . '",' . $stock . ');';
                            $result = $conn->query($query);
                            if (!result || $conn->affected_rows != 1) {
                                //Fail in inserting inventory
                                $shouldProgress = false;
                                break;
                            }

                            //Upload image if not already done
                            $target_file = $target_dir . $product_id . '_' . lcfirst($color) . '.jpg';
                            $imageFileType = pathinfo($_FILES["image"]["name"][$i], PATHINFO_EXTENSION);

                             // Check if image file is a actual image or fake image
                            if (isset($_POST["submit"])) {
                                $check = getimagesize($_FILES["image"]["tmp_name"][$i]);
                                if (!$check) {
                                    $shouldProgress = false;
                                    break;
                                }
                            }

                            // Check if file already exists
                            if (file_exists($target_file)) {
                                continue;
                            }

                             // Check file size
                            if ($_FILES["image"]["size"][$i] > 5000000) {
                                $shouldProgress = false;
                                break;
                            }

                             // Allow only jpg
                            if ($imageFileType != "jpg") {
                                $shouldProgress = false;
                                break;
                            }


                             if (!move_uploaded_file($_FILES["image"]["tmp_name"][$i],  $target_file)) {
                                 $shouldProgress = false;
                                 break;
                             }
                        }
                    }

                    if ($shouldProgress) {
                        $query = "COMMIT;";
                        $conn->query($query);
                        echo 'SUCCESS!';
                    } else {
                        $query = "ROLLBACK;";
                        $conn->query($query);
                        echo 'FAILED!';
                    }
                }

                echo '<script src="./js/JSAddItem.js" type="text/javascript"></script>';
                echo '  <section class="profile">
                            <div class="container">
                                <div class="row">
                                    <div class="two column"></div>
                                    <div class="two column">
                                        <aside>
                                            <div class="profile__name">
                                                <h4 class="header">' . $_SESSION["username"] . '</h4>
                                            </div>
                                            <a href="./profile.php" class="button button--large profile__menu profile__menu">
                                                My Profile
                                            </a>
                                            <a href="./past-orders.php" class="button button--large profile__menu">
                                                Past Orders
                                            </a>                
                                            <a href="./add.php" class="button button--large profile__menu--active">
                                                Add Product
                                            </a>
                                            </aside>
                                    </div>
                                    <div class="six column">
                                        <form method="post" action="add.php" enctype="multipart/form-data">
                                            <input type="hidden" name="add">
                                            <h2 class="header u-m-large--bottom">Add New Product</h2>
                                            <div class="u-flex">
                                               <div class="u-m-medium--bottom">
                                                    <label for="name" class="label--top">
                                                        Product Name
                                                    </label>
                                                    <input type="text" name="name" id="name" class="input--text u-fill" placeholder="Product Name">
                                               </div>
                                               <div class="u-m-medium--bottom">
                                                    <label for="category" class="label--top">
                                                        Category
                                                    </label>
                                                    <label for="category--SHRT" class="label--radio u-inline-block u-m-medium--right">
                                                        <input type="radio" name="category" value="SHRT" id="category--SHRT" class="input--radio" required>
                                                        Shirts & Blouses
                                                    </label>
                                                    <label for="category--TSHT" class="label--radio u-inline-block u-m-medium--right">
                                                        <input type="radio" name="category" value="TSHT" id="category--TSHT" class="input--radio">
                                                        T-Shirts
                                                    </label>
                                                    <label for="category--DRSS" class="label--radio u-inline-block u-m-medium--right">
                                                        <input type="radio" name="category" value="DRSS" id="category--DRSS" class="input--radio">
                                                        Dresses
                                                    </label>
                                                    <label for="category--PNTS" class="label--radio u-inline-block u-m-medium--right">
                                                        <input type="radio" name="category" value="PNTS" id="category--PNTS" class="input--radio">
                                                        Pants
                                                    </label>
                                                    <label for="category--SHTS" class="label--radio u-inline-block u-m-medium--right">
                                                        <input type="radio" name="category" value="SHTS" id="category--SHTS" class="input--radio">
                                                        Shorts
                                                    </label>
                                                    <label for="category--SKTS" class="label--radio u-inline-block u-m-medium--right">
                                                        <input type="radio" name="category" value="SKTS" id="category--SKTS" class="input--radio">
                                                        Skirts
                                                    </label>
                                                    <label for="category--OTWR" class="label--radio u-inline-block u-m-medium--right">
                                                        <input type="radio" name="category" value="OTWR" id="category--OTWR" class="input--radio">
                                                        Outerwear
                                                    </label>
                                               </div>

                                               <div class="u-m-medium--bottom">
                                                    <label for="gender" class="label--top">
                                                        Gender
                                                    </label>
                                                    <label for="gender--men" class="label--radio u-inline-block u-m-medium--right">
                                                        <input type="radio" name="gender" value="M" id="gender--men" class="input--radio" required>
                                                        Men
                                                    </label>
                                                    <label for="gender--women" class="label--radio u-inline-block">
                                                        <input type="radio" name="gender" value="W" id="gender--women" class="input--radio">
                                                        Women
                                                    </label>
                                               </div>
                                               <div class="u-m-medium--bottom">
                                                    <label for="description" class="label--top">
                                                        Product Description
                                                    </label>
                                                    <textarea maxlength="500" name="description" id="description" class="input--text u-fill" placeholder="Product Description" required>
                                                    </textarea>
                                               </div>
                                               <div class="u-m-medium--bottom">
                                                    <label for="price" class="label--top">
                                                        Price
                                                    </label>
                                                    <input type="text" min="0" name="price" id="price" class="input--text u-fill" placeholder="Product Price" required>
                                               </div>
                                               <div class="u-m-medium--bottom">
                                                    <label for="discount" class="label--top">
                                                        Discount
                                                    </label>
                                                    <input type="text" min="0" name="discount" id="discount" class="input--text u-fill" placeholder="Discount in percentage" required>
                                               </div>
                                               <div class="u-m-medium--bottom">
                                                   <label class="label--top">
                                                        Inventory
                                                    </label>
                                                    <div id="inventories">
                                                    </div>
                                                   
                                                </div>     
                                               <div class="u-m-medium--bottom">
                                                    <span class="button button--tertiary button--inventory" id="button--add" onclick="addInventory()">+</span>
                                                    <span class="button button--tertiary button--inventory" id="button--remove" onclick="removeInventory()">-</span>
                                               </div>
                                               <div class="u-m-medium--bottom">
                                                    <button type="submit" class="button button--primary button--large">
                                                       Publish
                                                    </button>
                                               </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="two column"></div>
                                </div>
                            </div>
                        </section>';
        } else {
            //Not logged in
        }

        $conn->close();
    ?>
	<?php include './php/footer.php' ?>
	<script type="text/javascript" src='./js/global.js'></script>
</body>
</html>