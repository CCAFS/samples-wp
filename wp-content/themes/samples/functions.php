<?php
//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', 'Genesis Sample Theme' );
define( 'CHILD_THEME_URL', 'http://www.studiopress.com/' );
define( 'CHILD_THEME_VERSION', '2.1.2' );

//* Enqueue Google Fonts
add_action( 'wp_enqueue_scripts', 'genesis_sample_google_fonts' );
function genesis_sample_google_fonts() {

	wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Lato:300,400,700', array(), CHILD_THEME_VERSION );

}


/** Load jQuery and bootstrap.js script  just before closing Body tag */
add_action('genesis_after_footer', 'samples_script_add_body');
function samples_script_add_body() {
      
      wp_register_script ('bootstrap', '/wp-content/themes/samples/js/vendor/bootstrap.min.js' ); 
      
      wp_enqueue_script( 'bootstrap', '/wp-content/themes/samples/js/vendor/bootstrap.min.js', '3.3', false );
      
}

//* Add HTML5 markup structure
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Add support for custom background
add_theme_support( 'custom-background' );

//* Add support for 3-column footer widgets
add_theme_support( 'genesis-footer-widgets', 3 );


//* Register widget areas
genesis_register_sidebar( array(
	'id'          	=> 'samples-cta-overlay',
	'name'       	  => __( 'Samples Hero Image CTA', 'samples' ),
	'description'	  => __( 'Widgets placed here will appear on top of hero page template background image.', 'samples' ),
) );


/** Customize Genesis Footer */
/** This snippet will help to modify the complete genesis footer area */
remove_action( 'genesis_footer', 'genesis_do_footer' );
add_action( 'genesis_footer', 'samples_footer' );
function samples_footer() {
    ?>
    <p>&copy; Copyright 2015 <a href="http://mysite.com">MySite</a> &middot; All Rights Reserved &middot; And Our <a href="http://mysite.com/sitemap.xml" target="_blank">Sitemap</a> &middot; All Logos &amp; Trademark Belongs To Their Respective Owners&middot; </p>
    <?php
}
