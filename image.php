<?php

/**
 * Single Post
 *
 * @theme VGSR Epsilon
 */

?>

<?php get_header(); ?>

	<?php epsilon_breadcrumb( $post->ID ); ?>

	<div id="attachment-<?php the_ID(); ?>" <?php post_class('row, attachement-image'); ?>>
		
		<?php get_sidebar(); ?>
		
		<?php while ( have_posts() ) : the_post(); ?>

		<div id="post-overview" class="<?php epsilon_columnal_class(); ?>">
		
			<div class="post-wrapper clearfix">
			
				<div class="post-content">
					<?php if ( wp_attachment_is_image( $post->ID ) ) :
						$att_image = wp_get_attachment_image_src( $post->ID, "full");
						?>
						<p class="attachment">
							<a href="<?php echo wp_get_attachment_url($post->ID); ?>" title="<?php the_title(); ?>">
							<img src="<?php echo $att_image[0];?>" class="attachment-medium" alt="<?php echo $post->post_excerpt; ?>" />
							</a>
						</p>
					<?php else : ?>
						<p class="not-found">Image not found.</p>
					<?php endif; ?>

					<h5 class="post-title center"><?php the_title(); ?></h5>

					<?php epsilon_postmeta(); ?>
				</div>
				
			</div>
			
			<?php epsilon_link_pages(); ?>

		</div>
		
		<?php endwhile; ?>
		
		<?php get_sidebar( 'right' ); ?>
		
		<?php comments_template(); ?>
				
	</div>
	
<?php get_footer(); ?>