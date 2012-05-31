<?php

/**
 * index.php
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
			<ol class="post-list">
			
			<?php while ( have_posts() ) : the_post(); ?>
				<li id="post-<?php the_ID(); ?>" <?php post_class('post-wrapper clearfix'); ?>>
					
					<h2 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<?php echo epsilon_post_thumbnail( $post->ID, 'mobile-only' ); ?>

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
		
		<?php else : ?>
		
		<div class="niets <?php epsilon_columnal_class(); ?>">
		
			<h2 class="post-title">Niets gevonden</h2>
			<div class="post-content">
				<p>Helaas, maar je zocht naar iets wat hier niet is.</p>
				<p><a href="<?php echo home_url(); ?>">Terug naar de homepage</a></p>
			</div>
			
		</div>
		
		<?php endif; ?>
		
		<?php get_sidebar( 'right' ); ?>
		
	</div><!-- .row -->

<?php get_footer(); ?>
