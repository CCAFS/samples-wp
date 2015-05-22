<?php

/* Template Name: Building Capacity Template 
 *
 * @package ccafs
 */

get_header(); ?>
	
	<div class="banner general">
			<div class="container header-wrapper">
				<header class="entry-header">
					<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
					<h4 class="subheader"><?php echo CFS()->get('subheader'); ?></h4>
				</header><!-- .entry-header -->
			</div><!-- /header-wrapper -->

	</div><!-- /banner -->
	<div  class="content-area container">

		<div class="row tools-intro">
			<div class="col-sm-7" id="primary">
				<p>Capacity to quantify greenhouse gas emissions from agriculture is currently limited in many regions of the world. One aim of the SAMPLES program is to help build the institutional and human capacity to carry out such assessments and evaluate other agriculture-environment issues.</p>	

				<div class="clearfix tool-category-outer">
					<?php 
						$fields = CFS()->get('build_capacity_loop');
						if (is_array($fields)) {
						foreach ($fields as $field) {
						    $building_capacity_image =  $field['building_capacity_image'];		
						    $building_capacity_link =  $field['building_capacity_link'];		 
						    $building_capacity_description =  $field['building_capacity_description'];
						    echo '<div class="building-capacity-wrap row"><div class="thumb-wrap col-sm-4"><img src="'. $building_capacity_image . '" class="img-responsive" /></div><div class="col-sm-8 entry-content"><h3>' . $building_capacity_link . '</h3>
						    <p>'. $building_capacity_description .'</p></div></div>';
						}
					} ?>
				</div>	 

			</div><!-- /col-sm-7 -->

			<div class="col-sm-4 col-sm-offset-1 sidebar">
				<?php get_sidebar(); ?>
			</div><!-- /col-sm-3 -->
		</div><!-- /row -->

		

	</div><!-- /content-area -->

<?php get_footer(); ?>
