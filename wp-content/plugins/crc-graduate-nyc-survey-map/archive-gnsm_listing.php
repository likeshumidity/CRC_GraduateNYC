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
							<fieldset>
							<label for="gnsm-burroughs">Burroughs</a>
							<select id="gnsm-burroughs" multiple>
<?php
foreach($crc_gnsm_listing_attributes['borroughs'] as $borrough) {
	echo '<option value="' . $borrough . '">' . $borrough . '</option>';
}
?>
							</select>
							</fieldset>
							<fieldset>
							<label for="gnsm-open-status">Open status</a>
							<select id="gnsm-open-status">
								<option value="All">All</option>
<?php
foreach($crc_gnsm_listing_attributes['statuses'] as $optionAttribute) {
	echo '<option value="' . $optionAttribute . '">' . $optionAttribute . '</option>';
}
?>
							</select>
							</fieldset>
							<fieldset>
							<label for="gnsm-target-population">Target population</a>
							<select id="gnsm-target-population">
								<option value="All">All</option>
<?php
foreach($crc_gnsm_listing_attributes['targetPopulation'] as $optionAttribute) {
	echo '<option value="' . $optionAttribute . '">' . $optionAttribute . '</option>';
}
?>
							</select>
							</fieldset>
							<fieldset>
							<label for="gnsm-grades-served">Grades served</a>
							<select id="gnsm-grades-served" multiple>
<?php
foreach($crc_gnsm_listing_attributes['gradesServed'] as $optionAttribute) {
	echo '<option value="' . $optionAttribute . '">' . $optionAttribute . '</option>';
}
?>
							</select>
							</fieldset>
							<fieldset>
							<label for="gnsm-services">Services</a>
							<select id="gnsm-services" multiple>
<?php
foreach($crc_gnsm_listing_attributes['services'] as $optionAttribute) {
	echo '<option value="' . $optionAttribute . '">' . $optionAttribute . '</option>';
}
?>
							</select>
							</fieldset>
						</form>
					</div>
<?php
// $avia_config['blog_style'] = apply_filters('avf_blog_style', avia_get_option('blog_style','multi-big'), 'archive');
$queryArgs = array(
	'post_type' => 'gnsm_listing',
	'posts_per_page' => -1,
);

$the_query = new WP_Query($queryArgs);

echo '<div class="post-count">' . $the_query->post_count . ' matching programs.</div>';

if ($the_query->have_posts()) {
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
	while($the_query->have_posts()) {
		$the_query->the_post();
		crc_gnsm_listing_echo($fields_for_listing, $the_query);
	}
	echo '</ul>';
} else {
	echo '<p class="nomatchinglistings">No matching listings. Please try using less filters.</p>';
}

function crc_gnsm_listing_echo($listingArray, $the_query) {
	if(gettype($listingArray) == 'array') {
		foreach($listingArray as $listingClass => $listingSpecs) {
			echo '<' . $listingSpecs[0] . ' class="' . $listingClass . '">';
			if (empty($listingSpecs[1])) {
				crc_gnsm_listing_echo($listingSpecs[2], $the_query);
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
