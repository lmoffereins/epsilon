<?php

/**
 * Single User Edit Part
 *
 * @package bbPress
 * @subpackage Theme
 *
 * @uses do_action() - Calls 'bbp_template_notices'
 * 					 - Calls 'epsilon_bbp_user_edit_before'
 * 					 - Calls 'epsilon_bbp_user_edit_after'
 */

?>

	<?php do_action( 'bbp_template_notices' ); ?>

	<div id="bbp-author-edit" class="clearfix">
	
		<?php do_action( 'bbp_user_edit_before' ); ?>
	
		<?php
		// User edit form
		bbp_get_template_part( 'bbpress/form', 'user-edit' );
		?>

		<?php do_action( 'bbp_user_edit_after' ); ?>
	
	</div><!-- #bbp-author-edit -->
