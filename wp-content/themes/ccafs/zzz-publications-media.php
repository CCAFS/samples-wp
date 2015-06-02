<?php
/**
 * The template for displaying archive pages.
 * Template Name: Not used, Publications & Media Template 
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package ccafs
 */



get_header(); ?>
	
	<div class="banner general">
			<div class="container header-wrapper">
			
				<header class="page-header">
				
					<h1 class="entry-title">Publications & Media</h1>
					<h4 class="subheader">Yada, yada, yada</h4>
				</header><!-- .page-header -->
			</div><!-- /header-wrapper -->

	</div><!-- /banner -->
	<div  class="content-area container">
		<div class="row">
			<div class="col-sm-7" id="primary">
				<main id="main" class="site-main" role="main">
					
					<?php wp_get_archives(); ?>

				</main><!-- #main -->
			</div><!-- #primary -->

			<div class="col-sm-4 col-sm-offset-1 sidebar">
				
				<?php get_sidebar(); ?>

				<?php wp_list_categories(); ?>
				
			</div><!-- /sidebar -->

		</div><!-- /row -->

		
	</div><!-- /content-area -->

<?php get_footer(); ?>
