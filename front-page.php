<?php

/**
 * home.php
 *
 * @theme VGSR Epsilon
 */

?>

<?php get_header(); ?>

	<div id="page-<?php the_ID(); ?>" <?php post_class('row'); ?>>
		
		<?php if ( have_posts() ) : ?>
		<?php while ( have_posts() ) : the_post(); ?>

			<div class="post-content pre_2 col_8 suf_2">
				<?php the_content(); ?>
			</div>
			
		<?php endwhile; ?>
		<?php endif; ?>
	
		<?php get_sidebar( 'front_page' ); ?>
		
	</div>
	
<?php get_footer(); ?>