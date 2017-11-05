<!DOCTYPE html>
<html lang="en-GB">
<?php include './php/head.php'; ?>
<body class="debug o f h d">
	<?php
        session_start();

        //Connect to database
        $conn = new mysqli("localhost", "f36im", "f36im", "f36im");

        if ($conn->connect_error) {
            //Fallback if unable to connect to database
            exit();
        }


    include './php/nav.php' ;

    ?>
	<section class="contact">
		<div class="container">
			<div class="row">
				<div class="three column"></div>
				<div class="six column">
					<form onsubmit="return validateEmail();">
						<h2 class="header u-m-large--bottom">Contact Us</h2>
						<div class="u-flex">
							<div class="u-m-medium--bottom">
								<label for="email" class="label--required label--top">
									Email
								</label>
								<span class="input"><input type="text" name="email" id="email" onblur="validateEmail()" class="input--text u-fill" placeholder="name@email.com" required></span>
							</div>
							<div class="u-m-large--bottom">
								<label for="message" class="label--required label--top">
									Message
								</label>
								<span class="input"><textarea name="message" id="message" class="input--text u-fill" rows="5" placeholder="Enter your message." required></textarea></span>
							</div>
						</div>
						<div>
							<button type="submit" class="button button--primary button--large">
								Submit
							</button>
						</div>
					</form>
				</div>
				<div class="three column"></div>
			</div>
		</div>
	</section>
	<section class="map">
		<div class="container">
			<div class="row">
				<div class="two column"></div>
				<div class="three column">
					<h3 class="header">Store Location</h3>
					<p>
						Nanyang Technological University,<br>
						50 Nanyang Ave,<br>
						Singapore 639798
					</p>
					<p>
						contact@company.com<br>
						+65 9876 5432
					</p>
					<p>
						Monday - Saturday<br>
						6.00 - 10.00 p.m.
					</p>
				</div>
				<div class="five column">
					<iframe class="map__widget" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7529.690063014038!2d103.68075011498722!3d1.3478484640140431!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31da0f0a99014463%3A0xb8bb0800c52d8219!2sNanyang+Technological+University!5e0!3m2!1sen!2ssg!4v1509101359691" width="100%" height="300" frameborder="0" style="border:0" allowfullscreen></iframe>
				</div>
				<div class="two column"></div>
			</div>
		</div>
	</section>
	<?php include './php/footer.php' ?>
	<script type="text/javascript" src='./js/global.js'></script>
</body>
</html>
