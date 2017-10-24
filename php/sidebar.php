<section class="sidebar">
	<form class="filter">
		<div class="u-m-medium--bottom">
			<h2 class="header">Narrow your search</h2>
		</div>
		<div id="option--tag" class="option-group">
			<?php
				$tag = array('popular'   => 'Popular',
				             'new'       => 'New',
				             'promotion' => 'Promotion');
				foreach($tag as $tag => $tag_string) {
					echo '
						<label for="tag--' . $tag . '" class="label label--checkbox">
							<input type="checkbox" name="tag" class="input--checkbox" id="tag--' . $tag . '">
							' . $tag_string . '
						</label>
					';
				}
			?>
		</div>
		<div id="option--gender" class="option-group">
			<div class="option__header">
				<h4>Gender</h4>
				<div class="header__button">
					Any Gender
				</div>
			</div>
			<?php
				$gender = array('men'   => 'Men',
				                'women' => 'Women');
				foreach($gender as $gender => $gender_string) {
					echo '
						<label for="gender--' . $gender . '" class="label label--checkbox">
							<input type="checkbox" name="gender" class="input--checkbox" id="gender--' . $gender . '">
							' . $gender_string . '
						</label>
					';
				}
			?>
		</div>
		<div id="option--type" class="option-group">
			<div class="option__header">
				<h4>Type</h4>
				<div class="header__button">
					Any Type
				</div>
			</div>
			<?php
				$type = array('shirt'     => 'Shirts and Blouses',
				              't-shirt'   => 'T-Shirts',
				              'dress'     => 'Dresses',
				              'pants'     => 'Pants',
				              'shorts'    => 'Shorts',
				              'skirts'    => 'Skirts',
				              'outerwear' => 'Outerwear');
				/**
				 * adjust key value pair and checkbox visibility
				 * depending on option--gender
				 */
				foreach($type as $type => $type_string) {
					echo '
						<label for="type--' . $type . '" class="label label--checkbox">
							<input type="checkbox" name="type" class="input--checkbox" id="type--' . $type . '">
							' . $type_string . '
						</label>
					';
				}
			?>
		</div>
		<!-- Show more button -->
		<div id="option--gender" class="option-group">
			<div class="option__header">
				<h4>Size</h4>
				<div class="header__button">
					Any Size
				</div>
			</div>
			<div class="row">
				<?php
					$size = array('xxs' => 'XXS',
					              'xs'  => 'XS',
					              's'   => 'S',
					              'm'   => 'M',
					              'l'   => 'L',
					              'xl'  => 'XL',
					              'xxl' => 'XXL');
					foreach($size as $size => $size_string) {
						echo '
							<div class="four column u-p-zero">
								<label for="size--' . $size . '" class="label label--checkbox">
									<input type="checkbox" name="size" class="input--checkbox" id="size--' . $size . '">
									' . $size_string . '
								</label>
							</div>
						';
					}
				?>
			</div>
		</div>
		<div id="option--color" class="option-group">
			<div class="option__header">
				<h4>Color</h4>
				<div class="header__button">
					Any Color
				</div>
			</div>
			<div class="row">
				<?php
					$color = array('beige'  => 'Beige',
					               'black'  => 'Black',
					               'blue'   => 'Blue',
					               'brown'  => 'Brown',
					               'green'  => 'Green',
					               'grey'   => 'Grey',
					               'yellow' => 'Yellow',
					               'orange' => 'Orange',
					               'pink'   => 'Pink',
					               'red'    => 'Red',
					               'white'  => 'White');
					foreach($color as $color => $color_string) {
						echo '
							<div class="six column u-p-zero">
								<label for="color--' . $color . '" class="label label--checkbox">
									<input type="checkbox" name="color" class="input--checkbox" id="color--' . $color . '">
									' . $color_string . '
								</label>
							</div>
						';
					}
				?>
			</div>
		</div>
		<div id="option--price" class="option-group">
			<div class="option__header">
				<h4>Price Range</h4>
				<div class="header__button">
					Any Price
				</div>
			</div>
			<div class="row price">
				<span class="input input--text price__input">$<input type="text" name="price--min" id="price--min" placeholder="Min"></span>
				<span>–</span>
				<span class="input input--text price__input">$<input type="text" name="price--max" id="price--max" placeholder="Max"></span>
			</div>
		</div>
		<button type="submit" class="button button--primary option__button">
			Apply Filters
		</button>
		<button type="reset" class="button button--secondary option__button">
			Clear All
		</button>
	</form>
</section>