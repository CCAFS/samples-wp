<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package ccafs
 */

get_header(); ?>

	<div class="banner general">
			<div class="container header-wrapper">
			
				<header class="page-header">
					<h1 class="page-title"><?php esc_html_e( 'Oh dear! That page can&rsquo;t be found.', 'ccafs' ); ?></h1>
				</header><!-- .page-header -->
			</div><!-- /header-wrapper -->

	</div><!-- /banner -->

	<div  class="content-area container">
		<div class="row">
			<div class="col-sm-7" id="primary">
				<main id="main" class="site-main" role="main">
					
					<section class="error-404 not-found">
						

						<div class="page-content">
							<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'ccafs' ); ?></p>

							<?php get_search_form(); ?>

							<?php the_widget( 'WP_Widget_Recent_Posts' ); ?>

							<?php if ( ccafs_categorized_blog() ) : // Only show the widget if site has multiple categories. ?>
							<div class="widget widget_categories">
								<h2 class="widget-title"><?php esc_html_e( 'Most Used Categories', 'ccafs' ); ?></h2>
								<ul>
								<?php
									wp_list_categories( array(
										'orderby'    => 'count',
										'order'      => 'DESC',
										'show_count' => 1,
										'title_li'   => '',
										'number'     => 10,
									) );
								?>
								</ul>
							</div><!-- .widget -->
							<?php endif; ?>

							<?php
								/* translators: %1$s: smiley */
								$archive_content = '<p>' . sprintf( __( 'Try looking in the monthly archives. %1$s', 'ccafs' ), convert_smilies( ':)' ) ) . '</p>';
								the_widget( 'WP_Widget_Archives', 'dropdown=1', "after_title=</h2>$archive_content" );
							?>

							<?php the_widget( 'WP_Widget_Tag_Cloud' ); ?>

						</div><!-- .page-content -->
					</section><!-- .error-404 -->

				</main><!-- #main -->
			</div><!-- #primary -->

			<div class="col-sm-4 col-sm-offset-1 sidebar">
				
				<?php get_sidebar(); ?>
				
			</div><!-- /sidebar -->

		</div><!-- /row -->

		
	</div><!-- /content-area -->

	<?php get_footer(); ?>

