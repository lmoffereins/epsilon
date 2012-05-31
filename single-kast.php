<?php

/**
 * Single Kast
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
		
			<?php echo epsilon_post_thumbnail( $post->ID, 'mobile-only' ); ?>

			<h1 class="post-title"><?php the_title(); ?></h1>
			<div class="post-wrapper clearfix">
			
				<div class="post-content">
					<?php the_content(); ?>
				</div>
				
			</div>
			
			<?php epsilon_link_pages(); ?>

		</div>
		
		<?php endwhile; ?>
		
		<?php get_sidebar( 'right' ); ?>
		
		<?php comments_template(); ?>
				
	</div>
	
<?php get_footer(); ?>