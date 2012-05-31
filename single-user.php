<?php

/**
 * User Profile
 *
 * @theme VGSR Epsilon
 * @package bbPress
 * @subpackage Theme
 */

?>

<?php get_header(); ?>

	<?php epsilon_breadcrumb(); ?>

	<div id="bbp-user-<?php bbp_user_id(); ?>" class="row">
		<div id="post-overview" class="<?php epsilon_columnal_class_bbp(); ?>">

			<div class="post-wrapper bbp-single-user clearfix">
				<h1 class="post-title">Profiel van <?php echo bbp_get_displayed_user_field( 'display_name' ); ?>
					<?php if ( bbp_is_user_home() || current_user_can( 'edit_users' ) ) : ?>
						<span class="edit_user_link"><a href="<?php bbp_user_profile_edit_url(); ?>" title="<?php printf( __( 'Edit Profile of User %s', 'bbpress' ), esc_attr( bbp_get_displayed_user_field( 'display_name' ) ) ); ?>"> <?php _e( '(Edit)', 'bbpress' ); ?></a></span>
					<?php endif; ?>
				</h1>
				
				<div class="post-content">
				
					<?php bbp_get_template_part( 'bbpress/content', 'single-user' ); ?>
					
				</div>
			</div>
			
		</div>
		
		<?php get_sidebar( 'forum' ); ?>
		<?php get_sidebar( 'right' ); ?>
			
	</div><!-- #bbp-user-<?php bbp_user_id(); ?> -->
	
<?php get_footer(); ?>