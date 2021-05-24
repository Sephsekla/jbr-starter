<?php
/**
 * Post content
 *
 * @package fercor
 */

?>

<article>
	<span class="date"><?php the_date(); ?></span>
	<h2><?php the_title(); ?></h2>
	<?php the_content(); ?>
</article>
