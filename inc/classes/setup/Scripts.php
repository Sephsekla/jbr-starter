<?php
/*
 * Scripts
 *
 * @package fercor
 * @since 0.1.0
 */

namespace fercor\setup;

class Scripts {
	public function __construct() {

		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ) );

	}

	public function enqueue() {
		wp_register_style( 'fercor-styles', get_template_directory_uri() . '/dist/main.min.css', array(), filemtime( get_template_directory() . '/dist/main.min.css' ), 'all' );

		wp_enqueue_style( 'fercor-styles' );

		wp_register_script( 'fercor-scripts', get_template_directory_uri() . '/dist/main.js', array( 'jquery','googlemaps' ), filemtime( get_template_directory() . '/dist/main.js' ), true );

		wp_localize_script( 'fercor-scripts', 'ajaxData',
			array(
				'ajaxUrl'  => admin_url( 'admin-ajax.php' ),
				'security' => wp_create_nonce( 'ff_security_nonce' )
			)
		);

		wp_enqueue_script( 'fercor-scripts' );

	}
}
