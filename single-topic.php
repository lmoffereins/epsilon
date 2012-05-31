<?php

/**
 * Single Topic
 *
 * @theme VGSR Epsilon
 * @package bbPress
 * @subpackage Theme
 */

?>

<?php get_header(); ?>

	<?php epsilon_breadcrumb(); ?>

	<div id="bbp-single-topic" class="row">
		<div id="post-overview" class="<?php epsilon_columnal_class_bbp(); ?>">

		<?php if ( bbp_user_can_view_forum( array( 'forum_id' => bbp_get_topic_forum_id() ) ) ) : ?>

			<?php while ( have_posts() ) : the_post(); ?>

				<div id="bbp-topic-wrapper-<?php bbp_topic_id(); ?>" class="post-wrapper bbp-topic-content clearfix">
				
					<h1 class="post-title"><?php bbp_topic_title(); ?></h1>
					<div class="post-content">
						<?php bbp_get_template_part( 'bbpress/content', 'single-topic' ); ?>

					</div>
				</div><!-- #bbp-topic-wrapper-<?php bbp_topic_id(); ?> -->

			<?php endwhile; ?>

		<?php elseif ( bbp_is_forum_private( bbp_get_topic_forum_id(), false ) ) : ?>

			<?php bbp_get_template_part( 'bbpress/feedback', 'no-access' ); ?>

		<?php endif; ?>

		</div>
		
		<?php get_sidebar( 'forum' ); ?>
		<?php get_sidebar( 'right' ); ?>
			
	</div><!-- #bbp-single-topic -->
	
<?php get_footer(); ?>