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
            exit();
        }

        include './php/nav.php';
        include_once ('./php/countries-list.php');

        if (isset($_SESSION["username"]) && !empty(trim($_SESSION["username"]))&& isset($_SESSION["email"]) && !empty(trim($_SESSION["email"])) && $_SESSION["role"] == "ADMN") {
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
                                        <form method="post" id="profile__edit">
                                            <input type="hidden" name="update">
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
                                                        <input type="radio" name="gender" value="men" id="gender--men" class="input--radio" required>
                                                        Men
                                                    </label>
                                                    <label for="gender--women" class="label--radio u-inline-block">
                                                        <input type="radio" name="gender" value="women" id="gender--women" class="input--radio">
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
                                               <button>+</button>
                                               <div>
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
    ?>
	<?php include './php/footer.php' ?>
	<script type="text/javascript" src='./js/global.js'></script>
</body>
</html>