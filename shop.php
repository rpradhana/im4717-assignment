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

        echo '  <div class="container">
                    <form class="filter" onsubmit="return validateSidebar();">
                        <div class="row">
                            <div class="three column">';
        include './php/sidebar.php' ;
        echo '              </div>
                            <div class="nine column u-p-zero">
                                <div class="row">
                                    <div class="twelve column">
                                        <div class="search-result">
                                            <div class="search-result__info">
                                                Displaying all products
                                            </div>';
        $sortby = "relevance";
        if (isset($_GET["sortby"])) {
            $sortby = $_GET["sortby"];
        }

        echo '                              <div>
                                                Sort by
                                                <select class="select select--with-label" name="sortby">
                                                    <option value="relevance"' . ($sortby == "relevance" ? ' selected' : '') . '>Relevance</option>
                                                    <option value="popular"' . ($sortby == "popular" ? ' selected' : '') . '>Popularity</option>
                                                    <option value="newest"' . ($sortby == "newest" ? ' selected' : '') . '>Newest arrivals</option>
                                                    <option value="price--ascending"' . ($sortby == "price--ascending" ? ' selected' : '') . '>Price (lowest)</option>
                                                    <option value="price--descending"' . ($sortby == "price--descending" ? ' selected' : '') . '>Price (highest)</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>';


        $condition = ' p.id = i.productsID';
        $pageIndex = 0;
        //Parse parameters
        foreach ($_GET as $param_name => $param_value) {
            if ($param_name == 'gender' || $param_name == 'category' || $param_name == 'size' || $param_name == 'color') {
                $condition = $condition . ' AND (';
                $first = true;
                foreach ($param_value as $param_value_inner) {
                    if ($first) {
                        $condition = $condition . $param_name . '="' . $param_value_inner . '"';
                        $first = false;
                    } else {
                        $condition = $condition . ' OR ' . $param_name . '="' . $param_value_inner . '"';
                    }
                }
                $condition = $condition . ')';
            } else if ($param_name == 'tag') {
                foreach ($param_value as $param_value_inner) {
                    if ($param_value_inner == "Promotion") {
                        $condition .= ' AND discount > 0';
                    }
                }
            } else if ($param_name == 'price--min' && $param_value > 0) {
                $condition .= ' AND price > ' . $param_value;
            } else if ($param_name == 'price--max' && $param_value > 0) {
                $condition .= ' AND price < ' . $_GET["price--max"];
            } else if ($param_name == 'pageno' && $param_value > 0) {
                $pageIndex = $param_value-1;
            }
        }

        if (isset($_GET["searchstring"]) && !empty(trim($_GET["searchstring"]))) {
            $condition .= ' AND p.name LIKE "%' . $_GET["searchstring"] . '%"';
        }

        $query = 'SELECT COUNT(DISTINCT p.id) AS totalRows FROM products AS p, inventory AS i WHERE ' . $condition . ';';
        $result = $conn->query($query);
        if ($result) {
            $num_rows = $result->num_rows;
            if ($num_rows > 0) {
                $row = $result->fetch_assoc();
                $total_rows = $row["totalRows"];
                $result->free();
                if (isset($_GET["sortby"]) && $_GET["sortby"] == "popular") {
                    $query = 'SELECT p.id, p.name, p.price, p.discount, COUNT(*) AS numberOfTimesBought FROM products AS p, inventory AS i, 
                    orders_inventory AS oi WHERE i.id = oi.inventoryID AND';
                } else {
                    $query = 'SELECT p.id, p.name, p.price, p.discount FROM products AS p, inventory AS i WHERE ';
                }

                $query .= $condition . ' GROUP BY p.id';

                if ($sortby == "popular") {
                    $query .= ' ORDER BY numberOfTimesBought DESC';
                } else if ($sortby == "newest") {
                    $query .= ' ORDER BY p.id DESC';
                } else if ($sortby == "price--ascending") {
                    $query .= ' ORDER BY p.price ASC';
                } else if ($sortby == "price--descending") {
                    $query .= ' ORDER BY p.price DESC';
                }

                $query .= ' LIMIT ' . ($pageIndex * 6) . ',6;';
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
                            $product_name = stripslashes($row["name"]);
                            $product_price = $row["price"];
                            $product_discount = $row["discount"];
                            echo '<div class="four column">';
                            include './php/product.php';
                            echo '</div>';
                        }
                        $result->free();

                        echo '</div>';
                        $param_arr = $_GET;
                        unset($param_arr["pageno"]);
                        $param_string = http_build_query($param_arr);

                        echo '  <div class="row">
                            <div class="twelve column">
                                <div class="pagination shop__pagination">';

                        $num_pages = floor($total_rows/6) + 1;

                        if ($num_pages > 1) {
                            if ($pageIndex > 0) {
                                echo '          <a href="./shop.php?' . $param_string . '&pageno=' . $pageIndex . '"><i class="material-icons">keyboard_arrow_left</i></a>';
                            }

                            for ($i = 0; $i < $num_pages; $i++) {
                                echo '          <a href="./shop.php?' . $param_string . '&pageno=' . ($i+1) . '"' . ($i == $pageIndex ? ' class="u-is-active"' : '') . '>' . ($i+1) . '</a>';
                            }

                            if ($pageIndex < ($num_pages - 1)) {
                                echo '          <a href="./shop.php?' . $param_string . '&pageno=' . ($pageIndex+2) . '"><i class="material-icons">keyboard_arrow_right</i></a>';
                            }
                        }

                        echo '           </div>
                            </div>
                        </div>';
                    } else {
                        //No products correspond to search result
                        echo 'No result found';
                    }
                } else {
                    //Unable to query database for search results
                    include_once ('./php/error.php');
                    exit();
                }
            } else {
                //No products correspond to search result
                echo 'No result found';
            }
        } else {
            //Unable to query database for search results
            include_once ('./php/error.php');
            exit();
        }
        $conn->close();
    ?>
                </div>
            </div>
        </form>
	</div>
	<?php include './php/footer.php' ?>
	<script type="text/javascript" src='./js/global.js'></script>
</body>
</html>