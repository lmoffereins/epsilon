<?php

/**
 * Replies Loop
 *
 * @theme VGSR Epsilon
 * @package bbPress
 * @subpackage Theme
 */

?>

	<div class="bbp-replies entries" id="topic-<?php bbp_topic_id(); ?>-replies">

		<?php do_action( 'bbp_template_before_replies_loop' ); ?>
		
		<ol class="entrieslist">

		<?php while ( bbp_replies() ) : bbp_the_reply(); ?>

			<?php bbp_get_template_part( 'bbpress/loop', 'single-reply' ); ?>

		<?php endwhile; ?>
		
		</ol>

		<?php do_action( 'bbp_template_after_replies_loop' ); ?>

	</div><!-- #topic-<?php bbp_topic_id(); ?>-replies -->