<!DOCTYPE html>
<html lang="en-GB">
<?php include './php/head.php'; ?>
<body class="debug o f d">
	<?php include './php/nav.php' ?>
	<?php include './php/hero.php' ?>
	<section id="collection--popular">
		<div class="container">
			<div class="row">
				<div class="twelve column">
					<div class="collection__signifier"></div>
					<h2 class="header collection__header"><a href="#">Popular Collection</a></h2>
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
	<section id="collection--new">
		<div class="container">
			<div class="row">
				<div class="twelve column">
					<div class="collection__signifier"></div>
					<h2 class="header collection__header"><a href="#">New Arrivals</a></h2>
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