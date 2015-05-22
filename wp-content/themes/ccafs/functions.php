<?php
/**
 * ccafs functions and definitions
 *
 * @package ccafs
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 640; /* pixels */
}

if ( ! function_exists( 'ccafs_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function ccafs_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on ccafs, use a find and replace
	 * to change 'ccafs' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'ccafs', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	// Add featured image sizes
	add_image_size( 'featured-thumb', 250, 160, true );
	add_image_size( 'featured-blog-image', 700, 450, true );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'ccafs' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'ccafs_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif; // ccafs_setup
add_action( 'after_setup_theme', 'ccafs_setup' );

add_action( 'init', 'create_post_type' );
function create_post_type() {
  register_post_type( 'mm_chapter',
    array(
      'labels' => array(
        'name' => __( 'MM Chapters' ),
        'singular_name' => __( 'MM Chapter' )
      ),
      'public' => true,
      'has_archive' => false,
      'rewrite' => array('slug' => 'measurement-methods'),
    )
  );
}

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function ccafs_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'ccafs' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );

	register_sidebar( array(
		'name'          => 'header', 'ccafs',
		'id'            => 'header-search',
		'before_widget' => '<div id="nav-search">',
		'after_widget'  => '</div>',
		'before_title'  => '',
		'after_title'   => '',
	) );
}
add_action( 'widgets_init', 'ccafs_widgets_init' );


/**
 * Enqueue scripts and styles.
 */

/* jquery, from CSS Tricks */
if (!is_admin()) add_action("wp_enqueue_scripts", "my_jquery_enqueue", 11);
function my_jquery_enqueue() {
   wp_deregister_script('jquery');
   wp_register_script('jquery', "http" . ($_SERVER['SERVER_PORT'] == 443 ? "s" : "") . "://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js", false, null);
   wp_enqueue_script('jquery');
}

function ccafs_scripts() {
	wp_enqueue_style( 'ccafs-style', get_stylesheet_uri() );
    wp_enqueue_style( 'ccafs-fonts',  'http://fonts.googleapis.com/css?family=Alegreya+Sans:400,700,800,400italic|Karma:500' );

	wp_enqueue_script( 'ccafs-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );
	wp_enqueue_script( 'ccafs-bootstrap-js', get_template_directory_uri() . '/js/vendor/bootstrap.min.js', array(), '3', true );
	wp_enqueue_script( 'ccafs-main-js', get_template_directory_uri() . '/js/main.js', array(), '', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'ccafs_scripts' );

/**
 * Implement the Custom Header feature.
 */
//require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/* Creating custom search function for Measurement Methods */
 function template_chooser($template)   
{    
  global $wp_query;   
  $post_type = get_query_var('post_type');   
  if( $wp_query->is_search && $post_type == 'mm_chapter' )   
  {
    return locate_template('mm-chapter-search.php');  
  }   
  return $template;   
}
add_filter('template_include', 'template_chooser'); 


// limit the excerpt 
function custom_excerpt_length( $length ) {
	return 25;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );


// custom taxonomies 




