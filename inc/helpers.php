<?php

function *_SLUG_*_get_asset( $file ) {
	return get_theme_file_uri( 'dist/assets/' . $file );
}

function *_SLUG_*_the_asset( $file ) {
	echo *_SLUG_*_get_asset( $file );
}

