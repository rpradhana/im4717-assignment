<!DOCTYPE html>
<html lang="en-GB">
<?php include './php/head.php'; ?>
<body class="debug o f h">
	<?php include './php/nav.php' ?>
	<section class="checkout">
		<div class="container">
			<form id="checkout">
				<div class="row">
					<div class="four column">
						<section class="stepper">
							<div class="stepper__header">
								<div class="stepper__index">
									<h3>1</h3>
								</div>
								<div class="stepper__step-name">
									<h3>Billing Address</h3>
								</div>
							</div>
							<div class="stepper__content">
								<div class="u-m-medium--bottom">Already registered? <a href="#">Sign in to your account.</a></div>
								<div class="u-m-medium--bottom">Or enter new billing address</div>
								<table class="u-fill">
									<tbody class="checkout__section">
										<tr class="checkout__row">
											<td>
												<label class="label--required">Full Name</label>
											</td>
											<td>
												<input type="text" name="name" id="name" class="input--text u-fill" placeholder="Your full name" required>
											</td>
										</tr>
										<tr class="checkout__row">
											<td>
												<label class="label--required">Email</label>
											</td>
											<td>
												<input type="text" name="email" id="email" class="input--text u-fill" placeholder="name@email.com" required>
											</td>
										</tr>
										<tr class="checkout__row">
											<td colspan="2">
												<label for="create-account" class="label--checkbox">
													<input type="checkbox" name="create-account" id="create-account" class="input--checkbox">
													Create account for later use.
												</label>
											</td>
										</tr>
										<!-- HIDE IF #create-account !checked -->
										<!-- default not checked -->
										<tr class="checkout__row">
											<td>
												<label class="label--required">Password</label>
											</td>
											<td>
												<input type="password" name="password" id="password" class="input--text u-fill" placeholder="Enter password" required>
											</td>
										</tr>
										<tr class="checkout__row">
											<td>
												<label class="label--required">Verify Password</label>
											</td>
											<td>
												<input type="password" name="password--verify" id="password--verify" class="input--text u-fill" placeholder="Re-enter password" required>
											</td>
										</tr>
									</tbody>
									<tbody class="checkout__section">
										<tr class="checkout__row">
											<td>
												<label class="label--required">Address</label>
											</td>
											<td>
												<input type="text" name="address" id="address" class="input--text u-fill" placeholder="Delivery address" required>
											</td>
										</tr>
										<tr class="checkout__row">
											<td>
												<label class="label--required">Postal Code</label>
											</td>
											<td>
												<input type="text" name="postal-code" id="postal-code" class="input--text u-fill" placeholder="Postal code" required>
											</td>
										</tr>
									</tbody>
									<tbody class="checkout__section">
										<tr class="checkout__row">
											<td>
												<label>Gender</label>
											</td>
											<td>
												<label for="gender--men" class="label--radio u-inline-block u-m-medium--right">
													<input type="radio" name="gender" value="men" id="gender--men" class="input--radio">
													Women
												</label>
												<label for="gender--women" class="label--radio u-inline-block">
													<input type="radio" name="gender" value="women" id="gender--women" class="input--radio">
													Men
												</label>
											</td>
										</tr>
										<tr class="checkout__row" class="label--required">
											<td>
												<label>Phone No.</label>
											</td>
											<td>
												<input type="text" name="phone" id="phone" class="input--text u-fill" placeholder="Phone number" required>
											</td>
										</tr>
										<tr class="checkout__row">
											<td>
												<label>Country</label>
											</td>
											<td>
												<input type="text" name="country" id="country" class="input--text u-fill" placeholder="Country of residence">
											</td>
										</tr>
										<tr class="checkout__row">
											<td>
												<label>Birthday</label>
											</td>
											<td>
												<input type="date" name="birthday" id="birthday" class="input--date u-fill">
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</section>
					</div>
					<div class="four column">
						<section class="stepper">
							<div class="stepper__header">
								<div class="stepper__index">
									<h3>2</h3>
								</div>
								<div class="stepper__step-name">
									<h3>Shipping Address</h3>
								</div>
							</div>
							<div>
								<label for="gender--women" class="label--radio u-inline-block u-m-medium--bottom">
									<input type="radio" name="gender" value="women" id="gender--women" class="input--radio">
									<span><strong>Standard</strong></span>
									<br>
									<span>Delivery fee $6.00, 1-3 working days</span>
								</label>
								<label for="gender--women" class="label--radio u-inline-block u-m-medium--bottom">
									<input type="radio" name="gender" value="women" id="gender--women" class="input--radio">
									<span><strong>Standard</strong></span>
									<br>
									<span>Delivery fee $6.00, 1-3 working days</span>
								</label>
							</div>
						</section>
						<section class="stepper">
							<div class="stepper__header">
								<div class="stepper__index">
									<h3>3</h3>
								</div>
								<div class="stepper__step-name">
									<h3>Payment Method</h3>
								</div>
							</div>
							<h4 class="u-m-medium--bottom">Secure Payment</h4>
							<h4 class="u-m-medium--bottom">Credit Card</h4>
							<table class="u-fill">
								<tbody class="checkout__section">
									<tr class="checkout__row" class="label--required">
										<td>
											<label class="label--required">Card Type</label>
										</td>
										<td>
											<select class="select u-fill">
												<option value="visa">VISA</option>
												<option value="mastercard">MasterCard</option>
											</select>
										</td>
									</tr>
									<tr class="checkout__row">
										<td>
											<label class="label--required">Card Number</label>
										</td>
										<td>
											<input type="text" name="card-number" id="card-number" class="input--text u-fill" required>
										</td>
									</tr>
									<tr class="checkout__row">
										<td>
											<label class="label--required">Expiry Date</label>
										</td>
										<td>
											<div class="payment__expiry">
												<select class="select u-m-medium--right u-flex-2">
													<option value="January" selected="selected">January</option>
													<option value="February">February</option>
													<option value="March">March</option>
													<option value="April">April</option>
													<option value="May">May</option>
													<option value="June">June</option>
													<option value="July">July</option>
													<option value="August">August</option>
													<option value="September">September</option>
													<option value="October">October</option>
													<option value="November">November</option>
													<option value="December">December</option>
												</select>
												<select class="select u-flex-1">
													<!-- Day option is based on selected month -->
													<option value="1" selected="selected">1</option>
												</select>
											</div>
										</td>
									</tr>
									<tr class="checkout__row">
										<td>
											<label class="label--required">VCC</label>
										</td>
										<td>
											<input type="text" name="vcc" id="vcc" class="input--text" required>
										</td>
									</tr>
								</tbody>
							</table>
						</section>
					</div>
					<div class="four column">
						<section class="stepper">
							<div class="stepper__header">
								<div class="stepper__index">
									<h3>4</h3>
								</div>
								<div class="stepper__step-name">
									<h3>Order Confirmation</h3>
								</div>
							</div>
							<table class="u-fill">
								<tr class="table__row">
									<th>Item</th>
									<th class="u-align--center">Quantity</th>
									<th class="u-align--right">Subtotal</th>
								</tr>
								<tr class="table__row">
									<td>
										WOMEN LOREM IPSUM Cotton Turtle Neck Long Sleeve T-Shirt
									</td>
									<td class="u-align--center">
										1
									</td>
									<td class="u-align--right">
										$39.80
									</td>
								</tr>
								<tr class="table__row">
									<td colspan="2" class="u-align--left">
										<div>Subtotal</div>
										<div>Shipping</div>
										<div><h3 class="header u-m-medium--top">Grand Total</h3></div>
									</td>
									<td class="u-align--right">
										<div>$39.80</div>
										<div>$6.00</div>
										<div><h3 class="header u-m-medium--top">$45.80</h3></div>
									</td>
								</tr>
							</table>
							<div class="bag__order">
								<button type="submit" class="button button--primary button--large">
									Place Order Now
								</button>
							</div>
						</section>
					</div>
				</div>
			</form>
		</div>
	</section>
	<?php include './php/footer.php' ?>
	<script type="text/javascript" src='./js/global.js'></script>
</body>
</html>