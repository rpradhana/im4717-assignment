<!DOCTYPE html>
<html lang="en-GB">
<?php include './php/head.php'; ?>
<body class="debug o f d">
    <?php
        //Navigation and main category
        session_start();

        //Connect to database
        $conn = new mysqli("localhost", "f36im", "f36im", "f36im");

        if ($conn->connect_error) {
            //Fallback if unable to connect to database
            exit();
        }

        include './php/nav.php';
        include './php/hero.php';

        //Get popular items
        $query = "SELECT p.id, p.name, p.price, p.discount, COUNT(*) AS numberOfTimesBought FROM products AS p, 
inventory AS i, orders_inventory AS o WHERE i.id = o.inventoryID AND p.id = i.productsID GROUP BY(p.id) 
ORDER BY numberOfTimesBought LIMIT 0,4;";
        $result = $conn->query($query);

        if ($result) {
            $num_rows = $result->num_rows;
            if ($num_rows > 0) {
                $section_id = "collection--popular";
                echo '<section id=". $section_id .">	
                        <div class="container">
                            <div class="row">
                                <div class="twelve column">
                                    <div class="collection__signifier"></div>
                                    <h2 class="header collection__header"><a href="#">Popular Collection</a></h2>
                                </div>
                            </div>
                            <div class="row">';
                for ($i = 0; $i < $num_rows; $i++) {
                    $row = $result->fetch_assoc();
                    $product_id = $row["id"];
                    $product_name = $row["name"];
                    $product_price = $row["price"];
                    $product_discount = $row["discount"];
                    echo '<div class="three column">';
                    include './php/product.php';
                    echo '</div>';
                }
                echo '    </div>
                        </div>
                    </section>';
            }
        } else {
            //Unable to query database for popular items
            exit();
        }

        //Get newest arrivals
        $query = "SELECT products.id, products.name, products.price, products.discount FROM products ORDER BY products.id DESC LIMIT 0,4;";
        $result = $conn->query($query);

        if ($result) {
            $num_rows = $result->num_rows;
            if ($num_rows > 0) {
                $section_id = 'collection--new';
                echo '<section id="' . $section_id .'">
                        <div class="container">
                            <div class="row">
                                <div class="twelve column">
                                    <div class="collection__signifier"></div>
                                    <h2 class="header collection__header"><a href="#">New Arrivals</a></h2>
                                </div>
                            </div>
                            <div class="row">';

                for ($i = 0; $i < $num_rows; $i++) {
                    $row = $result->fetch_assoc();
                    $product_id = $row["id"];
                    $product_name = $row["name"];
                    $product_price = $row["price"];
                    $product_discount = $row["discount"];
                    echo '<div class="three column">';
                    include './php/product.php';
                    echo '</div>';
                }

                echo '    </div>
                        </div>
                    </section>';
            }
        } else {
            //Unable to query database for newest arrivals
            exit();
        }

        include './php/footer.php';
        echo '<script type="text/javascript" src="./js/global.js"></script>';

    ?>
</body>
</html>
