<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package ccafs
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<link rel="apple-touch-icon" href="apple-touch-icon.png">
<link rel="icon" rel="icon" type="image/x-icon" href="/wp-content/themes/ccafs/favicon.ico">

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">

<!-- Latest compiled and minified JavaScript -->

<script src="/wp-content/themes/ccafs/js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div class="main-wrap">
	<div id="page" class="hfeed site">
		<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'ccafs' ); ?></a>

		<header id="masthead" class="site-header" role="banner">
			<div class="site-branding container">
				
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
				<div class="partners pull-right">
					<a href="http://ccafs.cgiar.org/" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/ccafs_new_logo_transp_rgb.png" alt="CCAFS logo" /></a></div>
				</div><!-- /partners -->
				
			</div><!-- .site-branding -->

			<nav id="site-navigation" class="main-navigation" role="navigation">
				<div class="container">
				<span class="nav-trigger glyphicon glyphicon-search pull-right" aria-hidden="true"></span>
					<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu' ) ); ?>
				</div>
				<?php dynamic_sidebar( 'header-search' ); ?>

			</nav><!-- #site-navigation -->

			

		</header><!-- #masthead -->

		<div id="content" class="site-content">
