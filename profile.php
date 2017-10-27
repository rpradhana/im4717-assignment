<!DOCTYPE html>
<html lang="en-GB">
<?php include './php/head.php'; ?>
<body class="debug o f h d">
	<?php include './php/nav.php' ?>
	<section class="profile">
		<div class="container">
			<div class="row">
				<div class="two column"></div>
				<div class="two column">
					<aside>
						<div class="profile__name">
							<h4 class="header">Raymond Aditya Pradhana</h4>
						</div>
						<button class="button button--large profile__menu profile__menu--active">
							My Profile
						</button>
						<button class="button button--large profile__menu">
							Past Orders
						</button>
					</aside>
				</div>
				<div class="six column">
					<form id="profile__edit">
						<h2 class="header u-m-large--bottom">My Profile</h2>
						<div class="u-flex">
							<div class="u-m-medium--bottom">
								<label for="name" class="label--required label--top">
									Full Name
								</label>
								<input type="text" name="name" id="name" class="input--text u-fill" placeholder="Your full name" required>
							</div>
							<div class="u-m-medium--bottom">
								<label for="email" class="label--required label--top">
									Email
								</label>
								<input type="text" name="email" id="email" class="input--text u-fill" placeholder="name@email.com" required>
							</div>
							<div class="u-m-medium--bottom">
								<label for="address" class="label--required label--top">
									Address
								</label>
								<input type="text" name="address" id="address" class="input--text u-fill" placeholder="Delivery address" required>
							</div>
							<div class="u-m-medium--bottom">
								<label for="postal-code" class="label--required label--top">
									Postal Code
								</label>
								<input type="text" name="postal-code" id="postal-code" class="input--text u-fill" placeholder="Postal code" required>
							</div>
							<div class="u-m-medium--bottom">
								<label for="gender" class="label--top">
									Gender
								</label>
								<label for="gender--men" class="label--radio u-inline-block u-m-medium--right">
									<input type="radio" name="gender" value="men" id="gender--men" class="input--radio">
									Women
								</label>
								<label for="gender--women" class="label--radio u-inline-block">
									<input type="radio" name="gender" value="women" id="gender--women" class="input--radio">
									Men
								</label>
							</div>
							<div class="u-m-medium--bottom">
								<label for="phone" class="label--required label--top">
									Phone No.
								</label>
								<input type="text" name="phone" id="phone" class="input--text u-fill" placeholder="Phone number" required>
							</div>
							<div class="u-m-medium--bottom">
								<label for="country" class="label--required label--top">
									Country
								</label>
								<input type="text" name="country" id="country" class="input--text u-fill" placeholder="Country of residence">
							</div>
							<div class="u-m-medium--bottom">
								<label for="birthday" class="label--top">
									Birthday
								</label>
								<input type="date" name="birthday" id="birthday" class="input--date u-fill">
							</div>
							<div class="u-m-medium--bottom">
								<!-- Replace button with password fields on click -->
								<button type="button" class="button button--tertiary u-m-medium--top">
									Change Password
								</button>
					<!-- 			<div class="u-m-medium--bottom">
									<label for="postal-code" class="label--required label--top">
										Password
									</label>
									<input type="password" name="password" id="password" class="input--text u-fill" placeholder="Enter password" required>
								</div>
								<div class="u-m-medium--bottom">
									<label for="postal-code" class="label--required label--top">
										Password
									</label>
									<input type="password" name="password--verify" id="password--verify" class="input--text u-fill" placeholder="Re-enter password" required>
								</div> -->
							</div>
							<div class="u-m-medium--top">
								<button type="submit" class="button button--primary button--large">
									Update Profile
								</button>
							</div>
						</div>
					</form>
				</div>
				<div class="two column"></div>
			</div>
		</div>
	</section>

	<?php include './php/footer.php' ?>
	<script type="text/javascript" src='./js/global.js'></script>
</body>
</html>