<?php

/* Template Name: Tools Full Width Template 
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
				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'template-parts/content', 'page' ); ?>

				<?php endwhile; // end of the loop. ?> 		 

			</div><!-- /col-sm-7 -->

			<div class="col-sm-4 col-sm-offset-1 sidebar">
				<?php get_sidebar(); ?>
			</div><!-- /col-sm-3 -->
		</div><!-- /row -->

		<div class="row">
			<div class="col-sm-12" >
				
				<!-- Field Groups display output --> 
				<h2 class="tool-category">Tools for prioritizing action</h2>
				<div class="clearfix tool-category-outer">
					<?php 
						$fields = CFS()->get('category_a1_tools');
						if (is_array($fields)) {
						foreach ($fields as $field) {
						    $tool_link =  $field['tool_link'];				    
						    $tool_description =  $field['tool_description'];
						    echo '<div class="category-tool-wrap"><h3>' . $tool_link . '</h3>
						    <p>'. $tool_description .'</div>';
						}
					} ?>
				</div>

				<h2 class="tool-category">Accounting tools and methodologies</h2>
				<div class="clearfix tool-category-outer">
					<?php 
					 	$fieldsB = CFS()->get('category_b_tool_loop');
					 	if (is_array($fieldsB)) {
						foreach ($fieldsB as $fieldB) {
					    	$tool_linkB =  $fieldB['tool_link'];				    
					    	$tool_descriptionB =  $fieldB['tool_description'];
					    	echo '<div class="category-tool-wrap"><h3>' . $tool_linkB . '</h3>
					    	<p>'. $tool_descriptionB .'</div>';
						} 
					} ?>
				</div>
				<h2 class="tool-category">Tools for reducing the cost of data collection</h2>
				<div class="clearfix tool-category-outer">
					<?php 
					$fieldsC = CFS()->get('category_c1_loop');
					if (is_array($fieldsC)) {
						foreach ($fieldsC as $fieldC) {
						    $tool_linkC =  $fieldC['tool_link'];				    
						    $tool_descriptionC =  $fieldC['tool_description'];
						    echo '<div class="category-tool-wrap"><h3>' . $tool_linkC . '</h3>
						    <p>'. $tool_descriptionC .'</div>';
						}
					} ?>
				</div>
				

			</div><!-- col 12 -->

		</div><!-- /row -->

	</div><!-- /content-area -->

<?php get_footer(); ?>
