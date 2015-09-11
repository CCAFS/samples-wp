<?php

/* The template for displaying all Measurement Methods Chapters.
 *
 * @package ccafs
 */

get_header(); ?>
	
	<div class="banner general">
			<div class="container header-wrapper">
				<header class="entry-header">
					<div class="uppercase">Measurement Methods</div>
					<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
					<h4 class="subheader"><?php echo CFS()->get('subheader'); ?></h4>
				</header><!-- .entry-header -->
			</div><!-- /header-wrapper -->

	</div><!-- /banner -->
	<div  class="content-area container">
		<div class="row">
			<div class="col-sm-7" id="primary">
				<main id="main" class="site-main" role="main">
					
					
					

						<?php while ( have_posts() ) : the_post(); ?>

							<?php get_template_part( 'template-parts/content', 'page' ); ?>

						<?php endwhile; // end of the loop. ?> 

				</main><!-- #main -->
			</div><!-- #primary -->

			<div class="col-sm-4 col-sm-offset-1 sidebar">
				
				<?php get_sidebar(); ?>
				<div class="print-this"><?php if(function_exists('wp_print')) { print_link(); } ?></div>

				<div class="sidebar-box">
					<div class="sb-header">Search Measurement Methods</div>
					<div class="sb-main clearfix">
						<form id="searchform" action="<?php echo site_url('/'); ?>" method="get">
							<span class="glyphicon glyphicon-search sb-search-submit pull-right">
								<input class="sb-search-submit-input" alt="Search" type="submit" />
							</span>
							<input name="s" type="text" class="sb-text-input pull-right" placeholder="Enter term" />

							<input name="post_type" type="hidden" value="mm_chapter" /> <!-- // hidden 'mm_chapter' value -->
							

						</form>
						
					</div>
				</div>
				
			</div><!-- /sidebar -->

		</div><!-- /row -->

		
	</div><!-- /content-area -->

<?php get_footer(); ?>
