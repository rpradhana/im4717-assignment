<!DOCTYPE html>
<html lang="en-GB">
<?php include './php/head.php'; ?>
<body class="debug o f h d">
	<?php include './php/nav.php' ?>
	<div class="container">
		<div class="row">
			<div class="three column">
				<?php include './php/sidebar.php' ?>
			</div>
			<div class="nine column u-p-zero">
				<div class="row">
					<div class="twelve column">
						<div class="search-result">
							<div class="search-result__info">
								Displaying all products
							</div>
							<div>
								Sort by
								<select class="select select--with-label">
									<option value="relevance">Relevance</option>
									<option value="popular">Popularity</option>
									<option value="new">Newest arrivals</option>
									<option value="price--ascending">Price (lowest)</option>
									<option value="price--descending">Price (highest)</option>
								</select>
							</div>
						</div>
					</div>
				</div>
                <?php
                    //Connect to database
                    $conn = new mysqli("localhost", "f36im", "f36im", "f36im");

                    if ($conn->connect_error) {
                        //Fallback if unable to connect to database
                        exit();
                    }

                    $query = "SELECT p.id, p.name, p.price, p.discount FROM products AS p, inventory AS i WHERE p.id=i.productsID";


                    foreach ($_GET as $category_name => $category_value_arr) {
                        if ($category_name != 'tag' && $category_name != 'price--min' && $category_name != 'price--max') {
                            $query = $query . ' AND (';
                            $first = true;
                            foreach ($category_value_arr as $category_value) {
                                if ($first) {
                                    $query = $query . $category_name . '="' . $category_value . '"';
                                    $first = false;
                                } else {
                                    $query = $query . ' OR ' . $category_name . '="' . $category_value . '"';
                                }
                            }
                            $query = $query . ')';
                        }

                    }
                    $query = $query . ' GROUP BY p.id;';
                    //echo $query;
                    $result = $conn->query($query);

                    if ($result) {
                        $num_rows = $result->num_rows;
                        if ($num_rows > 0) {
                            echo '<div class="row">';
                            $section_id = "collection--search";
                            for ($i = 0; $i < $num_rows; $i++) {
                                $row = $result->fetch_assoc();
                                $product_id = $row["id"];
                                $product_name = $row["name"];
                                $product_price = $row["price"];
                                $product_discount = $row["discount"];
                                echo '<div class="four column">';
                                include './php/product.php';
                                echo '</div>';
                            }
                            echo '</div>';
                        } else { //No products correspond to search result

                        }
                    } else {
                        //Unable to query database for search results
                        exit();
                    }


                ?>
			</div>
		</div>
	</div>
	<?php include './php/footer.php' ?>
	<script type="text/javascript" src='./js/global.js'></script>
</body>
</html>