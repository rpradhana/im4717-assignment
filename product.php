<!DOCTYPE html>
<html lang="en-GB">
<?php include './php/head.php'; ?>
<body class="debug o f h d">
	<?php
        /* To-do:
            -onclick change product-preview
            -addclass remove class for active styling
            -check quantity vs stock
            -click thumbnail changes image preview
            -recommended items
            -add to bag submitted behavior
        */

        $product_id = $_GET["id"];

        if (!$product_id) {
            $product_id = 1;
        }

        include './php/nav.php';

        //Connect to database
        $conn = new mysqli("localhost", "f36im", "f36im", "f36im");

        if ($conn->connect_error) {
            //Fallback if unable to connect to database
            exit();
        }


        $query = 'SELECT p.name, p.price, p.discount, p.description, i.color, i.size, i.stock FROM products AS p, inventory AS i 
WHERE p.id = ' . $product_id . ' AND p.id = i.productsID ORDER BY i.color ASC;';
        $result = $conn->query($query);

        if ($result) {
            $num_rows = $result->num_rows;
            if ($num_rows > 0) {
                global $row;
                $color_arr = array();

                //Fill up array of color, size, and stock combination
                for ($i = 0; $i < $num_rows; $i++) {
                    $row = $result->fetch_assoc();
                    $color = strtolower($row["color"]);
                    $size = $row["size"];
                    $stock = $row["stock"];

                    if (!isset($color_arr[$color])) {
                        $color_arr[$color] = array();
                    }
                    $color_arr[$color][$size] = $stock;

                }
                $name = $row["name"];
                $discount = $row["discount"];
                $price = $row["price"];
                $price_after_discount = (1 - $product_discount/(float)100) * $price;
                $description = $row["description"];

                echo '	<section id="product-details" class="product-details">
                            <div class="container">
                                <div class="row">
                                    <div class="one column u-p-zero--right">';

                $first = true;
                $distinct_color = array();
                $distinct_size = array();
                foreach ($color_arr as $color_name => $size_arr) {
                    if ($first) {
                        echo '<div class="product-thumbnails product-thumbnails--active">';
                        $first = false;
                    } else {
                        echo '<div class="product-thumbnails">';
                    }

                    echo '  <img src="./images/' . $product_id . '_' . $color_name . '.jpg" width="100%">
                          </div>';

                    array_push($distinct_color, $color_name);

                    foreach ($size_arr as $size => $stock) {
                        if (!in_array($size, $distinct_size)) {
                            array_push($distinct_size, $size);
                        }
                    }
                }


                echo '  </div>
                        <div class="four column">
                            <div class="product-preview">
                                 <img src="./images/' . $product_id . '_' . $distinct_color[0] . '.jpg" width="100%">
                            </div>
                        </div>
                        <div class="three column">
                            <form class="product-filters">
                                <div id="option--color" class="option-group">
                                    <div class="option__header">
                                        <h4>Select color</h4>
                                    </div>
                                    <div class="row">';

                $first = true;
                foreach($distinct_color as $color_name) {
                    echo '  <div class="six column u-p-zero">
                                <label for="color--' . $color_name . '" class="label label--checkbox">';

                    if ($first) {
                        echo ' <input type="radio" name="color" class="input--checkbox" id="color--' . $color_name . '" checked>';
                        $first = false;
                    } else {
                        echo ' <input type="radio" name="color" class="input--checkbox" id="color--' . $color_name . '">';
                    }

                    echo ucfirst($color_name) .
                                '</label>
                            </div>';
                }

                echo '    </div>
						</div>
						<div id="option--size" class="option-group">
							<div class="option__header">
								<h4>Select size</h4>
								<div class="header__button">
									<a href="#">Size Chart</a>
								</div>
							</div>
							<div class="row">';

                $first = true;
                foreach($distinct_size as $size) {
                    echo '<div class="six column u-p-zero">
                                <label for="size--' . $size . '" class="label label--checkbox">';

                    if ($first) {
                        echo '<input type="radio" name="size" class="input--checkbox" id="size--' . $size . '" checked>';
                    } else {
                        echo '<input type="radio" name="size" class="input--checkbox" id="size--' . $size . '">';
                    }


                    echo strtoupper($size) .
                                '</label>
                            </div>
                        ';
                }

                echo '    </div>
						</div>
						<div class="option--quantity">
							<div>Quantity</div>
							<input type="text" name="quantity" class="input--text" id="quantity" value="1" placeholder="Quantity">
						</div>
						<button type="submit" class="button button--primary button--large option__button">
							Add to Bag ($' . $price_after_discount . ')
						</button>
					</form>
				</div>';

                echo ' <div class="four column">
                            <div class="product-info">
                                <div class="product-info__name">
                                    <h4 class="header">'. $name . '</h4>
                                </div>
                                <div class="product-info__id">
                                    Product ID: ' . $product_id . '
                                </div>
                                <div class="product-info__price">
                                    <span class="product-info__price--current">$' . number_format($price_after_discount,2) . '</span>';

                if ($product_discount > 0) {
                    echo ' <span class="product-info__price--pre-discount">$' . number_format($price,2) . '</span>';
                }

                echo '          </div>
                                <div class="product-info__description">' .
                                    nl2br($description) .
                                '</div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>';

            } else {
                //ProductID does not belong to database
                exit();
            }
        } else {
            //Unable to query database for popular items
            exit();
        }

	?>
<!--	<section id="collection--recommended">-->
<!--		<div class="container">-->
<!--			<div class="row">-->
<!--				<div class="twelve column">-->
<!--					<div class="collection__signifier"></div>-->
<!--					<h2 class="header collection__header"><a href="#">Recommended For You</a></h2>-->
<!--				</div>-->
<!--			</div>-->
<!--			<div class="row">-->
<!--				<div class="three column">-->
<!--					--><?php //include './php/product.php' ?>
<!--				</div>-->
<!--				<div class="three column">-->
<!--					--><?php //include './php/product.php' ?>
<!--				</div>-->
<!--				<div class="three column">-->
<!--					--><?php //include './php/product.php' ?>
<!--				</div>-->
<!--				<div class="three column">-->
<!--					--><?php //include './php/product.php' ?>
<!--				</div>-->
<!--			</div>-->
<!--		</div>-->
<!--	</section>-->
	<?php include './php/footer.php' ?>
	<script type="text/javascript" src='./js/global.js'></script>
</body>
</html>