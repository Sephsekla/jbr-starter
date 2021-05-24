<?php
/**
 * The 404 template file
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package fercor
 */

get_header();
?>

<div id="primary" class="content-area">
	<main id="main" class="site-main">



		<?php

		get_template_part( 'template-parts/banner' );
		get_template_part( 'template-parts/updates' );

		?>

	</main><!-- #main -->
</div><!-- #primary -->

<?php
get_footer();