	<div class="modal__window register">
		<div id="modal__close" class="modal__close">
			<i class="material-icons">close</i>
		</div>
		<form>
			<div class="u-flex">
				<div id="register--step-1">
					<h2 class="header u-m-large--bottom">Create new account</h2>
					<div class="u-m-medium--bottom">
						<label for="email" class="label--required label--top">
							Email
						</label>
						<span class="input">
							<input type="text" name="email" id="email" class="input--text u-fill" placeholder="name@email.com" required>
						</span>
					</div>
					<div class="u-m-medium--bottom">
						<label for="password" class="label--required label--top">
							Password
						</label>
						<span class="input">
							<input type="password" name="password" id="password" class="input--text u-fill" placeholder="Enter password" required>
						</span>
					</div>
					<div class="u-m-large--bottom">
						<label for="password--verify" class="label--required label--top">
							Verify Password
						</label>
						<span class="input">
							<input type="password" name="password--verify" id="password--verify" class="input--text u-fill" placeholder="Re-enter password" required>
						</span>
					</div>
					<div class="register__action">
						<button type="button" class="button button--primary button--large" id="register__next">
							Next Step
						</button>
					</div>
					<div class="register__action--secondary">
						<span>Have an account?</span>
						<span id="register--switch" class="button--text">Sign in to your account</span>
					</div>
				</div>
				<div id="register--step-2" class="u-is-hidden">
					<h2 class="header u-m-large--bottom">Billing Address</h2>
					<table class="u-fill u-m-large--bottom">
						<tbody class="checkout__section">
							<tr class="checkout__row">
								<td>
									<label class="label--required">Full Name</label>
								</td>
								<td>
									<span class="input">
										<input type="text" name="name" id="name" class="input--text u-fill" placeholder="Your full name" required>
									</span>
								</td>
							</tr>
							<tr class="checkout__row">
								<td>
									<label class="label--required">Address</label>
								</td>
								<td>
									<span class="input">
										<input type="text" name="address" id="address" class="input--text u-fill" placeholder="Delivery address" required>
									</span>
								</td>
							</tr>
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
									<span class="input">
										<input type="text" name="phone" id="phone" class="input--text u-fill" placeholder="Phone number" required>
									</span>
								</td>
							</tr>
							<tr class="checkout__row">
								<td>
									<label>Country</label>
								</td>
								<td>
									<span class="input">
										<input type="text" name="country" id="country" class="input--text u-fill" placeholder="Country of residence">
									</span>
								</td>
							</tr>
							<tr class="checkout__row">
								<td>
									<label>Birthday</label>
								</td>
								<td>
									<span class="input">
										<input type="date" name="birthday" id="birthday" class="input--date u-fill">
									</span>
								</td>
							</tr>
						</tbody>
					</table>
					<div class="register__action">
						<button type="submit" class="button button--primary button--large" id="register__confirm">
							Confirm Registration
						</button>
					</div>
				</div>
			</div>
		</form>
	</div>