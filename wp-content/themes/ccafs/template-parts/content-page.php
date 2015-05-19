<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package ccafs
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	

	<div class="entry-content">
		<?php the_post_thumbnail( 'featured-blog-image' ); ?>

		<?php 
		$pub = CFS()->get('publication');
		if (!empty($pub)) {
		?>
		    <div class="post-meta">
		    	<div class="post-meta-entry">Author: <?php echo CFS()->get('authors'); ?></div>
		    	<div class="post-meta-entry">Publication: <?php echo CFS()->get('publication'); ?></div>
		    	<div class="post-meta-entry">Year: <?php echo CFS()->get('year'); ?></div>
		    	<div class="post-meta-entry"><?php echo CFS()->get('publication_link'); ?></div>

		    </div><!-- post-meta -->
		<?php  }  ?>
			
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'ccafs' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php edit_post_link( __( 'Edit', 'ccafs' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
