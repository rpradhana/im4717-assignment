<!DOCTYPE html>
<html lang="en-GB">
<?php include './php/head.php'; ?>
<body class="debug o f h">
	<?php include './php/nav.php' ?>
	<section id="bag" class="bag">
		<form>
			<div class="container">
				<div class="twelve column">
					<h2 class="header u-m-medium--bottom">Shopping Bag</h2>
					<table class="bag__table">
						<tr class="table__header">
							<th class="u-align--left">Image</th>
							<th>Color</th>
							<th>Size</th>
							<th class="u-align--left">Item</th>
							<th>Price</th>
							<th>Quantity</th>
							<th class="u-align--right">Subtotal</th>
							<th></th>
						</tr>
						<tr class="table__row bag__content">
							<td>
								<img src="./images/pexels-photo-428338.jpg" class="bag__thumbnail">
							</td>
							<td>
								Black
							</td>
							<td>
								S
							</td>
							<td class="u-align--left">
								WOMEN LOREM IPSUM Cotton Turtle Neck Long Sleeve T-Shirt
							</td>
							<td>
								$19.90
							</td>
							<td>
								<input type="text" name="quantity" class="input input--text" value="1">
							</td>
							<td class="u-align--right">
								<strong>$39.80</strong>
							</td>
							<td class="bag__edit">
								<i class="material-icons">close</i>
							</td>
						</tr>
					</table>
					<div class="bag__review">
						<div class="bag__subtotal">
							<h4 class="header"><strong>Subtotal $39.80</strong></h4>
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