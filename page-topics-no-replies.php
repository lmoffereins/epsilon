<?php

/**
 * Template Name: bbPress - Topics (No Replies)
 *
 * @theme VGSR Epsilon
 * @package bbPress
 * @subpackage Theme
 */

?>

<?php get_header(); ?>

	<?php epsilon_breadcrumb(); ?>

	<div id="bbp-topics-front" class="row">
		<div id="post-overview" class="<?php epsilon_columnal_class_bbp(); ?>">

		<?php while ( have_posts() ) : the_post(); ?>

			<h1 class="post-title"><?php the_title(); ?></h1>
			<div class="post-content">

				<?php the_content(); ?>

				<?php bbp_set_query_name( 'bbp_no_replies' ); ?>

				<?php if ( bbp_has_topics( array( 'meta_key' => '_bbp_reply_count', 'meta_value' => '1', 'meta_compare' => '<', 'orderby' => 'date', 'show_stickies' => false ) ) ) : ?>

					<?php bbp_get_template_part( 'bbpress/pagination', 'topics'    ); ?>

					<?php bbp_get_template_part( 'bbpress/loop',       'topics'    ); ?>

					<?php bbp_get_template_part( 'bbpress/pagination', 'topics'    ); ?>

				<?php else : ?>

					<?php bbp_get_template_part( 'bbpress/feedback',   'no-topics' ); ?>

				<?php endif; ?>

				<?php bbp_reset_query_name(); ?>

			</div>

		<?php endwhile; ?>

		</div>
		
		<?php get_sidebar( 'forum' ); ?>
		<?php get_sidebar( 'right' ); ?>
			
	</div><!-- #bbp-topics-front -->

<?php get_footer(); ?>
