<?php
/**
 * Scripts
 *
 * @package fercor
 * @since 0.1.0
 **/

namespace fercor\setup;

class Scripts {
	public function __construct() {

		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ) );
		add_action( 'enqueue_block_assets', array( $this, 'editor_blocks' ) );


	}

	public function enqueue() {
		wp_register_style( 'fercor-styles', get_template_directory_uri() . '/dist/main.min.css', array(), filemtime( get_template_directory() . '/dist/main.min.css' ), 'all' );

		wp_enqueue_style( 'fercor-styles' );

		wp_register_script( 'fercor-scripts', get_template_directory_uri() . '/dist/main.js', array( 'jquery' ), filemtime( get_template_directory() . '/dist/main.js' ), true );

		wp_enqueue_script( 'fercor-scripts' );

	}

	public function editor_blocks(){
		wp_register_style( 'fercor-editor-styles', get_template_directory_uri() . '/dist/editor.min.css', array(), filemtime( get_template_directory() . '/dist/editor.min.css' ), 'all' );

		wp_enqueue_style( 'fercor-editor-styles' );

		wp_register_script( 'fercor-block-scripts', get_template_directory_uri() . '/dist/blocks.js', array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor', 'wp-data', 'wp-components' ), filemtime( get_template_directory() . '/dist/blocks.js' ), true );

		wp_enqueue_script( 'fercor-block-scripts' );
	}
}
