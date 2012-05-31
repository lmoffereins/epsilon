<?php

/**
 * Topic Tag
 *
 * @theme VGSR Epsilon
 * @package bbPress
 * @subpackage Theme
 */

?>

<?php get_header(); ?>

	<?php epsilon_breadcrumb(); ?>

	<div id="bbp-topic-tag" class="row">
		<div id="post-overview" class="<?php epsilon_columnal_class_bbp(); ?>">

			<div id="topic-tag" class="bbp-topic-tag">
				<h1 class="post-title"><?php printf( __( 'Topic Tag: %s', 'bbpress' ), '<span>' . bbp_get_topic_tag_name() . '</span>' ); ?></h1>

				<div class="post-content">

					<?php bbp_topic_tag_description(); ?>

					<?php do_action( 'bbp_template_before_topic_tag' ); ?>

					<?php if ( bbp_has_topics() ) : ?>

						<?php bbp_get_template_part( 'bbpress/pagination', 'topics'    ); ?>

						<?php bbp_get_template_part( 'bbpress/loop',       'topics'    ); ?>

						<?php bbp_get_template_part( 'bbpress/pagination', 'topics'    ); ?>

					<?php else : ?>

						<?php bbp_get_template_part( 'bbpress/feedback',   'no-topics' ); ?>

					<?php endif; ?>

					<?php do_action( 'bbp_template_after_topic_tag' ); ?>

				</div>
			</div><!-- #topic-tag -->
			
		</div>
		
		<?php get_sidebar( 'forum' ); ?>
		<?php get_sidebar( 'right' ); ?>
			
	</div><!-- #bbp-topic-tag -->

<?php get_footer(); ?>
