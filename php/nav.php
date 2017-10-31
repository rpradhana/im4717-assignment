<nav class="nav">
	<div class="nav--secondary">
		<div class="container">
			<div class="row">
				<div class="twelve column" >
					<div class="row nav__submenu">
						<a href="./contact.php" class="button submenu__button">Contact</a>
						<a href="./support.php" class="button submenu__button">Support</a>
						<span class="button submenu__button" id="submenu__button--register"><strong>Register</strong></span>
						<span class="button submenu__button" id="submenu__button--login"><strong>Sign In</strong></span>
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
						<a href="./index.php" class="nav__logo"><img src="./images/logo.svg" width="7.5rem"></a>
						<a href="./shop.php?gender[]=W" id="menu__button--women" class="button menu__button">Women</a>
						<a href="./shop.php?gender[]=M" id="menu__button--men" class="button menu__button">Men</a>
						<form class="menu__search">
							<input type="text" class="input--text search__input u-flex-1" placeholder="Search collection">
							<button type="submit" class="button button--secondary search__button">
								<div class="icon">
									<i class="material-icons">search</i>
								</div>
							</button>
						</form>
						<a href="./bag.php" class="button menu__button">
							<!-- <div class="icon button__icon">
								<i class="material-icons">shopping_basket</i>
							</div> -->
							Shopping Bag
							<div class="badge badge--empty button__badge">
                                <?php
                                    /*
                                     * To-do:
                                     * -String search
                                     */
                                    $cart_size = sizeof($_SESSION["cart"]);
                                    echo $cart_size;
                                ?>
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
				<div class="twelve column u-p-zero">
					<div class="row nav__category">
						<a href="./shop.php?gender[]=W&tag=popular"
						   class="button category__button">Popular</a>
						<a href="./shop.php?gender[]=W&tag=new"
						   class="button category__button">New</a>
						<a href="./shop.php?gender[]=W&category[]=SHRT"
						   class="button category__button">Shirts &amp; Blouses</a>
						<a href="./shop.php?gender[]=W&category[]=TSHT"
						   class="button category__button">T-Shirts</a>
						<a href="./shop.php?gender[]=W&category[]=DRSS"
						   class="button category__button">Dresses</a>
						<a href="./shop.php?gender[]=W&category[]=PNTS"
						   class="button category__button">Pants</a>
						<a href="./shop.php?gender[]=W&category[]=SHTS"
						   class="button category__button">Shorts</a>
						<a href="./shop.php?gender[]=W&category[]=SKTS"
						   class="button category__button">Skirts</a>
						<a href="./shop.php?gender[]=W&category[]=OTWR"
						   class="button category__button">Outerwear</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="nav--men" class="nav--tertiary">
		<div class="container">
			<div class="row">
				<div class="twelve column u-p-zero">
					<div class="row nav__category">
						<a href="./shop.php?gender[]=M&tag=popular"
						   class="button category__button">Popular</a>
						<a href="./shop.php?gender[]=M&tag=new"
						   class="button category__button">New</a>
						<a href="./shop.php?gender[]=M&category[]=SHRT"
						   class="button category__button">Shirts</a>
						<a href="./shop.php?gender[]=M&category[]=TSHT"
						   class="button category__button">T-Shirts</a>
						<a href="./shop.php?gender[]=M&category[]=PNTS"
						   class="button category__button">Pants</a>
						<a href="./shop.php?gender[]=M&category[]=SHTS"
						   class="button category__button">Shorts</a>
						<a href="./shop.php?gender[]=M&category[]=OTWR"
						   class="button category__button">Outerwear</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</nav>
<div class="nav--fix"></div>
