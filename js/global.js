/**
 * HTML Elements
 */

var HTML_LOGIN = `
	<div class="modal__window login">
		<div id="modal__close" class="modal__close">
			<i class="material-icons">close</i>
		</div>
		<h2 class="header u-m-large--bottom">Welcome back!</h2>
		<form method="post" id="form--login">
			<input type="hidden" name="todo" value="login">
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
`;

var HTML_REGISTER = `
	<div class="modal__window register">
		<div id="modal__close" class="modal__close">
			<i class="material-icons">close</i>
		</div>
		<form method="post" id="form--register" onsubmit="return validateRegistration();">
			<input type="hidden" name="todo" value="register">
			<div class="u-flex">
				<div id="register--step-1">
					<h2 class="header u-m-large--bottom">Create new account</h2>
					<div class="u-m-medium--bottom">
						<label for="email" class="label--required label--top">
							Email
						</label>
						<span class="input">
							<input type="text" name="email" id="email" class="input--text u-fill" placeholder="name@email.com" onblur="validateEmail()" required>
						</span>
					</div>
					<div class="u-m-medium--bottom">
						<label for="password" class="label--required label--top">
							Password
						</label>
						<span class="input">
							<input type="password" name="password" id="password" class="input--text u-fill" placeholder="Enter password" onblur="validatePassword()" required>
						</span>
					</div>
					<div class="u-m-large--bottom">
						<label for="password--verify" class="label--required label--top">
							Verify Password
						</label>
						<span class="input">
							<input type="password" name="password--verify" id="password--verify" class="input--text u-fill" placeholder="Re-enter password" onblur="verifyPassword()" required>
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
										<input type="text" name="name" id="name" class="input--text u-fill" placeholder="Your full name" onblur="validateName()" required>
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
										Men
									</label>
									<label for="gender--women" class="label--radio u-inline-block">
										<input type="radio" name="gender" value="women" id="gender--women" class="input--radio">
										Women
									</label>
								</td>
							</tr>
							<tr class="checkout__row">
								<td>
									<label class="label--required">Phone No.</label>
								</td>
								<td>
									<span class="input">
										<input type="text" name="phone" id="phone" class="input--text u-fill" placeholder="Phone number" onblur="validatePhone()" required>
									</span>
								</td>
							</tr>
							<tr class="checkout__row">
								<td>
									<label class="label--required">Country</label>
								</td>
								<td>
									<span class="input">
										<select name="country" id="country" class="input--text u-fill">` +
											country_options +
										`</select>
									</span>
								</td>
							</tr>
							<tr class="checkout__row">
								<td>
									<label>Birthday</label>
								</td>
								<td>
									<span class="input">
										<input type="text" name="birthday" id="birthday" class="input--date u-fill" onblur="validateBirthday()">
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
`;

/**
 * Modal
 */

var spawn = function(content, target, parentClass, parentId, cb) {
	// Definitions
	var el = document.createElement("div");

	// Add content and attributes to the modal
	if (parentId) {
		el.setAttribute("id", parentId)
	};
	if (parentClass) {
		el.setAttribute("class", parentClass)
	};
	el.innerHTML = content;
	target.insertBefore(el, target.firstChild);

	if (cb) return cb(el);
}

var spawnModal = function(content) {
	spawn(
		content,
		$('body'),
		'modal',
		'modal',
		attachRemover = function(parent) {
			modalClose = $('#modal__close', parent);
			if(modalClose) {
				modalClose.addEventListener('click', function() {
					parent.remove();
				});
			}
		}
	);

	if ($('#register--switch')) {
		$('#register--switch').addEventListener("click", function() {
			$('#modal').remove();
			spawnModal(HTML_LOGIN);
            var curUrl = window.location.href;
            document.getElementById("form--login").action = curUrl.substr(curUrl.lastIndexOf("/")+1);
		});
	}
	if ($('#login--switch')) {
		$('#login--switch').addEventListener("click", function() {
			$('#modal').remove();
			spawnModal(HTML_REGISTER);
            var curUrl = window.location.href;
            document.getElementById("form--register").action = curUrl.substr(curUrl.lastIndexOf("/")+1);
		});
	}
	if ($('#register__next')) {
		$('#register__next').addEventListener("click", function() {
			if(validateAccount()) {
				addClass($('#register--step-1'), 'u-is-hidden');
				removeClass($('#register--step-2'), 'u-is-hidden');
				console.log('click: register next');
			};
		});
	}
}

/**
 * Onload
 */

window.onload = function() {

	/**
	 * badge color handler
	 */
	if ($('.badge').innerHTML != 0) {
		removeClass($('.badge'), 'badge--empty');
	}

	/**
	 * #menu__button event handler
	 */
	if ($('#submenu__button--login')) {
		$('#submenu__button--login').addEventListener("click", function() {
			spawnModal(HTML_LOGIN);
			var curUrl = window.location.href;
			document.getElementById("form--login").action = curUrl.substr(curUrl.lastIndexOf("/")+1);
		});
	}

	if ($('#submenu__button--register')) {
		$('#submenu__button--register').addEventListener("click", function() {
			spawnModal(HTML_REGISTER);
			var curUrl = window.location.href;
			document.getElementById("form--register").action = curUrl.substr(curUrl.lastIndexOf("/")+1);
		});
	}

	/* Women */
	$('#menu__button--women').addEventListener("mouseover", function() {
		$('#nav--women').style.display = 'block';
	});
	$('#nav--women').addEventListener("mouseover", function() {
		$('#nav--women').style.display = 'block';
	});
	$('#menu__button--women').addEventListener("mouseout", function() {
		$('#nav--women').style.display = 'none';
	});
	$('#nav--women').addEventListener("mouseout", function() {
		$('#nav--women').style.display = 'none';
	});

	/* Men */
	$('#menu__button--men').addEventListener("mouseover", function() {
		$('#nav--men').style.display = 'block';
	});
	$('#nav--men').addEventListener("mouseover", function() {
		$('#nav--men').style.display = 'block';
	});
	$('#menu__button--men').addEventListener("mouseout", function() {
		$('#nav--men').style.display = 'none';
	});
	$('#nav--men').addEventListener("mouseout", function() {
		$('#nav--men').style.display = 'none';
	});
}

function $(selector, context) {
	return (context || document).querySelector(selector);
}

function addClass(el, className) {
	if (el.classList) el.classList.add(className);
	else if (!hasClass(el, className)) el.className += ' ' + className;
}

function removeClass(el, className) {
	if (el.classList) el.classList.remove(className);
	else el.className = el.className.replace(new RegExp('\\b'+ className+'\\b', 'g'), '');
}

