	<div class="modal__window login">
		<div id="modal__close" class="modal__close">
			<i class="material-icons">close</i>
		</div>
		<h2 class="header u-m-large--bottom">Welcome back!</h2>
		<form>
			<div class="u-flex">
				<div class="u-m-medium--bottom">
					<label for="email" class="label--required label--top">
						Email
					</label>
					<span class="input">
						<input type="text" name="email" id="email" class="input--text u-fill" placeholder="name@email.com" required>
					</span>
				</div>
				<div class="u-m-large--bottom">
					<label for="password" class="label--required label--top">
						Password
					</label>
					<span class="input">
						<input type="password" name="password" id="password" class="input--text u-fill" placeholder="Enter password" required>
					</span>
				</div>
				<div class="login__action">
					<button type="submit" class="button button--primary button--large">
						Sign In
					</button>
				</div>
				<div class="login__action--secondary">
					<span class="button--text">Forgot your password?</span><br>
					<span id="login--switch">New to Prallie? <span id="login--switch" class="button--text">Create free account</span></span>
				</div>
			</div>
		</form>
	</div>