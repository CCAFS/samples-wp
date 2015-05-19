<?php
/**
 * The template for displaying archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package ccafs
 */



get_header(); ?>
	
	<div class="banner general">
			<div class="container header-wrapper">
			
				<header class="page-header">
				
					<?php
						the_archive_title( '<h1 class="entry-title">', '</h1>' );
						the_archive_description( '<h4 class="subheader">', '</div>' );
					?>
				</header><!-- .page-header -->
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
								/* Include the Post-Format-specific template for the content.
								 * If you want to override this in a child theme, then include a file
								 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
								 */
								get_template_part( 'template-parts/content-single', get_post_format() );
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
					<div class="sb-header"><a href="/publications-media/">Publications and Media</a></div>
					<div class="sb-main full">
						<ul class="sidebar-box-list">
							<li><a href="/publications-media/peer-reviewed-publications/">Peer-Reviewed Publications</a></li>
							<li><a href="/publications-media/reports-news/">Reports & News</a></li>
							<li><a href="/publications-media/presentation-graphics/">Presentation Graphics</a></li>
						</ul>
					</div><!-- /sb-main -->
				</div><!-- /sidebar-box -->
				
			</div><!-- /sidebar -->

		</div><!-- /row -->

		
	</div><!-- /content-area -->

<?php get_footer(); ?>
