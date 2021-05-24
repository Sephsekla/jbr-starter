<?php
/*
 * Setup functions
 *
 * @package fercor
 * @since 0.1.0
 */

namespace fercor\setup;

class SetupTheme {

	public function __construct() {

		add_action( 'after_setup_theme', array( $this, 'init' ) );

		add_filter( 'get_custom_logo', array( $this, 'custom_logo' ) );

		add_filter( 'gform_submit_button', array( $this, 'form_submit_button' ), 10, 2 );

		add_action( 'wp_footer', array( $this, 'isi_modals' ) );

		add_filter( 'gform_field_validation', array( $this, 'custom_validation' ), 10, 4 );
		add_filter( 'body_class', array( $this, 'body_class' ), 10, 4 );



	}

	public function init() {

		load_theme_textdomain( 'fercor', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
		add_theme_support( 'title-tag' );

		/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'menu-1' => esc_html__( 'Primary', 'fercor' ),

			)
		);

		/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);

		add_theme_support( 'widgets' );

		add_image_size( 'square', 300, 300, true ); // (cropped)

		add_image_size( 'featured', 700, 380, true ); // (cropped)

	}

	/**
	 * Replace logo with SVG version for better scaling
	 *
	 * @return html
	 */
	public function custom_logo() {
		$html = sprintf(
			'<a href="%1$s" class="custom-logo-link" rel="home" itemprop="url">%2$s<span class="description">%3$s</span></a>',
			esc_url( home_url( '/' ) ),
			'<img src="' . fercor_get_asset( 'logo.svg' ) . '" class="custom-logo"width="70" height="33">',
			esc_attr( get_bloginfo( 'description' ) )
		);
		return $html;
	}


	/**
	 * Replace Gravity forms submit button with html5 button element
	 *
	 * @param  mixed $button
	 * @param  mixed $form
	 * @return void
	 */
	public function form_submit_button( $button, $form ) {
		return "<button class='button gform_button' id='gform_submit_button_{$form['id']}'><span>Submit</span></button>";
	}


	function custom_confirmation( $confirmation, $form, $entry, $ajax ) {
		if ( $form['id'] == '1' ) {

			ob_start();

			?>
<h2>Your Practice</h2>
<div class="gform_body submission-display">
	<ul class="gform_fields">
		<li class="gfield">
			<label class="gfield_label">Center/Practice Name</label>
			<p><?php esc_attr_e( rgar( $entry, '2' ) ); ?></p>
		</li>
		<li class="gfield">
			<label class="gfield_label">Physician(s)</label>
			<p><?php esc_attr_e( rgar( $entry, '5' ) ); ?></p>
		</li>
		<li class="gfield">
			<label class="gfield_label">Address Line 1</label>
			<p><?php esc_attr_e( rgar( $entry, '4' ) ); ?></p>
		</li>
		<li class="gfield">
			<label class="gfield_label">Address Line 2</label>
			<p><?php esc_attr_e( rgar( $entry, '6' ) ); ?></p>
		</li>
		<li class="gfield">
			<label class="gfield_label">City</label>
			<p><?php esc_attr_e( rgar( $entry, '7' ) ); ?></p>
		</li>
		<li class="gfield half">
			<label class="gfield_label">State/Province</label>
			<p><?php esc_attr_e( rgar( $entry, '9' ) ); ?></p>
		</li>
		<li class="gfield half">
			<label class="gfield_label">Postal Code</label>
			<p><?php esc_attr_e( rgar( $entry, '10' ) ); ?></p>
		</li>
		<li class="gfield">
			<label class="gfield_label">Phone</label>
			<p><?php esc_attr_e( rgar( $entry, '11' ) ); ?></p>
		</li>
		<li class="gfield">
			<label class="gfield_label">Email</label>
			<p><?php esc_attr_e( rgar( $entry, '11' ) ); ?></p>
		</li>
	</ul>
</div>

			<?php

			$confirmation = ob_get_clean();

		}
		return $confirmation;

	}

	public function isi_modals() {
		get_template_part( 'template-parts/header/isi/menopur' );
		get_template_part( 'template-parts/header/isi/ganirelix' );
		get_template_part( 'template-parts/header/isi/novarel' );
		get_template_part( 'template-parts/header/isi/invocell' );
		get_template_part( 'template-parts/header/isi/endometrin' );
	}

	public function custom_validation( $result, $value, $form, $field ) {

		if ( $field['isRequired'] && ( empty( $value ) || \GFCommon::is_empty_array( $value ) ) ) {

			$result['message']  = '*Please complete required field';
			$result['is_valid'] = false;

		}

		return $result;
	}

	function body_class( $classes ) {
	    global $post;

	    if ( $post->post_name ) {
			return array_merge( $classes, array( 'ff-'.$post->post_name ) );
		}

	    return $classes;
	}

}
