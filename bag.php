<!DOCTYPE html>
<html lang="en-GB">
<?php include './php/head.php'; ?>
<body class="debug o f h d">
                        <?php
                            /*To-do:
                                -Proceed to checkout button
                                -Allow update and delete of quantity
                                -Real-time reflection of price updates
                                -Quantity validation
                                -(Optional) Display only if cookie contents match with database entry
                            */

                            include './php/cart-item.php';
                            session_start();

                            //Connect to database
                            $conn = new mysqli("localhost", "f36im", "f36im", "f36im");

                            if ($conn->connect_error) {
                                //Fallback if unable to connect to database
                                exit();
                            }

                            include './php/nav.php';
                            echo '<section id="bag" class="bag">
                                    <form method="POST" action="checkout.php">
                                        <div class="container">
                                            <div class="twelve column">
                                                <h2 class="header u-m-medium--bottom">Shopping Bag</h2>
                                                <table class="u-fill">
                                                    <tr class="table__row">
                                                        <th>Image</th>
                                                        <th>Color</th>
                                                        <th>Size</th>
                                                        <th>Item</th>
                                                        <th>Price</th>
                                                        <th>Quantity</th>
                                                        <th class="u-align--right">Subtotal</th>
                                                        <th></th>
                                                    </tr>';

                            if (!isset($_SESSION["cart"]) || empty($_SESSION["cart"])) {
                                echo '<tr class="table__row"><td colspan="7">You have no items in your cart.</td></tr>';
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

                                $query = 'SELECT p.id, p.name, p.price, p.discount, p.description FROM products AS p WHERE p.id IN ' . $field . ';';
                                $result = $conn->query($query);

                                $product_names = array();
                                $product_prices = array();
                                $product_description = array();
                                if($result) {
                                    $num_rows = $result->num_rows;
                                    if ($num_rows > 0) {
                                        for ($i = 0; $i < $num_rows; $i++) {
                                            $row = $result->fetch_assoc();
                                            $id = $row["id"];
                                            $name = $row["name"];
                                            $description = $row["description"];
                                            $price_after_discount = (1 - $row["discount"]/(float)100) * $row["price"];

                                           $product_names[$id] = $name;
                                           $product_prices[$id] = $price_after_discount;
                                           $product_description[$id] = $description;
                                        }

                                        foreach ($_SESSION["cart"] as $cart_item) {
                                            $id = $cart_item->id;
                                            $color = $cart_item->color;
                                            $qty = $cart_item->quantity;
                                            $prices_per_item = $product_prices[$id];
                                            echo '<tr class="table__row">
                                              <td>';
                                            echo '<img src="./images/' . $id . '_' . $color . '.jpg" class="bag__thumbnail">';
                                            echo '    </td>
                                              <td>' . ucfirst($color) . '</td>
                                              <td>' . $cart_item->size . '</td>
                                              <td>' . $product_names[$id] . '</td>
                                              <td>$' . number_format($prices_per_item, 2) . '</td>
                                              <td><input type="text" name="' . $id . '_' . $color .'_quantity" 
                                              class="input--text" value="' . $qty . '"></td>
                                              <td class="u-align--right"><strong>$' . number_format($prices_per_item*$qty,2) . '
                                              </strong></td>
                                              <td class="bag__edit"><i class="material-icons">close</i></td>
                                          </tr>';
                                        }
                                    }
                                } else {
                                    //Unable to query database for products information
                                    exit();
                                }
                            }
                        ?>
					</table>
					<div class="bag__review">
						<div class="bag__subtotal">
							<h4 class="header"><strong>Total $39.80</strong></h4>
						</div>
						<button type="submit" class="button button--primary button--large">
							Proceed to checkout
						</button>
					</div>
				</div>
			</div>
		</form>
	</section>
	<?php include './php/footer.php' ?>
	<script type="text/javascript" src='./js/global.js'></script>
</body>
</html>