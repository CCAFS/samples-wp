<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package ccafs
 */
get_header(); ?>
	
	<div class="banner general">
			<div class="container header-wrapper">
			
				<header class="page-header">
					
					<h1 class="entry-title">Publications & Media</h1>
					<h4 class="subheader">Aenean massa. Maecenas egestas arcu quis ligula.</h4>
					
				</header><!-- .page-header -->
			</div><!-- /header-wrapper -->

	</div><!-- /banner -->
	<div  class="content-area container">
		<div class="row">
			<div class="col-sm-8" id="primary">
				<main id="main" class="site-main pub-media-list" role="main">
					

					<?php if ( have_posts() ) : ?>
					<?php /* Start the Loop */ ?>
						<?php while ( have_posts() ) : the_post(); ?>

							<?php
								/* Include the Post-Format-specific template for the content.
								 * If you want to override this in a child theme, then include a file
								 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
								 */
								get_template_part( 'template-parts/content-single', get_post_format() );
							?>

						<?php endwhile; ?>
						<?php wpbeginner_numeric_posts_nav(); ?>



					<?php else : ?>

						<?php get_template_part( 'template-parts/content', 'none' ); ?>

					<?php endif; ?>

				</main><!-- #main -->
			</div><!-- #primary -->

			<div class="col-sm-3 col-sm-offset-1  sidebar">
				
				<?php get_sidebar(); ?>
				

				<!-- Search and filter area -->
				<?php echo do_shortcode( '[searchandfilter id="621"]' ); ?>
				
				
				
				
			</div><!-- /sidebar -->

		</div><!-- /row -->

		
	</div><!-- /content-area -->

<?php get_footer(); ?>