<?php

function fercor_get_asset( $file ) {
	return get_theme_file_uri( 'dist/assets/' . $file );
}

function fercor_the_asset( $file ) {
	echo fercor_get_asset( $file );
}

function fercor_banner_title() {
	if ( is_404() ) {
		echo 'Error 404: Page not found';
	} elseif ( is_home() || is_single() ) {
		echo get_the_title( get_option( 'page_for_posts' ) );
	} else {
		the_title();
	}
}

function fercor_banner_content() {
	if ( is_home() || is_single() ) {
		$id = get_option( 'page_for_posts' );
	} else {
		$id = get_queried_object_id();
	}

	echo get_post_meta( $id, 'banner_text', true );
}

add_action( 'ff_pharmacy_finder', 'ff_pharmacy_finder' );
function ff_pharmacy_finder() {
	ob_start();

	?>

    <div class="pharmacy-finder">

        <div class="top">

            <label for="state" class="state"><span class="label-inner">State</span><br> <select name="state" id="state">
                    <option value="0"><?php _e( 'View All States' ); ?></option>
					<?php foreach ( ff_states() as $abbr => $state ) { ?>
                        <option value="<?php echo $abbr; ?>"><?php echo $state; ?></option>
					<?php } ?>
                </select> </label>

            <label for="pharmacy_name" class="pharmacy_name"><span class="label-inner">Pharmacy name</span><br>
                <select name="pharmacy_name" id="pharmacy_name">
                    <option value="0"><?php _e( 'View All Pharmacies' ); ?></option>
					<?php
					if ( $names = ff_pharmacy_names() ) {
						foreach ( $names as $pharmacy_location ) {
							?>
                            <option value="<?php echo $pharmacy_location->term_id; ?>"><?php echo $pharmacy_location->name; ?></option>
						<?php }
					} ?>
                </select> </label>
        </div>
        <ul class="middle">
            <li class="email" id="email-list"><a href="#pharmacy-list">Email this list</a></li>
            <li class="print" id="print-list"><a href="#pharmacy-list">Print this list</a></li>
        </ul>

        <div class="bottom">
            <ul class="pharmacy-list" id="pharmacy-list">

            </ul>
            <div class="mapcontain">
                <div id="map_pharmacy"></div>
            </div>
        </div>

    </div>

	<?php
}

add_action( 'wp_ajax_ff_get_pharmacy_search', 'ff_get_pharmacy_search' );
add_action( 'wp_ajax_nopriv_ff_get_pharmacy_search', 'ff_get_pharmacy_search' );
function ff_get_pharmacy_search() {
	$returnJSON = array();

	check_ajax_referer( 'ff_security_nonce', 'security' );

	unset( $_POST['security'] );
	unset( $_POST['action'] );

	extract( $_POST );

	//$term_id, $state

	//@todo Determine count for init load.
	$args = array(
		'post_type' => 'ff_pharmacy',
		'showposts' => '-1', //'-1',
		'orderby'   => 'title',
		'order'     => 'asc',
	);

	if ( isset( $term_id ) && $term_id != '0' ) {
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'ff_pharmacy_locations',
				'field'    => 'id',
				'terms'    => $term_id
			)
		);
	}

	if ( isset( $state ) && $state != '0' ) {
		$args['meta_query'] = array(
			array(
				'key'     => '_ff_addr_state',
				'value'   => $state,
				'compare' => '='
			),
		);
	}

	$pharmacies = get_posts( $args );

	$c = 0;
	foreach ( $pharmacies as $pharmacy ) {
		echo ff_render_pharmacy_item( $pharmacy, $c );
		$c ++;
	}

	wp_die();
}

function ff_render_pharmacy_item( $pharmacy, $c ) {
	$addr_address     = get_post_meta( $pharmacy->ID, '_ff_addr_address', true );
	$addr_address_two = get_post_meta( $pharmacy->ID, '_ff_addr_address_two', true );
	$addr_city        = get_post_meta( $pharmacy->ID, '_ff_addr_city', true );
	$addr_state       = get_post_meta( $pharmacy->ID, '_ff_addr_state', true );
	$addr_postal      = get_post_meta( $pharmacy->ID, '_ff_addr_postal', true );

	$addr_lat  = get_post_meta( $pharmacy->ID, '_ff_addr_latitude', true );
	$addr_long = get_post_meta( $pharmacy->ID, '_ff_addr_longitude', true );

	$address     = $addr_address . ' ' . $addr_address_two;
	$address_two = $addr_city . ' ' . $addr_state . ' ' . $addr_postal;

	$map_link = 'https://maps.google.com/?q=' . urlencode($address . $address_two);

	ob_start(); ?>

    <li data-lat="<?php echo $addr_lat; ?>" data-long="<?php echo $addr_long; ?>" id="pharm-<?php echo $pharmacy->ID; ?>">
        <h5><?php echo get_post_meta( $pharmacy->ID, '_ff_organization', true ); ?></h5>
        <p class="address"><?php echo $address; ?></p>
        <p class="address_two"><?php echo $address_two; ?></p>
        <p class="phone"><?php echo get_post_meta( $pharmacy->ID, '_ff_phone', true ); ?></p>
        <p class="fax"><?php echo get_post_meta( $pharmacy->ID, '_ff_fax', true ); ?></p>
        <p class="map"><a target="_blank" data-count="<?php echo $c; ?>" href="<?php echo $map_link; ?>">See Map</a></p>
    </li>

	<?php
	return ob_get_clean();
}

function ff_pharmacy_names() {

	$pharmacy_categories = get_terms( array(
		'taxonomy'   => 'ff_pharmacy_locations',
		'hide_empty' => false,
		'orderby'    => 'title',
	) );

	return $pharmacy_categories;
}

function ff_states() {
	$states = array(
		'AL' => 'Alabama',
		'AK' => 'Alaska',
		'AZ' => 'Arizona',
		'AR' => 'Arkansas',
		'CA' => 'California',
		'CO' => 'Colorado',
		'CT' => 'Connecticut',
		'DE' => 'Delaware',
		'DC' => 'District of Columbia',
		'FL' => 'Florida',
		'GA' => 'Georgia',
		'HI' => 'Hawaii',
		'ID' => 'Idaho',
		'IL' => 'Illinois',
		'IN' => 'Indiana',
		'IA' => 'Iowa',
		'KS' => 'Kansas',
		'KY' => 'Kentucky',
		'LA' => 'Louisiana',
		'ME' => 'Maine',
		'MD' => 'Maryland',
		'MA' => 'Massachusetts',
		'MI' => 'Michigan',
		'MN' => 'Minnesota',
		'MS' => 'Mississippi',
		'MO' => 'Missouri',
		'MT' => 'Montana',
		'NE' => 'Nebraska',
		'NV' => 'Nevada',
		'NH' => 'New Hampshire',
		'NJ' => 'New Jersey',
		'NM' => 'New Mexico',
		'NY' => 'New York',
		'NC' => 'North Carolina',
		'ND' => 'North Dakota',
		'OH' => 'Ohio',
		'OK' => 'Oklahoma',
		'OR' => 'Oregon',
		'PA' => 'Pennsylvania',
		'RI' => 'Rhode Island',
		'SC' => 'South Carolina',
		'SD' => 'South Dakota',
		'TN' => 'Tennessee',
		'TX' => 'Texas',
		'UT' => 'Utah',
		'VT' => 'Vermont',
		'VA' => 'Virginia',
		'WA' => 'Washington',
		'WV' => 'West Virginia',
		'WI' => 'Wisconsin',
		'WY' => 'Wyoming',
	);

	return apply_filters( 'ff_states', $states );
}
