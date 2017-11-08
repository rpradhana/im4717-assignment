<div class="product">
    <div class="row product__image">
        <?php
            echo '<a href="./product.php?id=' . $product_id .'" class="u-flex">';
            echo '<img class="catalog-img" id="' . $section_id . '_img_' . $product_id .'"></a>';
        ?>
<!--        <div class="product__label">-->
<!--            <div class="product__label--popular">Popular</div>-->
<!--            <div class="product__label--new">New</div>-->
<!--        </div>-->
    </div>
    <div class="row product__name">
        <?php
            echo '<a href="./product.php?id=' . $product_id .'">';
            echo $product_name;
            echo '</a>';
        ?>
	</div>
	<div class="row product__price">
		<div class="product__price--current">
			<h2 class="header">
                <?php
                    $price_after_discount = (1 - $product_discount/(float)100) * $product_price;
                    echo '$' . number_format($price_after_discount,2);
                ?>
			</h2>
		</div>
        <?php
            if ($product_discount > 0) {
                echo '<div class="product__price--pre-discount">';
                echo '$' . number_format($product_price,2);
		        echo '</div>';
            }
        ?>
	</div>
	<div class="row product__color">

        <?php
            $query = 'SELECT DISTINCT(inventory.color) FROM inventory WHERE inventory.productsID = ' . $product_id . ';';
            $inner_result = $conn->query($query);
            $inner_num_rows = $inner_result->num_rows;
            for ($j = 0; $j < $inner_num_rows; $j++) {
                $inner_row = $inner_result->fetch_assoc();
                $color = strtolower($inner_row["color"]);
                $button_id = $section_id . '_button_' . $product_id . '_' . $color;
                echo '<span class="product__color--' . $color . '" onclick="pickColor(this)" id="' . $button_id . '"></span>';
                if ($j == 0) {
                    echo '<script>initProductImage("' . $button_id .'");</script>';
                }
            }
        ?>
	</div>
</div>
