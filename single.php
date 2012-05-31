<?php

/**
 * Single Post
 *
 * @theme VGSR Epsilon
 */

?>

<?php get_header(); ?>

	<?php epsilon_breadcrumb( $post->ID ); ?>

	<div id="post-<?php the_ID(); ?>" <?php post_class('row'); ?>>
		
		<?php get_sidebar(); ?>
		
		<?php while ( have_posts() ) : the_post(); ?>

		<div id="post-overview" class="<?php epsilon_columnal_class(); ?>">
		
			<h1 class="post-title"><?php the_title(); ?></h1>
			<div class="post-wrapper clearfix">
			
				<?php epsilon_postmeta(); ?>
				
				<div class="post-content">
					<?php the_content(); ?>
				</div>
				
			</div>
			
			<?php epsilon_link_pages(); ?>

			<div class="post-pagination clearfix">
				<div class="pagination-older"><?php previous_post_link( '%link', '&lsaquo; %title' ); ?></div>
				<div class="pagination-newer"><?php next_post_link( '%link', '%title &rsaquo;' ); ?></div>
			</div>
			
		</div>
		
		<?php endwhile; ?>
		
		<?php get_sidebar( 'right' ); ?>
		
		<?php comments_template(); ?>
				
	</div>
	
<?php get_footer(); ?>