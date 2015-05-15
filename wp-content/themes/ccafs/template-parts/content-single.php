<?php
/**
 * @package ccafs
 */
?>

<article  class="row clearfix" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
	<div class="col-sm-4 thumb-wrap"><?php the_post_thumbnail( 'featured-thumb' ); ?></div>
	<!-- /thumb-wrap -->

	<div class="col-sm-8 entry-content">
		<h3 class="list-post-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
		<?php the_excerpt(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'ccafs' ),
				'after'  => '</div>',
			) );
		?>
	
	</div><!-- .entry-content -->
	
</article><!-- #post-## -->
