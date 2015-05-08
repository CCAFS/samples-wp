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
			<div class="col-sm-7 home-banner-img">
				<div class="overlay">
					<p>SAMPLES is a global research program that supports tropical countries to measure greenhouse gas emissions from agriculture and identify mitigation options compatible with food security.</p>
				</div><!-- /overlay -->
			</div>

			<div class="col-sm-5 home-panels">
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
								<a href="">VIEW <img src="<?php echo get_template_directory_uri(); ?>/images/arrow-right.png" class="arrow-right"></a>
							</div><!-- /view-link -->
						</div>
					</div><!-- /panel-wrap -->
				</div><!-- /panel-bottom-->
				
			</div>

		</div><!-- /row -->
	</div><!-- /banner -->
	<div id="primary" class="content-area container">

		<div class="row">
			<div class="col-sm-7 home-intro-block">
				<main id="main" class="site-main" role="main">
					<h6>Why Samples?</h6>
					<p class="gray">SAMPLES addresses the dearth of reliable information about greenhouse gas emissions from agriculture in <a href="">tropical countries</a> this is the <a href="">mouse over</a> event. SAMPLES scientists work with developing countries to improve data on agricultural greenhouse gas emissions and mitigation potentials.</p>
					<div class="more-plus-arrow">
						<a href="/about">MORE ABOUT US <img src="<?php echo get_template_directory_uri(); ?>/images/arrow-right.png" class="arrow-right"></a>
					</div><!-- /more-plus-arrow -->

					<div class="map-block clearfix">
						<h2 class="white">Our network of research sites stretch across the globe.</h2>
						<h5 class="white">Aliquet elit ac nisl. Phasellus consectetuer vestibulum elit. Praesent adipiscing. Phasellus tempus.</h5>
						<div class="more-plus-arrow map pull-right">
							<a href="/map">VIEW MAP <img src="<?php echo get_template_directory_uri(); ?>/images/arrow-right.png" class="arrow-right"></a>
						</div>

					</div><!-- /map-block -->
					

						<?php //while ( have_posts() ) : the_post(); ?>

							<?php //get_template_part( 'template-parts/content', 'page' ); ?>

						<?php //endwhile; // end of the loop. ?> 

				</main><!-- #main -->
			</div><!-- col-sm-7 -->

			<div class="col-sm-4 col-sm-offset-1 news-column">
				
				<h6>News</h6>
				<h4><a href="">SAMPLES quantification guidelines drafts available</a></h4>
				<p>Vivamus aliquet elit ac nisl. Phasellus consectetuer vestibulum elit. Praesent adipiscing. Phasellus tempus.</p>
				<h4><a href="">SAMPLES quantification guidelines drafts available</a></h4>
				<p>Vivamus aliquet elit ac nisl. Phasellus consectetuer vestibulum elit. Praesent adipiscing. Phasellus tempus.</p>
				<h4><a href="">SAMPLES quantification guidelines drafts available</a></h4>
				<p>Vivamus aliquet elit ac nisl. Phasellus consectetuer vestibulum elit. Praesent adipiscing. Phasellus tempus.</p>

				<div class="more-plus-arrow">
					<a href="#">VIEW ALL <img src="<?php echo get_template_directory_uri(); ?>/images/arrow-right.png" class="arrow-right"></a>
				</div>
				
			</div><!-- /col-sm-4 -->

		</div><!-- /row -->




		
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
