<!DOCTYPE html>
<html lang="en-GB">
<head>
	<title>Prallie</title>
	<meta charset="utf-8">
	<meta name="description" content="Prallie is an educational project for NTU IM4717" />
	<meta name="author" content="IM4717-F36-DG09" />
	<meta name="robots" content="noindex"/>
	<meta http-equiv="cache-control" content="no-cache"/>
	<link rel="icon" type="image/png" href="https://lh3.google.com/u/0/d/0B2BwtQkZdGA2SHNQUnM1b2g2c1k=w1455-h947-iv1">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="./css/style.css">
</head>
<body class="debug o f h d">
	<?php include './php/index.php'; ?>
	<nav class="nav">
		<div class="nav--secondary">
			<div class="container">
				<div class="row">
					<div class="twelve column" >
						<div class="row nav__submenu">
							<a href="#" class="button submenu__button">Contact</a>
							<a href="#" class="button submenu__button">Support</a>
							<a href="#" class="button submenu__button"><strong>Register</strong></a>
							<a href="#" class="button submenu__button"><strong>Sign In</strong></a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="nav--primary">
			<div class="container">
				<div class="row">
					<div class="twelve column">
						<div class="row nav__menu">
							<a href="#" class="nav__logo"><img src="./images/logo.svg"></a>
							<a href="#" id="menu__button--women" class="button menu__button">Women</a>
							<a href="#" id="menu__button--men" class="button menu__button">Men</a>
							<form class="form--search menu__search">
								<input type="text" class="input search__input u-flex-fill" placeholder="Search collection">
								<button type="submit" class="button button--secondary search__button">
									<!-- <img src="http://via.placeholder.com/20x20" class="icon"> -->
									<div class="icon">
										<i class="material-icons">search</i>
									</div>
								</button>
							</form>
							<a href="#" class="button menu__button">
								<!-- <img src="http://via.placeholder.com/20x20" class="icon button__icon"> -->
								<!-- <div class="icon button__icon">
									<i class="material-icons">shopping_basket</i>
								</div> -->
								Shopping Bag
								<div class="badge badge--empty button__badge">
									0
								</div>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div id="nav--women" class="nav--tertiary">
			<div class="container">
				<div class="row">
					<div class="twelve column u-zero-padding">
						<div class="row nav__category">
							<a href="#" class="button category__button">Popular</a>
							<a href="#" class="button category__button">New</a>
							<a href="#" class="button category__button">Shirts &amp; Blouses</a>
							<a href="#" class="button category__button">T-Shirts</a>
							<a href="#" class="button category__button">Dresses</a>
							<a href="#" class="button category__button">Pants</a>
							<a href="#" class="button category__button">Shorts</a>
							<a href="#" class="button category__button">Skirts</a>
							<a href="#" class="button category__button">Outerwear</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div id="nav--men" class="nav--tertiary">
			<div class="container">
				<div class="row">
					<div class="twelve column u-zero-padding">
						<div class="row nav__category">
							<a href="#" class="button category__button">Popular</a>
							<a href="#" class="button category__button">New</a>
							<a href="#" class="button category__button">Shirts</a>
							<a href="#" class="button category__button">T-Shirts</a>
							<a href="#" class="button category__button">Pants</a>
							<a href="#" class="button category__button">Shorts</a>
							<a href="#" class="button category__button">Outerwear</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</nav>
	<div class="nav--fix"></div>
	<section class="hero">
		<div class="row">
			<div class="hero__half hero__half--women">
				<div class="container">
					<div class="row">
						<div class="twelve column">
							<a href="#" class="button button--primary hero__button">Shop Women's Collection</a>
						</div>
					</div>
				</div>
			</div>
			<div class="hero__half hero__half--men">
				<div class="container">
					<div class="row">
						<div class="twelve column">
							<a href="#" class="button button--primary hero__button">Shop Men's Collection</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section id="collection--popular">
		<div class="container">
			<div class="row">
				<div class="twelve column">
					<div class="collection__signifier"></div>
					<h2 class="header collection__header"><a href="#">Popular Collection</a></h2>
				</div>
			</div>
			<div class="row">
				<!-- DATA -->
				<div class="three column product">
					<div class="row product__image">
						<a href="#" class="u-flex">
							<!-- DATA -->
							<img src="./images/pexels-photo-428338.jpg">
						</a>
						<div class="product__label">
							<!-- DATA -->
							<div class="product__label--popular">Popular</div>
						</div>
					</div>
					<div class="row product__name">
						<!-- DATA -->
						WOMEN LOREM IPSUM Cotton Turtle Neck Long Sleeve T-Shirt
					</div>
					<div class="row product__price">
						<div class="product__price--current">
							<h3 class="header">
								<!-- DATA -->
								$19.90
							</h3>
						</div>
						<div class="product__price--pre-discount">
							<!-- DATA -->
							$29.90
						</div>
					</div>
					<div class="row product__color">
						<!-- DATA -->
						<a href="#"><div class="product__color--black"></div></a>
						<a href="#"><div class="product__color--dark-grey"></div></a>
						<a href="#"><div class="product__color--grey"></div></a>
					</div>
				</div>
				<div class="three column product">
					<div class="row product__image">
						<a href="#" class="u-flex">
							<!-- DATA -->
							<img src="./images/pexels-photo-428338.jpg">
						</a>
						<div class="product__label">
							<!-- DATA -->
							<div class="product__label--popular">Popular</div>
						</div>
					</div>
					<div class="row product__name">
						<!-- DATA -->
						WOMEN LOREM IPSUM Cotton Turtle Neck Long Sleeve T-Shirt
					</div>
					<div class="row product__price">
						<div class="product__price--current">
							<h3 class="header">
								<!-- DATA -->
								$19.90
							</h3>
						</div>
						<div class="product__price--pre-discount">
							<!-- DATA -->
							$29.90
						</div>
					</div>
					<div class="row product__color">
						<!-- DATA -->
						<a href="#"><div class="product__color--black"></div></a>
						<a href="#"><div class="product__color--dark-grey"></div></a>
						<a href="#"><div class="product__color--grey"></div></a>
					</div>
				</div>
				<div class="three column product">
					<div class="row product__image">
						<a href="#" class="u-flex">
							<!-- DATA -->
							<img src="./images/pexels-photo-428338.jpg">
						</a>
						<div class="product__label">
							<!-- DATA -->
							<div class="product__label--popular">Popular</div>
						</div>
					</div>
					<div class="row product__name">
						<!-- DATA -->
						WOMEN LOREM IPSUM Cotton Turtle Neck Long Sleeve T-Shirt
					</div>
					<div class="row product__price">
						<div class="product__price--current">
							<h3 class="header">
								<!-- DATA -->
								$19.90
							</h3>
						</div>
						<div class="product__price--pre-discount">
							<!-- DATA -->
							$29.90
						</div>
					</div>
					<div class="row product__color">
						<!-- DATA -->
						<a href="#"><div class="product__color--black"></div></a>
						<a href="#"><div class="product__color--dark-grey"></div></a>
						<a href="#"><div class="product__color--grey"></div></a>
					</div>
				</div>
				<div class="three column product">
					<div class="row product__image">
						<a href="#" class="u-flex">
							<!-- DATA -->
							<img src="./images/pexels-photo-428338.jpg">
						</a>
						<div class="product__label">
							<!-- DATA -->
							<div class="product__label--popular">Popular</div>
						</div>
					</div>
					<div class="row product__name">
						<!-- DATA -->
						WOMEN LOREM IPSUM Cotton Turtle Neck Long Sleeve T-Shirt
					</div>
					<div class="row product__price">
						<div class="product__price--current">
							<h3 class="header">
								<!-- DATA -->
								$19.90
							</h3>
						</div>
						<div class="product__price--pre-discount">
							<!-- DATA -->
							$29.90
						</div>
					</div>
					<div class="row product__color">
						<!-- DATA -->
						<a href="#"><div class="product__color--black"></div></a>
						<a href="#"><div class="product__color--dark-grey"></div></a>
						<a href="#"><div class="product__color--grey"></div></a>
					</div>
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
				<!-- DATA -->
				<div class="three column product">
					<div class="row product__image">
						<a href="#" class="u-flex">
							<!-- DATA -->
							<img src="./images/pexels-photo-428338.jpg">
						</a>
						<div class="product__label">
							<!-- DATA -->
							<div class="product__label--new">New</div>
						</div>
					</div>
					<div class="row product__name">
						<!-- DATA -->
						WOMEN LOREM IPSUM Cotton Turtle Neck Long Sleeve T-Shirt
					</div>
					<div class="row product__price">
						<div class="product__price--current">
							<h2 class="header">
								<!-- DATA -->
								$19.90
							</h2>
						</div>
						<div class="product__price--pre-discount">
							<!-- DATA -->
							$29.90
						</div>
					</div>
					<div class="row product__color">
						<!-- DATA -->
						<a href="#"><div class="product__color--black"></div></a>
						<a href="#"><div class="product__color--dark-grey"></div></a>
						<a href="#"><div class="product__color--grey"></div></a>
					</div>
				</div>
				<div class="three column product">
					<div class="row product__image">
						<a href="#" class="u-flex">
							<!-- DATA -->
							<img src="./images/pexels-photo-428338.jpg">
						</a>
						<div class="product__label">
							<!-- DATA -->
							<div class="product__label--new">New</div>
						</div>
					</div>
					<div class="row product__name">
						<!-- DATA -->
						WOMEN LOREM IPSUM Cotton Turtle Neck Long Sleeve T-Shirt
					</div>
					<div class="row product__price">
						<div class="product__price--current">
							<h2 class="header">
								<!-- DATA -->
								$19.90
							</h2>
						</div>
						<div class="product__price--pre-discount">
							<!-- DATA -->
							$29.90
						</div>
					</div>
					<div class="row product__color">
						<!-- DATA -->
						<a href="#"><div class="product__color--black"></div></a>
						<a href="#"><div class="product__color--dark-grey"></div></a>
						<a href="#"><div class="product__color--grey"></div></a>
					</div>
				</div>
				<div class="three column product">
					<div class="row product__image">
						<a href="#" class="u-flex">
							<!-- DATA -->
							<img src="./images/pexels-photo-428338.jpg">
						</a>
						<div class="product__label">
							<!-- DATA -->
							<div class="product__label--new">New</div>
						</div>
					</div>
					<div class="row product__name">
						<!-- DATA -->
						WOMEN LOREM IPSUM Cotton Turtle Neck Long Sleeve T-Shirt
					</div>
					<div class="row product__price">
						<div class="product__price--current">
							<h2 class="header">
								<!-- DATA -->
								$19.90
							</h2>
						</div>
						<div class="product__price--pre-discount">
							<!-- DATA -->
							$29.90
						</div>
					</div>
					<div class="row product__color">
						<!-- DATA -->
						<a href="#"><div class="product__color--black"></div></a>
						<a href="#"><div class="product__color--dark-grey"></div></a>
						<a href="#"><div class="product__color--grey"></div></a>
					</div>
				</div>
				<div class="three column product">
					<div class="row product__image">
						<a href="#" class="u-flex">
							<!-- DATA -->
							<img src="./images/pexels-photo-428338.jpg">
						</a>
						<div class="product__label">
							<!-- DATA -->
							<div class="product__label--new">New</div>
						</div>
					</div>
					<div class="row product__name">
						<!-- DATA -->
						WOMEN LOREM IPSUM Cotton Turtle Neck Long Sleeve T-Shirt
					</div>
					<div class="row product__price">
						<div class="product__price--current">
							<h2 class="header">
								<!-- DATA -->
								$19.90
							</h2>
						</div>
						<div class="product__price--pre-discount">
							<!-- DATA -->
							$29.90
						</div>
					</div>
					<div class="row product__color">
						<!-- DATA -->
						<a href="#"><div class="product__color--black"></div></a>
						<a href="#"><div class="product__color--dark-grey"></div></a>
						<a href="#"><div class="product__color--grey"></div></a>
					</div>
				</div>
			</div>
		</div>
	</section>
	<footer class="footer">
		<div class="container">
			<div class="row">
				<div class="twelve column u-zero-padding-left">
					<div class="row footer__menu">
						<a href="#" class="button footer__button ">Popular</a>|
						<a href="#" class="button footer__button ">New</a>|
						<a href="#" class="button footer__button ">Men</a>|
						<a href="#" class="button footer__button ">Women</a>|
						<a href="#" class="button footer__button ">Contact</a>|
						<a href="#" class="button footer__button ">Support</a>
						<div class="footer__copyright">
							Copyright © 2017 Prallie. All Rights Reserved.
						</div>
					</div>
				</div>
			</div>
		</div>
	</footer>
	<script type="text/javascript" src='./js/global.js'></script>
	<!-- Use this to override per page js -->
	<!-- <script type="text/javascript" src='./js/index.js'></script> -->
</body>
</html>