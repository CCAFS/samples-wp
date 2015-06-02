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
								<div class="post-date"><?php the_date(); ?></div>
								<?php the_title( '<h1 class="pub-media-title">', '</h1>' ); ?>

								
								<div class="post-meta">
									<span class="post-label">Posted By: </span><span class="post-meta-element"><?php the_author(); ?></span>
									<span class="post-label">Continent: </span><span class="post-meta-element"><?php the_terms( $post->ID, 'continent', '', ', ', ' ' ); ?></span>
									<span class="post-label">Topic(s): </span><span class="post-meta-element"><?php the_terms( $post->ID, 'topic', '', ', ', ' ' ); ?></span>
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
				<div class="sidebar-box">
					<div class="sb-header"><a href="/publications-media/">Publications and Media</a></div>
					<div class="sb-main full">
						<ul class="sidebar-box-list">
							<li><a href="/publications-media/peer-reviewed-publications/">Peer-Reviewed Publications</a></li>
							<li><a href="/publications-media/news-blogs/">News & Blogs</a></li>
							<li><a href="/publications-media/presentation-graphics/">Presentation Graphics</a></li>
							<li><a href="/publications-media/reports/">Reports</a></li>
						</ul>
					</div><!-- /sb-main -->
				</div><!-- /sidebar-box -->
				
			</div><!-- /sidebar -->

		</div><!-- /row -->

		
	</div><!-- /content-area -->

<?php get_footer(); ?>

