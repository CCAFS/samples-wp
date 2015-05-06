<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package ccafs
 */

get_header(); ?>
	
	<div class="container-fluid banner home">
		<div class="row">
			<div class="col-sm-8 home-banner-img">
				<div class="overlay">
					<p>SAMPLES is a global research program that supports tropical countries to measure greenhouse gas emissions from agriculture and identify mitigation options compatible with food security.</p>
				</div><!-- /overlay -->
			</div>

			<div class="col-sm-4 home-panels">
				<div class="panel panel-top ">
					<div class="row panel-wrap">
						<div class="icon emissions-data col-xs-3">
							<img src="<?php echo get_template_directory_uri(); ?>/images/EmissionsData.png" class="responsive" alt="Emissions Data" />
						</div>
						<div class="col-xs-9">
							<h4>Emissions Data</h4>
							<p>Emissions factors for specific agricultural practices</p>
							<div class="view-link">
								<a href="">VIEW <img src="<?php echo get_template_directory_uri(); ?>/images/arrow-right.png" class="arrow-right"></a>
							</div><!-- /view-link -->
						</div>
					</div><!-- /panel-wrap -->
					
				</div><!-- /panel-top-->
				<div class="panel panel-bottom">
					<div class="row panel-wrap">
						<div class="icon emissions-data col-xs-3">
							<img src="<?php echo get_template_directory_uri(); ?>/images/MeasurementMethods.png" class="responsive" alt="Measurement Methods" />
						</div>
						<div class="col-xs-9">
							<h4>Measurement methods</h4>
							<p>Guidelines for conducting field measurements</p>
							<div class="view-link">
								<a href="">VIEW <img src="<?php echo get_template_directory_uri(); ?>/images/arrow-right.png"src="" class="arrow-right"></a>
							</div><!-- /view-link -->
						</div>
					</div><!-- /panel-wrap -->
				</div><!-- /panel-top-->
				
			</div>

		
	</div><!-- /banner -->
	<div id="primary" class="content-area container">
		<main id="main" class="site-main" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'template-parts/content', 'page' ); ?>

				<?php
					// If comments are open or we have at least one comment, load up the comment template
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;
				?>

			<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
