<?php

/* Template Name: Funding Partners Template 
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
				
				<div class="clearfix tool-category-outer">

					<?php 
						$fields = CFS()->get('funding_partners_loop');
						if (is_array($fields)) {
						foreach ($fields as $field) {
						    $funding_partners_image =  $field['funding_partnera_image'];		
						    $funding_partners_link =  $field['funding_parters_link'];		 
			
						    echo '<div class="funding-partners-wrap pull-left"><div class="thumb-wrap"><img src="' . $funding_partners_image . '" class="img-responsive funding-partner-logo" /></div><div class="entry-content"><h4>' . $funding_partners_link . '</h4>
						    </div></div>';
						}
					} ?>
				</div>	 

			</div><!-- /col-sm-7 -->

			<div class="col-sm-4 col-sm-offset-1 sidebar">
				<?php get_sidebar(); ?>
				<div class="print-this"><?php if(function_exists('wp_print')) { print_link(); } ?></div>
			</div><!-- /col-sm-3 -->
		</div><!-- /row -->

		

	</div><!-- /content-area -->

<?php get_footer(); ?>
