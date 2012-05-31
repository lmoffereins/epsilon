<?php

/**
 * User Details
 *
 * @theme VGSR Epsilon
 * @package bbPress
 * @subpackage Theme
 * @uses do_action() - calls epsilon_bbp_user_info_before
 * 					 - calls epsilon_bbp_user_info_after
 */

?>

	<div id="entry-author-info">
		<div id="author-avatar">
			<?php do_action( 'bbp_user_info_avatar_before', bbp_get_user_id() ); ?>
			<?php echo get_avatar( bbp_get_user_id(), 60 ); ?>
			<?php do_action( 'bbp_user_info_avatar_after', bbp_get_user_id() ); ?>
		</div><!-- #author-avatar -->
		
		<?php do_action( 'bbp_user_info_before' ); ?>

		<div id="author-description">
			<h2><?php printf( __( 'About %s', 'bbpress' ), bbp_get_displayed_user_field( 'display_name' ) ); ?></h2>

			<?php $description = bbp_get_displayed_user_field( 'description' ); 
			echo empty( $description ) ? 'Er is geen beschrijving beschikbaar.' : $description; ?>
			
		</div><!-- #author-description	-->
		
		<?php do_action( 'bbp_user_info_after' ); ?>
	</div><!-- #entry-author-info -->
