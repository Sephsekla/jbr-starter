<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package fercor
 * */


?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>
	<div id="page" class="site">
		<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'fercor' ); ?></a>

		<header id="header-main" class="site-header">
			<div class="site-header-main">
				<div class="logo-wrapper"> <?php // 849 343 ?>
					<?php the_custom_logo(); ?>
				</div>
				<div class="nav-toggle-wrapper">
					<button class="toggle-nav toggle-button">
						<span class="inner screen-reader-text">Menu</span>
						<span class="line line-1"></span>
						<span class="line line-2"></span>
						<span class="line line-3"></span>
						<span class="line line-4"></span>
				</div>
				<div class="main-nav-wrapper">


					<nav class="main-nav" role="navigation" aria-expanded="false">
						<?php
							wp_nav_menu(
								array(
									'theme_location' => 'menu-1',
									'menu_id'        => 'primary-menu',
								)
							);
							?>
					</nav>
				</div>

		</header><!-- #masthead -->


		<div id="content" class="site-content">
		