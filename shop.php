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
							<div class="search-result__sort">
								Sort by
								<select class="select select--with-label">
									<option class="" value="popular">Most Popular</option>
								</select>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="four column">
						<?php include './php/product.php' ?>
					</div>
					<div class="four column">
						<?php include './php/product.php' ?>
					</div>
					<div class="four column">
						<?php include './php/product.php' ?>
					</div>
					<div class="four column">
						<?php include './php/product.php' ?>
					</div>
					<div class="four column">
						<?php include './php/product.php' ?>
					</div>
					<div class="four column">
						<?php include './php/product.php' ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php include './php/footer.php' ?>
	<script type="text/javascript" src='./js/global.js'></script>
</body>
</html>