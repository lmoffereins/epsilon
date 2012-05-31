<?php

/**
 * search.php
 *
 * @theme VGSR Epsilon
 */

?>

<?php get_header(); ?>

	<?php epsilon_breadcrumb(); ?>

	<div class="row">
	
		<?php get_sidebar(); ?>
		
		<div id="post-overview" class="<?php epsilon_columnal_class(); ?>">
			<h1 class="post-title">Zoekresultaten voor: "<?php the_search_query(); ?>"</h1>
			
			<?php if ( have_posts() ) : ?>
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
				<div class="pagination-older"><?php previous_posts_link('&lsaquo; Vorige berichten'); ?></div>
				<div class="pagination-newer"><?php next_posts_link('Volgende berichten &rsaquo;'); ?></div>
			</div>
		
			<?php else : ?>
		
			<div class="post-content">
				<p><img style="margin: 0 0 20px 0;" src="<?php echo get_template_directory_uri(); ?>/images/404.png"></p>
				<p>Helaas, maar voor de genoemde zoektermen is hier niets te vinden. Probeer het hieronder nog een keer of ga terug naar <a href="<?php echo home_url(); ?>">de homepage</a>.</p>
				<p><?php get_search_form(); ?></p>
			</div>
			
			<?php endif; ?>
			
		</div>
		
		<?php get_sidebar( 'right' ); ?>
		
	</div><!-- .row -->

<?php get_footer(); ?>
