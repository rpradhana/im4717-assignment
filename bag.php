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

                            // Update session from AJAX
                            if (isset($_POST['new_quantity'])) {
                                $product_ids = array();
                                foreach ($_SESSION['cart'] as $key=>$cart_item) {
                                    $id    = $cart_item->id;
                                    $color = $cart_item->color;
                                    $size  = $cart_item->size;
                                    if ($id == $_POST['cart_id'] && $color == $_POST['cart_color'] && $size == $_POST['cart_size']) {
                                        $_SESSION['cart'][$key]->quantity = $_POST['new_quantity'];
                                    }
                                }
                            } else if (isset($_POST["remove_item"])) {
                                unset($_SESSION["cart"][$_POST["remove_item"]]);
                                $_SESSION["cart"] = array_values($_SESSION["cart"]);
                            }

                            // Connect to database
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
                                echo '</table>';
                            } else {
                                //Build an array of product IDs in the cart to facilitate single query only
                                $product_ids = array();
                                $product_colors = array();
                                $product_sizes = array();
                                foreach ($_SESSION["cart"] as $cart_item) {
                                    $product_id = $cart_item->id;
                                    array_push($product_ids, $product_id);
                                    $product_color = $cart_item->color;
                                    array_push($product_colors, $product_color);
                                    $product_size = $cart_item->size;
                                    array_push($product_sizes, $product_size);

                                }

                                $field = '(';
                                $first = true;
                                foreach (array_unique($product_ids) as $product_id) {
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
                                $total = 0;
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

                                        //Get stocks
                                        $condition = '(productsID = ' . $product_ids[0] . ' AND color ="' . $product_colors[0] . '" AND size="' . $product_sizes[0] . '")';
                                        for ($i = 1 ; $i < sizeof($product_ids); $i++) {
                                            $condition .= ' OR (productsID = ' . $product_ids[$i] . ' AND color ="' . $product_colors[$i] . '" AND size="' . $product_sizes[$i] . '")';
                                        }

                                        $query = 'SELECT productsID, color, size, stock FROM inventory AS i WHERE ' . $condition . ';';
                                        $result = $conn->query($query);
                                        if ($result) {
                                            $num_rows = $result->num_rows;
                                            if ($num_rows > 0) {
                                                $inventory_arr = array();
                                                for ($i = 0; $i < $num_rows; $i++) {
                                                    $row = $result->fetch_assoc();
                                                    $color = lcfirst($row["color"]);
                                                    $id = $row["productsID"];
                                                    $size = $row["size"];
                                                    $stock = $row["stock"];
                                                    if (!isset($inventory_arr[$color])) {
                                                        $inventory_arr[$color] = array();
                                                    }
                                                    $inventory_arr[$color][$size] = $stock;
                                                }

                                                $index = 0;
                                                $removedSomething = false;
                                                foreach ($_SESSION["cart"] as $cart_item) {
                                                    $id = $cart_item->id;
                                                    $color = $cart_item->color;
                                                    $qty = $cart_item->quantity;
                                                    $size = $cart_item->size;
                                                    $prices_per_item = $product_prices[$id];
                                                    $subtotal = $prices_per_item*$qty;
                                                    $stock = $inventory_arr[$color][$size];

                                                    //Don't display if there is no stock, and remove from cart
                                                    if ($stock < 1) {
                                                        unset($_SESSION["cart"][$index]);
                                                        $index += 1;
                                                        $removedSomething = true;
                                                        continue;
                                                    } else if ($qty > $stock) {
                                                        $qty = $stock;
                                                        $_SESSION["cart"][$index] = $stock;
                                                    }
                                                    $total += $subtotal;
                                                    echo '<tr class="table__row">
                                              <td>';
                                                    echo '<img src="./images/' . $id . '_' . $color . '.jpg" class="bag__thumbnail">';
                                                    echo '    </td>
                                              <td>' . ucfirst($color) . '</td>
                                              <td>' . $size . '</td>
                                              <td>' . $product_names[$id] . '</td>
                                              <td id="' . $id . '_' . $color . '_' . $size . '_price-single">$' . number_format($prices_per_item, 2) . '</td>
                                              <td><input type="number" min="1" max="' . $inventory_arr[$color][$size] . '" id="' . $id . '_' . $color . '_' . $size . '_quantity" name="' . $id . '_' . $color .'_quantity" 
                                              class="input--text" value="' . $qty . '" oninput="handleQuantityChange(this)"></td>
                                              <td class="u-align--right"><strong>$<span class="price-subtotal" id="' . $id . '_' . $color . '_' . $size . '_price-subtotal">' .
                                                        number_format($subtotal,2) . '
                                              </span></strong></td>
                                              <td class="bag__edit"><i class="material-icons"><span id="remove_' . $index . '" onclick="removeFromCart(this)">close</span></i></td>
                                          </tr>';
                                                    $index += 1;
                                                }

                                                if ($removedSomething) {
                                                    $_SESSION["cart"] = array_values($_SESSION["cart"]);
                                                }
                                            }
                                        } else {
                                            //Unable to query database for stocks
                                            exit();
                                        }
                                    }
                                } else {
                                    //Unable to query database for products information
                                    exit();
                                }
                                echo '  </table>
                                        <div class="bag__review">
                                            <div class="bag__subtotal">
                                                <h4 class="header"><strong>Total $<span id="total-price">' . number_format($total,2) . '</span></strong></h4>
                                            </div>
                                            <button type="submit" class="button button--primary button--large">
                                                Proceed to checkout
                                            </button>
                                        </div>';
                            }
                        ?>
				</div>
			</div>
		</form>
	</section>
	<?php include './php/footer.php' ?>
	<script type="text/javascript" src='./js/global.js'></script>
</body>
</html>