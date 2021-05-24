<?php
/**
 * Scripts
 *
 * *_PACKAGE_*
 * @since 0.1.0
 **/

namespace *_SLUG_*\setup;

class Scripts {
	public function __construct() {

		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ) );
		add_action( 'enqueue_block_assets', array( $this, 'editor_blocks' ) );


	}

	public function enqueue() {
		wp_register_style( '*_SLUG_*-styles', get_template_directory_uri() . '/dist/main.min.css', array(), filemtime( get_template_directory() . '/dist/main.min.css' ), 'all' );

		wp_enqueue_style( '*_SLUG_*-styles' );

		wp_register_script( '*_SLUG_*-scripts', get_template_directory_uri() . '/dist/main.js', array( 'jquery' ), filemtime( get_template_directory() . '/dist/main.js' ), true );

		wp_enqueue_script( '*_SLUG_*-scripts' );

	}

	public function editor_blocks(){
		wp_register_style( '*_SLUG_*-editor-styles', get_template_directory_uri() . '/dist/editor.min.css', array(), filemtime( get_template_directory() . '/dist/editor.min.css' ), 'all' );

		wp_enqueue_style( '*_SLUG_*-editor-styles' );

		wp_register_script( '*_SLUG_*-block-scripts', get_template_directory_uri() . '/dist/blocks.js', array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor', 'wp-data', 'wp-components' ), filemtime( get_template_directory() . '/dist/blocks.js' ), true );

		wp_enqueue_script( '*_SLUG_*-block-scripts' );
	}
}
