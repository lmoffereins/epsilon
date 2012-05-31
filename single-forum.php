<?php

/**
 * Single Forum
 *
 * @theme VGSR Epsilon
 * @package bbPress
 * @subpackage Theme
 */

?>

<?php get_header(); ?>

	<?php epsilon_breadcrumb(); ?>

	<div id="bbp-single-forum" class="row">
		<div id="post-overview" class="<?php epsilon_columnal_class_bbp(); ?>">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php if ( bbp_user_can_view_forum() ) : ?>

				<div id="bbp-forum-wrapper-<?php bbp_forum_id(); ?>" class="post-wrapper bbp-forum-content clearfix">
				
					<h1 class="post-title"><?php bbp_forum_title(); ?></h1>
					<div class="post-content">
						<?php bbp_get_template_part( 'bbpress/content', 'single-forum' ); ?>
					</div>
			
				</div><!-- #bbp-forum-wrapper-<?php bbp_forum_id(); ?> -->
			
			<?php else : // Forum exists, user no access ?>

				<?php bbp_get_template_part( 'bbpress/feedback', 'no-access' ); ?>

			<?php endif; ?>

		<?php endwhile; ?>

		</div>
		
		<?php get_sidebar( 'forum' ); ?>
		<?php get_sidebar( 'right' ); ?>
			
	</div><!-- #bbp-single-forum -->
	
<?php get_footer(); ?>