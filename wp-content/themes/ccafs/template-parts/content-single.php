<?php
/**
 * @package ccafs
 */
?>

<article  class="row clearfix" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
	<div class="col-sm-4 thumb-wrap"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_post_thumbnail( 'featured-thumb' ); ?></a></div>
	<!-- /thumb-wrap -->

	<div class="col-sm-8 entry-content">
		<h3 class="list-post-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
		<?php 
		$pub = CFS()->get('publication');
		if (!empty($pub)) {
		?>
		    <div class="post-meta">
		    	<div class="post-meta-entry">Author: <?php echo CFS()->get('authors'); ?></div>
		    	<div class="post-meta-entry">Publication: <?php echo CFS()->get('publication'); ?></div>
		    	<div class="post-meta-entry">Year: <?php echo CFS()->get('year'); ?></div>
		    	

		    </div><!-- post-meta -->
		<?php  } else { 
		        the_excerpt();
		    }
		?>
		
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'ccafs' ),
				'after'  => '</div>',
			) );
		?>
	
	</div><!-- .entry-content -->
	
</article><!-- #post-## -->
