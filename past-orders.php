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
        include_once('./php/nav.php');

        if (isset($_SESSION["username"]) && !empty(trim($_SESSION["username"])) && isset($_SESSION["email"]) && !empty(trim($_SESSION["email"]))) {
            echo '  <section class="profile">
                    <div class="container">
                        <div class="row">
                            <div class="one column"></div>
                            <div class="two column">
                                <aside>
                                    <div class="profile__name">
                                        <h4 class="header">' . $_SESSION["username"] . '</h4>
                                    </div>
                                    <a href="./profile.php" class="button button--large profile__menu">
                                        My Profile
                                    </a>
                                    <a href="./past-orders.php" class="button button--large profile__menu profile__menu--active">
                                        Past Orders
                                    </a>';

            if ($_SESSION["role"] == "ADMN") {
                echo '              <a href="./add.php" class="button button--large profile__menu">
                                            Add Product
                                    </a>';
            }

            echo '            </aside>
                            </div>
                            <div class="eight column">
                                <form id="profile__past-orders">
                                    <h2 class="header profile__header">Past Orders</h2>
                                    <table class="u-fill">
                                        <tr class="table__row">
                                            <th>
                                                Item
                                            </th>
                                            <th>
                                                Quantity
                                            </th>
                                            <th>
                                                <span class="u-no-wrap">Transaction ID</span>
                                            </th>
                                            <th class="u-align--right">
                                                <span class="u-no-wrap">Transaction Date</span>
                                            </th>
                                        </tr>';
            $subquery = 'SELECT c.id FROM accounts AS a, customers AS c WHERE c.id = a.customersID AND a.email="' . $_SESSION["email"] . '" AND c.fullName="' . $_SESSION["username"] . '"';
            $query = 'SELECT p.name, o.ordersDate, oi.quantity, i.color, i.size, o.id FROM orders AS o, orders_inventory AS oi, inventory AS i, products AS p 
                      WHERE o.id = oi.ordersID AND i.productsID = p.id AND oi.inventoryID = i.id AND o.customersID = (' . $subquery . ') ORDER BY ordersDate DESC, p.name DESC;';
            $result = $conn->query($query);
            //echo $query;

            if ($result) {
                $num_rows = $result->num_rows;
                if ($num_rows > 0) {
                    for ($i = 0; $i < $num_rows; $i++) {
                        $row = $result->fetch_assoc();
                        $name = $row["name"];
                        $color = $row["color"];
                        $size = $row["size"];
                        $date = $row["ordersDate"];
                        $quantity = $row["quantity"];
                        $id = $row["id"];
                        echo '         <tr class="table__row">
                                            <td>' . $name . ' (' . $color . ',' . $size . ')' . '</td>
                                            <td>' . $quantity . '</td>
                                            <td>' . $id . '</td>
                                            <td class="u-align--right">' . $date . '</td>
                                        </tr>';
                    }
                } else {
                    echo '              <tr class="table__row">
                                            <td colspan="4">No previous transactions found.</td>
                                        </tr>';
                }
                $result->free();
            } else {
                //Failed to query
                include_once ('./php/error.php');
            }
            echo '	                </table>
                                </form>
                            </div>
                            <div class="one column"></div>
                        </div>
                    </div>
                </section>';
        } else {
            //Not logged in
        }

        $conn->close();
	    include './php/footer.php';
    ?>
	<script type="text/javascript" src='./js/global.js'></script>
</body>
</html>