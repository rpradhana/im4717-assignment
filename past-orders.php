<!DOCTYPE html>
<html lang="en-GB">
<?php include './php/head.php'; ?>
<body class="debug o f h d">
	<?php
		$productName     = 'WOMEN LOREM IPSUM Cotton Turtle Neck Long Sleeve T-Shirt';
		$productID       = 12345678;
		$transactionID   = 123456789012;
		$transactionDate = date("d/m/Y");
	?>
	<?php include './php/nav.php' ?>
	<section class="profile">
		<div class="container">
			<div class="row">
				<div class="one column"></div>
				<div class="two column">
					<aside>
						<div class="profile__name">
							<h4 class="header">Raymond Aditya Pradhana</h4>
						</div>
						<a href="./profile.php" class="button button--large profile__menu">
							My Profile
						</a>
						<a href="./past-orders.php" class="button button--large profile__menu profile__menu--active">
							Past Orders
						</a>
					</aside>
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
									Item ID
								</th>
								<th>
									<span class="u-no-wrap">Transaction ID</span>
								</th>
								<th class="u-align--right">
									<span class="u-no-wrap">Transaction Date</span>
								</th>
							</tr>
							<tr class="table__row">
								<td>
									<?php echo $productName ?>
								</td>
								<td>
									<?php echo $productID ?>
								</td>
								<td>
									<?php echo $transactionID ?>
								</td>
								<td class="u-align--right">
									<?php echo $transactionDate ?>
								</td>
							</tr>
						</table>
					</form>
				</div>
				<div class="one column"></div>
			</div>
		</div>
	</section>

	<?php include './php/footer.php' ?>
	<script type="text/javascript" src='./js/global.js'></script>
</body>
</html>