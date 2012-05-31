<?php

/**
 * Topic Tag Edit
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
				<h1 class="entry-title"><?php printf( __( 'Topic Tag: %s', 'bbpress' ), '<span>' . bbp_get_topic_tag_name() . '</span>' ); ?></h1>

				<div class="entry-content">

					<?php bbp_topic_tag_description(); ?>

					<?php do_action( 'bbp_template_before_topic_tag_edit' ); ?>

					<?php bbp_get_template_part( 'bbpress/form', 'topic-tag' ); ?>

					<?php do_action( 'bbp_template_after_topic_tag_edit' ); ?>

				</div>
			</div><!-- #topic-tag -->
			
		</div>
		
		<?php get_sidebar( 'forum' ); ?>
		<?php get_sidebar( 'right' ); ?>
			
	</div><!-- #bbp-topic-tag -->

<?php get_footer(); ?>
