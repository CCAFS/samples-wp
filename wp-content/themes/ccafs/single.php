<?php
/**
 * The template for displaying all single posts.
 *
 * @package ccafs
 */


get_header(); ?>
	
	<div class="banner general">
			<div class="container header-wrapper">
				
			</div><!-- /header-wrapper -->

	</div><!-- /banner -->
	<div  class="content-area container">
		<div class="row">
			<div class="col-sm-7" id="primary">
				<main id="main" class="site-main" role="main">
					
					
					

						<?php while ( have_posts() ) : the_post(); ?>

							<header class="entry-header">
								<?php the_date(); ?>
								<?php the_title( '<h1 class="pub-media-title">', '</h1>' ); ?>
								
								<div class="post-meta">
									<span class="post-label">Posted By: </span><span class="post-meta-element"><?php the_author(); ?></span>
									<span class="post-label">Continent: </span><span class="post-meta-element"><?php the_category(' '); ?></span>
									<span class="post-label">Topic(s): </span><span class="post-meta-element"><?php the_category(' '); ?></span>
									<span class="post-label">Category: </span><span class="post-meta-element"><?php the_category(' '); ?></span>

								</div>
								
							</header><!-- .entry-header -->

							<?php get_template_part( 'template-parts/content', 'page' ); ?>

							<?php the_post_navigation(); ?>

						<?php endwhile; // end of the loop. ?> 

				</main><!-- #main -->
			</div><!-- #primary -->

			<div class="col-sm-4 col-sm-offset-1 sidebar">
				
				<?php get_sidebar(); ?>
				
			</div><!-- /sidebar -->

		</div><!-- /row -->

		
	</div><!-- /content-area -->

<?php get_footer(); ?>

