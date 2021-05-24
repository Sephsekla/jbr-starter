<?php
/**
 * The main template file
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
		<section class="archive-loop overlap">
			<div class="container">
				<div class="container-inner-l bg-white accent-section loop-wrapper container-padded">
					<?php
		while ( have_posts() ) {
			the_post();
			get_template_part( 'template-parts/content', get_post_type() );
		}


			the_posts_navigation();

		?>
				</div>
			</div>
		</section>
	</main><!-- #main -->
</div><!-- #primary -->

<?php
get_footer();