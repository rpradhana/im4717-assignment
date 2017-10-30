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
				<div class="row">
					<div class="twelve column">
						<div class="pagination shop__pagination">
							<button><i class="material-icons">keyboard_arrow_left</i></button>
							<button class="u-is-active">1</button>
							<button>2</button>
							<button>3</button>
							<button>4</button>
							<button>5</button>
							<button>6</button>
							<button><i class="material-icons">keyboard_arrow_right</i></i></button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php include './php/footer.php' ?>
	<script type="text/javascript" src='./js/global.js'></script>
</body>
</html>