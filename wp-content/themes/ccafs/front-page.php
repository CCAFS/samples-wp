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
							<img src="<?php echo get_template_directory_uri(); ?>/images/EmissionsData.png" class="panel-icon" alt="Emissions Data" />
						</div>
						<div class="col-xs-9">
							<h4>Emissions Data</h4>
							<p>Emissions factors for specific agricultural practices</p>
							<div class="view-link">
								<a href="/emissions-data/">VIEW <img src="<?php echo get_template_directory_uri(); ?>/images/arrow-right.png" class="arrow-right"></a>
							</div><!-- /view-link -->
						</div>
					</div><!-- /panel-wrap -->
					
				</div><!-- /panel-top-->
				<div class="panel panel-bottom">
					<div class="row panel-wrap">
						<div class="icon emissions-data col-xs-3">
							<img src="<?php echo get_template_directory_uri(); ?>/images/MeasurementMethods.png" class="panel-icon" alt="Measurement Methods" />
						</div>
						<div class="col-xs-9">
							<h4>Measurement methods</h4>
							<p>Guidelines for conducting field measurements</p>
							<div class="view-link">
								<a href="/measurement-methods-overview/">VIEW <img src="<?php echo get_template_directory_uri(); ?>/images/arrow-right.png" class="arrow-right"></a>
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
					<p class="gray">SAMPLES addresses the dearth of reliable information about greenhouse gas emissions from agriculture in tropical countries. SAMPLES scientists work with developing countries to improve data on agricultural greenhouse gas emissions and mitigation potentials.</p>
					<div class="more-plus-arrow">
						<a href="/about">MORE ABOUT US <img src="<?php echo get_template_directory_uri(); ?>/images/arrow-right.png" class="arrow-right"></a>
					</div><!-- /more-plus-arrow -->

					<div class="map-block clearfix">
						<h2 class="white">Our network of research sites stretch across the globe.</h2>
						<h5 class="white">Aliquet elit ac nisl. Phasellus consectetuer vestibulum elit. Praesent adipiscing. Phasellus tempus.</h5>
						<div class="more-plus-arrow map pull-right">
							<a href="/about-samples/research-sites/">VIEW MAP <img src="<?php echo get_template_directory_uri(); ?>/images/arrow-right.png" class="arrow-right"></a>
						</div>

					</div><!-- /map-block -->
					

				</main><!-- #main -->
			</div><!-- col-sm-7 -->

			<div class="col-sm-4 col-sm-offset-1 news-column">
				
				<h6>News</h6>
				
			
				<?php $args = array(
				    'posts_per_page' => 3,
				    'order' => 'DESC'
				);

				$rp = new WP_Query( $args );

				if($rp->have_posts()) :
				    while($rp->have_posts()) : $rp->the_post(); ?>

				       <h4 class="homepage-post-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h4> 
				        
				       <?php the_excerpt();

				    endwhile;
				    wp_reset_postdata(); // always always remember to reset postdata when using a custom query, very important
				endif; ?>

				

				<div class="more-plus-arrow">
					<a href="/publications-media/">VIEW ALL <img src="<?php echo get_template_directory_uri(); ?>/images/arrow-right.png" class="arrow-right"></a>
				</div>
				
			</div><!-- /col-sm-4 -->

		</div><!-- /row -->




		
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
