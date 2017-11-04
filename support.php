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
	<div class="container">
		<div class="row">
			<div class="two column"></div>
			<div class="eight column">
				<section class="support">
					<h2 class="header">Help Centre</h2>
					<section class="support__section" id="shipping-delivery">
						<h3 class="header"><a href="#shipping-delivery" class="button--text">Shipping and Delivery</a></h3>
						<table class="u-fill">
							<tr class="table__row">
								<th>
									Type
								</th>
								<th>
									Cost
								</th>
								<th>
									<span class="u-no-wrap">Shipping Time</span>
								</th>
								<th>
									<span class="u-no-wrap">Availability</span>
								</th>
							</tr>
							<tr class="table__row">
								<td>
									Standard
								</td>
								<td>
									$6.00
								</td>
								<td>
									1 - 3 working days
								</td>
								<td>
									<span class="u-no-wrap">Mondays - Fridays</span><br>
									<span class="u-no-wrap">Not available on Public Holidays</span>
								</td>
							</tr>
							<tr class="table__row">
								<td>
									Express
								</td>
								<td>
									$18.00
								</td>
								<td>
									Next day
								</td>
								<td>
									<span class="u-no-wrap">Available all day</span>
								</td>
							</tr>
						</table>
						<p>
							We follow local time in Singapore SGT (UTC+7). Any order made before 11.59 p.m. will be counted as day zero for its delivery time.
						</p>
					</section>
					<section class="support__section" id="return-policy">
						<h3 class="header"><a href="#return-policy" class="button--text">Return Policy</a></h3>
						<p>
							You can, within 14 days of the order being received, return any goods in saleable condition.
						</p>
						<p>
							To process your return, please contact our customer center at +65 9876 5432 or contact@company.com or follow the instructions found at the back of the invoice that was sent with your order.
						</p>
						<p>
							You simply need to fill out the Return form (included at the bottom of your invoice), insert it into your return package, receive and print out the Shipping Label sent by our customer center via email, stick the label on a return package, and then drop off at any Post Office or POPSTATION nearby. Please allow 10~14 business days for us to process your return after we receive the items.</p>
						</p>
					</section>
					<section class="support__section" id="not-collected">
						<h3 class="header"><a href="#not-collected" class="button--text">How do I receive my orders if I am not home?</a></h3>
						<p>
							All orders are delivered through Singapore Post and will require a signature upon delivery. If you are not at home to receive your items, a notification card will be dropped in your mailbox to invite you to collect your parcel at the nearest Singapore Post office.
						</p>
					</section>
					<section class="support__section" id="help">
						<h3 class="header"><a href="#help" class="button--text">I need help!</a></h3>
						<p>
							Feel free to <a href="./contact.php">contact us</a> and let us know how we could help you! We will reply to your query within 1 working day.
						</p>
						<p>
							Your satisfaction is our utmost priority.
						</p>
					</section>
				</section>
			</div>
			<div class="two column"></div>
		</div>
	</div>
	<?php include './php/footer.php' ?>
	<script type="text/javascript" src='./js/global.js'></script>
</body>
</html>