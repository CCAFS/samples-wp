<?php
/**
 * The template for displaying Measurement Method search results pages.
 *
 * @package ccafs
 */


get_header(); ?>
	
	<div class="banner general">
			<div class="container header-wrapper">
				<header class="entry-header">
					<h1 class="page-title"><?php printf( __( 'Measurement Method Search Results for: %s', 'ccafs' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
				</header><!-- .entry-header -->

			</div><!-- /header-wrapper -->

	</div><!-- /banner -->
	<div  class="content-area container">
		<div class="row">
			<div class="col-sm-7" id="primary">
				<main id="main" class="site-main" role="main">
					
					<?php if ( have_posts() ) : ?>

						

						<?php /* Start the Loop */ ?>
						<?php while ( have_posts() ) : the_post(); ?>

							<?php
							/**
							 * Run the loop for the search to output the results.
							 * If you want to overload this in a child theme then include a file
							 * called content-search.php and that will be used instead.
							 */
							get_template_part( 'template-parts/content', 'search' );
							?>

						<?php endwhile; ?>

						<?php the_posts_navigation(); ?>

					<?php else : ?>

						<?php get_template_part( 'template-parts/content', 'none' ); ?>

					<?php endif; ?>

				</main><!-- #main -->
			</div><!-- #primary -->

			<div class="col-sm-4 col-sm-offset-1 sidebar">
				
				<?php get_sidebar(); ?>
				<div class="sidebar-box">
					<div class="sb-header">Search Measurement Methods</div>
					<div class="sb-main clearfix">
						<form id="searchform" action="<?php echo site_url('/'); ?>" method="get">
							<span class="glyphicon glyphicon-search sb-search-submit pull-right">
								<input class="sb-search-submit-input" alt="Search" type="submit" />
							</span>
							<input name="s" type="text" class="sb-text-input pull-right" placeholder="" />

							<input name="post_type" type="hidden" value="mm_chapter" /> <!-- // hidden 'mm_chapter' value -->
							

						</form>
						
					</div>
				</div>
				
			</div><!-- /sidebar -->

		</div><!-- /row -->

		
	</div><!-- /content-area -->

<?php get_footer(); ?>
