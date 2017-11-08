<section class="sidebar">
		<div class="u-m-medium--bottom">
			<h2 class="header">Narrow your search</h2>
		</div>
		<div id="option--tag" class="option-group">
			<?php
//				$tag = array('popular'   => 'Popular',
//				             'new'       => 'New',
//				             'promotion' => 'Promotion');
                $tag = array('promotion' => 'Promotion');
				foreach($tag as $tag => $tag_string) {
					echo '
						<label for="tag--' . $tag . '" class="label label--checkbox">
							<input type="checkbox" name="tag[]" value="' . $tag_string . '" class="input--checkbox" id="tag--' . $tag . '"' .
                            (in_array($tag_string, $_GET["tag"]) ? ' checked' : '') .'>
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
							<input type="checkbox" name="gender[]" value="' . $gender_string[0] . '" class="input--checkbox" id="gender--' . $gender . '" ' .
                        (in_array($gender_string[0], $_GET["gender"]) ? ' checked' : '') . ' onchange="toggleGender(this)">
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
                $categories = array('SHRT'     => 'Shirts and Blouses',
				              'TSHT'   => 'T-Shirts',
				              'DRSS'     => 'Dresses',
				              'PNTS'     => 'Pants',
				              'SHTS'    => 'Shorts',
				              'SKTS'    => 'Skirts',
				              'OTWR' => 'Outerwear');
				/**
				 * adjust key value pair and checkbox visibility
				 * depending on option--gender
				 */
                $men_selected = in_array('m', $_GET["gender"]);
                $women_selected = in_array('w', $_GET["gender"]);
				foreach($categories as $category => $category_string) {
					echo '  <label for="category--' . $category . '" class="label label--checkbox">
                                <div id="option--'. $category .'"' . (($category == 'DRSS' || $category == 'SKTS') ? (($women_selected || !$men_selected) ? '' : ' style="display:none;"') : '') . '>
                                    <input type="checkbox" name="category[]" value="' . $category . '" class="input--checkbox" id="category--' . $category . '"' .
                                    (($category == 'DRSS' || $category == 'SKTS') ? (($women_selected || !$men_selected) ? (in_array($category, $_GET["category"]) ? ' checked' : '') : '') : (in_array($category, $_GET["category"]) ? ' checked' : '')) .'>
                                    <span id= "inner' . $category . '">' . ($category == 'SHRT' ? (($women_selected || !$men_selected) ? $category_string : 'Shirts') : $category_string) . '</span>
                                </div>
						    </label>';
				}
			?>
		</div>
		<!-- Show more button -->
		<div id="option--gender" class="option-group">
			<div class="option__header">
				<h4>Size</h4>
				<div class="header__button">
					Any Sizez
				</div>
			</div>
			<div class="row">
				<?php
                    $query = "SELECT DISTINCT size FROM inventory;";
                    $result = $conn->query($query);
                    $size = array();
                    if ($result) {
                        $num_rows = $result->num_rows;
                        if ($num_rows > 0) {
                            for ($i = 0 ; $i < $num_rows; $i++) {
                                $row = $result->fetch_assoc();
                                $size[strtolower($row["size"])] = $row["size"];
                            }
                        }
                    } else {
                        $size = array('xxs' => 'XXS',
                            'xs'  => 'XS',
                            's'   => 'S',
                            'm'   => 'M',
                            'l'   => 'L',
                            'xl'  => 'XL',
                            'xxl' => 'XXL');
                    }
					foreach($size as $size => $size_string) {
						echo '
							<div class="four column u-p-zero">
								<label for="size--' . $size . '" class="label label--checkbox">
									<input type="checkbox" name="size[]" value="' . $size_string . '" class="input--checkbox" id="size--' . $size . '"' .
                                    (in_array($size_string, $_GET["size"]) ? ' checked' : '') .'>
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
                    $query = "SELECT DISTINCT color FROM inventory;";
                    $result = $conn->query($query);
                    $color = array();
                    if ($result) {
                        $num_rows = $result->num_rows;
                        if ($num_rows > 0) {
                            for ($i = 0 ; $i < $num_rows; $i++) {
                                $row = $result->fetch_assoc();
                                $color[lcfirst($row["color"])] = $row["color"];
                            }
                        }
                    } else {
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
                    }

					foreach($color as $color => $color_string) {
						echo '
							<div class="six column u-p-zero">
								<label for="color--' . $color . '" class="label label--checkbox">
									<input type="checkbox" name="color[]"  value="' . $color_string . '" class="input--checkbox" id="color--' . $color . '"' .
                                    (in_array($color_string, $_GET["color"]) ? ' checked' : '') .'>
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
                <?php
                    echo '  <span class="input--text price__input">$
                                <input type="text" name="price--min" id="price--min" placeholder="Min"' .
                                (isset($_GET["price--min"]) && ($_GET["price--min"] > 0) ? (' value="' . $_GET["price--min"] . '"') : '') . ' oninput="validatePrice(this)">
                            </span>
                            <span>–</span>
                            <span class="input--text price__input">$
                                <input type="text" name="price--max" id="price--max" placeholder="Max"' .
                                (isset($_GET["price--max"]) && ($_GET["price--max"] > 0) ? (' value="' . $_GET["price--max"] . '"') : '') . ' oninput="validatePrice(this)">
                            </span>'
                ?>
			</div>
		</div>
		<button type="submit" class="button button--primary option__button">
			Apply Filters
		</button>
		<button type="reset" class="button button--secondary option__button">
			Clear All
		</button>
</section>
<script type='text/javascript' src='./js/global.js'></script>

