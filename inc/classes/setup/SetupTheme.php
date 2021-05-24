<?php
/**
 * Setup functions
 *
 * |_PACKAGE_|
 *
 * @since 0.1.0
 **/

namespace | _SLUG_ | \setup;

class SetupTheme {

	public function __construct() {

		add_action( 'after_setup_theme', array( $this, 'init' ) );

		add_filter( 'get_custom_logo', array( $this, 'custom_logo' ) );

	}

	public function init() {

		load_theme_textdomain( '|_SLUG_|', get_template_directory() . '/languages' );

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
				'menu-1' => esc_html__( 'Primary', '|_SLUG_|' ),

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

		add_theme_support( 'align-wide' );

		// Adds support for editor color palette.
		add_theme_support(
			'editor-color-palette',
			array( // Extend this array with our brand colours
				array(
					'name'  => 'Black',
					'slug'  => 'black',
					'color' => '#000000',
				),
			)
		);

		// Disables custom colors in block color palette.
		add_theme_support( 'disable-custom-colors' );

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
			'<img src="' . | _SLUG_ | _get_asset( 'logo.svg' ) . '" class="custom-logo"width="70" height="33">',
			esc_attr( get_bloginfo( 'description' ) )
		);
		return $html;
	}



}
