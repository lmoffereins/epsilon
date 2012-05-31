<?php

/**
 * Category Archive
 *
 * @theme VGSR Epsilon
 */

?>

<?php get_header(); ?>

	<?php epsilon_breadcrumb(); ?>

	<div class="row">
	
		<?php get_sidebar(); ?>
		
		<?php if ( have_posts() ) : ?>

		<div id="post-overview" class="<?php epsilon_columnal_class(); ?>">

			<h1 class="post-title"><?php single_cat_title(); // category title ?></h1>
			<?php if ( $description = category_description() && !empty( $description ) ) : ?>
				<div class="post-wrapper clearfix">
					<div class="post-content">
						<?php echo $description; // category description ?>
					</div>
				</div>
			<?php endif; ?>
			
			<ol class="post-list">
			
			<?php while ( have_posts() ) : the_post(); ?>
				<li id="post-<?php the_ID(); ?>" <?php post_class('post-wrapper clearfix'); ?>>
					
					<h2 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<?php epsilon_postmeta(); ?>
					<div class="post-content">
						<?php the_content(); ?>
					</div>
					
				</li>
			<?php endwhile; ?>
			
			</ol>
			
			<div class="post-pagination clearfix">
				<div class="pagination-older"><?php next_posts_link('&lsaquo; Voorgaande berichten'); ?></div>
				<div class="pagination-newer"><?php previous_posts_link('Nieuwere berichten &rsaquo;'); ?></div>
			</div>
		
		</div>
		
		<?php endif; ?>
		
		<?php get_sidebar( 'right' ); ?>
		
	</div><!-- .row -->

<?php get_footer(); ?>
