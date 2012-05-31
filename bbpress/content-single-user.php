<?php

/**
 * Single User Part
 *
 * @package bbPress
 * @subpackage Theme
 * @uses do_action() - calls bbp_template_notices
 * 					 - calls epsilon_bbp_user_activity_before
 * 					 - calls epsilon_bbp_user_activity_after
 */

?>

	<?php do_action( 'bbp_template_notices' ); ?>

	<div id="bbp-user-info" class="col_3">

		<?php
		// Profile details
		bbp_get_template_part( 'bbpress/user', 'details'        );
		?>

	</div><!-- #bbp-user-info -->
	
	<div id="bbp-user-activity" class="<?php epsilon_columnal_class_bbp( 7, true ); ?> clearfix">
	
		<?php do_action( 'bbp_user_activity_before' ); ?>
	
		<?php
		// Subscriptions
		bbp_get_template_part( 'bbpress/user', 'subscriptions'  );

		// Favorite topics
		bbp_get_template_part( 'bbpress/user', 'favorites'      );

		// Topics created
		bbp_get_template_part( 'bbpress/user', 'topics-created' );
		?>

		<?php do_action( 'bbp_user_activity_after' ); ?>
	
	</div><!-- #bbp-user-activity -->