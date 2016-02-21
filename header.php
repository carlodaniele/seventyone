<?php
/**
 * @package WordPress
 * @subpackage Seventy-One-WordPress-Theme
 * @since Seventy One 1.0
 */
?><!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
<!-- the "no-js" class is for Modernizr. -->
<head>
	<meta charset="<?php bloginfo('charset'); ?>">

	<!--
		j.mp/mobileviewport & davidbcalhoun.com/2010/viewport-metatag
		 - device-width : Occupy full width of the screen in its current orientation
		 - initial-scale = 1.0 retains dimensions instead of zooming out if page height > device height
		 - maximum-scale = 1.0 retains dimensions instead of zooming in if page width < device width
		 - minimal-ui = iOS devices have minimal browser ui by default
	-->
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- Always force latest IE rendering engine (even in intranet) -->
	<!--[if IE ]>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<![endif]-->

	<meta name="title" content="<?php wp_title( '|', true, 'right' ); ?>">

	<!--Google will often use this as its description of your page/site. Make it good.-->
	<meta name="description" content="<?php bloginfo('description'); ?>" />

	<title><?php wp_title( '|', true, 'right' ); ?></title>

	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<!-- concatenate and minify for production -->
	<!-- <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/normalize.css"> -->
	<link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>" />

	<!-- Lea Verou's Prefix Free, lets you use only un-prefixed properties in yuor CSS files -->
    <script src="<?php echo get_template_directory_uri(); ?>/js/vendor/prefixfree.min.js"></script>

	<!-- This is an minified, customized version of Modernizr. -->
	<script src="<?php echo get_template_directory_uri(); ?>/js/vendor/modernizr-2.8.3.min.js"></script>

	<?php wp_head(); ?>

	<style type="text/css">
	a.home-link h1{
		color: <?php echo get_theme_mod('seventyone_header_color', '#555555' ); ?>;
	}
	</style>
</head>

<body <?php body_class(); ?>>

	<!-- not needed? up to you: http://camendesign.com/code/developpeurs_sans_frontieres -->
	<div id="page" class="site">

		<header id="site-header" class="site-header" role="banner">
			<a class="home-link" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
				<h1 class="site-title"><?php bloginfo( 'name' ); ?></h1>
				<h3 class="site-description"><?php bloginfo( 'description' ); ?></h3>
			</a>

			<nav id="primary-navigation" class="site-navigation primary-navigation" role="navigation">
				<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav-menu' ) ); ?>
				<!-- <?php get_search_form(); ?> -->
			</nav>
		</header>