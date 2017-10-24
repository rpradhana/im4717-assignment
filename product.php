<!DOCTYPE html>
<html lang="en-GB">
<?php include './php/head.php'; ?>
<body class="debug o f h d">
	<?php
		$productName = 'WOMEN LOREM IPSUM Cotton Turtle Neck Long Sleeve T-Shirt';
		$productID = 12345678;
		$productPriceCurrent = 19.90;
		$productPricePreDiscount = 29.90;
		$productDescription = '- White short sleeve tee with embroidered and sequined flower detail
			- Sizing runs one size larger
			- Round neckline
			- Unlined
			- Relaxed fit
			- Polyblend
			- Model wears an S and is 174cm tall
			';
	?>
	<?php include './php/nav.php' ?>
	<section id="product-details" class="product-details">
		<div class="container">
			<div class="row">
				<div class="one column u-p-zero--right">
					<!-- onclick change product-preview -->
					<!-- addclass remove class for active styling -->
					<div class="product-thumbnails product-thumbnails--active">
						<img src="./images/pexels-photo-428338.jpg" width="100%">
					</div>
					<div class="product-thumbnails">
						<img src="./images/pexels-photo-428338.jpg" width="100%">
					</div>
					<div class="product-thumbnails">
						<img src="./images/pexels-photo-428338.jpg" width="100%">
					</div>
				</div>
				<div class="four column">
					<div class="product-preview">
						<img src="./images/pexels-photo-428338.jpg" width="100%">
					</div>
				</div>
				<div class="three column">
					<form class="product-filters">
						<div id="option--color" class="option-group">
							<div class="option__header">
								<h4>Select color</h4>
							</div>
							<div class="row">
								<?php
									$color = array('beige'  => 'Beige',
									               'black'  => 'Black',
									               'blue'   => 'Blue',
									               'brown'  => 'Brown',
									               'green'  => 'Green',
									               'grey'   => 'Grey',
									               'yellow' => 'Yellow',
									               'orange' => 'Orange',
									               'pink'   => 'Pink',
									               'red'    => 'Red',
									               'white'  => 'White');
									foreach($color as $color => $color_string) {
										echo '
											<div class="six column u-p-zero">
												<label for="color--' . $color . '" class="label label--checkbox">
													<input type="checkbox" name="color" class="input--checkbox" id="color--' . $color . '">
													' . $color_string . '
												</label>
											</div>
										';
									}
								?>
							</div>
						</div>
						<div id="option--gender" class="option-group">
							<div class="option__header">
								<h4>Select size</h4>
								<div class="header__button">
									<a href="#">Size Chart</a>
								</div>
							</div>
							<div class="row">
								<?php
									$size = array('xxs' => 'XXS',
									              'xs'  => 'XS',
									              's'   => 'S',
									              'm'   => 'M',
									              'l'   => 'L',
									              'xl'  => 'XL',
									              'xxl' => 'XXL');
									foreach($size as $size => $size_string) {
										echo '
											<div class="six column u-p-zero">
												<label for="size--' . $size . '" class="label label--checkbox">
													<input type="checkbox" name="size" class="input--checkbox" id="size--' . $size . '">
													' . $size_string . '
												</label>
											</div>
										';
									}
								?>
							</div>
						</div>
						<div class="option--quantity">
							<div>Quantity</div>
							<input type="text" name="quantity" class="input input--text" id="quantity" value="1" placeholder="Quantity">
						</div>
						<button type="submit" class="button button--primary button--large option__button">
							Add to Bag <?php echo '($' . $productPriceCurrent . ')'?>
						</button>
					</form>
				</div>
				<div class="four column">
					<div class="product-info">
						<div class="product-info__name">
							<h4 class="header"><?php echo $productName ?></h4>
						</div>
						<div class="product-info__id">
							ID: <?php echo $productID ?>
						</div>
						<div class="product-info__price">
							<span class="product-info__price--current">$<?php echo $productPriceCurrent ?></span>
							<span class="product-info__price--pre-discount">$<?php echo $productPricePreDiscount ?></span>
						</div>
						<div class="product-info__description">
							<?php echo nl2br($productDescription) ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section id="collection--recommended">
		<div class="container">
			<div class="row">
				<div class="twelve column">
					<div class="collection__signifier"></div>
					<h2 class="header collection__header"><a href="#">Recommended For You</a></h2>
				</div>
			</div>
			<div class="row">
				<div class="three column">
					<?php include './php/product.php' ?>
				</div>
				<div class="three column">
					<?php include './php/product.php' ?>
				</div>
				<div class="three column">
					<?php include './php/product.php' ?>
				</div>
				<div class="three column">
					<?php include './php/product.php' ?>
				</div>
			</div>
		</div>
	</section>
	<?php include './php/footer.php' ?>
	<script type="text/javascript" src='./js/global.js'></script>
</body>
</html>