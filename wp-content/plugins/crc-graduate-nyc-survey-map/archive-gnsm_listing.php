<?php
global $avia_config, $more;

/*
 * get_header is a basic wordpress function, used to retrieve the header.php file in your theme directory.
 */
get_header();
	
echo avia_title(array('title' => 'Graduate NYC Program Survey Listings'));
		
do_action( 'ava_after_main_title' );

?>

		<div class='container_wrap container_wrap_first main_color <?php avia_layout_class( 'main' ); ?>'>

			<div class='container template-blog '>

				<main class='content <?php avia_layout_class( 'content' ); ?> units' <?php avia_markup_helper(array('context' => 'content','post_type'=>'gnsm_listing'));?>>

					<div class="crc-gnsm-back-to-map"><a href="mapLink">Map View</a></div>
					<div class="crc-gnsm-form-container">
						<form id="crc-gnsm-listings-form" method="get">
<?php

foreach($crc_gnsm_listing_attributes as $att => $attDetails) {
	echo '<fieldset>';
	echo '<label for="gnsm-' . $att . '">';
	echo strtoupper(substr($att, 0, 1)) . str_replace('-', ' ', substr($att, 1));
	echo '</label>';
	echo '<' . str_replace('-', ' ', $attDetails[0]) . ' id="gnsm-' . $att . '" name="' . $att;
	if ($attDetails[0] == 'select') {
		echo '">';
		echo '<option value=""></option>';
	} else {
		echo '[]">';
	}

	foreach($attDetails[1] as $attValue) {
		echo '<option';
		if (isset($_GET[$att])) {
			if (gettype($_GET[$att]) == 'array') {
				if (in_array($attValue, $_GET[$att])) {
					echo ' selected';
				}
			} else {
				if ($_GET[$att] == $attValue) {
					echo ' selected';
				}
			}
		}
		echo ' value="' . $attValue . '">';
		echo $attValue;
		echo '</option>';
	}
	echo '</select>';
	echo '</fieldset>' . "\n";
}

console_log($wp_query->query_vars);
console_log($wp_query->request);

?>

							<input type="submit" value="Update Listings" />
							<a href="../gnsm_listing">Clear filters</a>
						</form>
					</div>
<?php

echo '<div class="post-count">' . $wp_query->post_count . ' matching programs.</div>';

if ($wp_query->have_posts()) {
	echo '<ul class="gnsm-program-listings">';
	$fields_for_listing = array(
		'program-listing' => array('li', '', array(
			'title' => array('div', 'the_title();'),
			'phone' => array('div', '', 'field_5706de6175f21'),
			'physical-address' => array('div', '', array(
				'line-1' => array('span', '', 'field_5706dddf75fld'),
				'line-2' => array('span', '', 'field_5706de0275f1e'),
				'city' => array('span', '', 'field_5706de0275f1e'),
				'state' => array('span', '', 'field_5706de4675f20'),
				'postal-code' => array('span', '', 'field_5706deca75f22'),
			)),
			'description' => array('div', '', 'field_5706df2275f23'),
		)),
				
	);
	while($wp_query->have_posts()) {
		$wp_query->the_post();
		crc_gnsm_listing_echo($fields_for_listing, $wp_query);
	}
	echo '</ul>';
} else {
	echo '<p class="nomatchinglistings">No matching listings. Please try using less filters.</p>';
}

function crc_gnsm_listing_echo($listingArray, $query) {
	if(gettype($listingArray) == 'array') {
		foreach($listingArray as $listingClass => $listingSpecs) {
			echo '<' . $listingSpecs[0] . ' class="' . $listingClass . '">';
			if (empty($listingSpecs[1])) {
				crc_gnsm_listing_echo($listingSpecs[2], $query);
			} else {
				eval($listingSpecs[1]);
			}
			echo '</' . $listingSpecs[0] . '>';
		}
	} else {
		$valueField = get_field($listingArray);
		if (!empty($valueField)) {
			echo $valueField;
		}
	}
}

?>

				</main><!--end content-->

			</div><!--end container-->

		</div><!-- close default .container_wrap element -->




<?php get_footer(); ?>
