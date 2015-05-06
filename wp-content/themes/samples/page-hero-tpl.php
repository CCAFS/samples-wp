<?php
 
/* Template Name: Hero Image
----------------------------------*/
 
//* Enqueue scripts and styles
add_action( 'wp_enqueue_scripts', 'samples_image_load_scripts_styles' );
function samples_image_load_scripts_styles() {
 
 if ( has_post_thumbnail() ) {
 	wp_enqueue_script( 'cegg-backstretch', '/wp-content/themes/samples/js/vendor/backstretch.js', array( 'jquery' ), '1.0.0', true );
	wp_enqueue_script( 'cegg-backstretch-set', '/wp-content/themes/samples/js/vendor/backstretch-set.js' , array( 'jquery', 'cegg-backstretch' ), '1.0.0', true );
 }
 
}
 
//* Localize backstretch script for hero image page template
add_action( 'genesis_after_entry', 'samples_set_background_image' );
function samples_set_background_image() {
 
 $image = array( 'src' => has_post_thumbnail() ? genesis_get_image( array( 'format' => 'url' ) ) : '' );
 wp_localize_script( 'cegg-backstretch-set', 'BackStretchImg', $image );
 
}
 
//* Add overlay widget to sales page background image
add_action( 'genesis_after_header', 'samples_image_overlay', 5 );
 
function samples_image_overlay() {
 if ( has_post_thumbnail() ) {
	
  echo '<div class="samples-cta"><div class="wrap">';
	genesis_widget_area( 'samples-cta-overlay' );
  echo '</div></div>';
 
  }
	
}

//* Add custom body class
add_filter( 'body_class', 'samples_add_body_class' );
function samples_add_body_class( $classes ) {
   $classes[] = 'samples-hero-image';
   return $classes;
}
 
//* Force full width, removing sidebar layout
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
 
//* Remove header, navigation, breadcrumbs, footer widgets, footer
 
remove_action( 'genesis_after_header', 'genesis_do_nav' );
remove_action( 'genesis_before', 'genesis_do_subnav' );
 
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );
 
remove_action( 'genesis_after', 'genesis_footer_widget_areas' );
 
remove_action( 'genesis_after', 'genesis_footer_markup_open', 11 );
remove_action( 'genesis_after', 'genesis_do_footer', 12 );
remove_action( 'genesis_after', 'genesis_footer_markup_close', 13 );
remove_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
remove_action( 'genesis_footer', 'genesis_do_footer' );
remove_action( 'genesis_footer', 'genesis_footer_markup_close', 15 );
 
remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_close', 15 );
remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
 
 
genesis();