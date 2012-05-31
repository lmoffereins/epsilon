<?php

/**
 * User Profile Edit
 *
 * @theme VGSR Epsilon
 * @package bbPress
 * @subpackage Theme
 */

?>

<?php get_header(); ?>

	<?php epsilon_breadcrumb(); ?>

	<div id="bbp-user-<?php bbp_user_id(); ?>" class="bbp-single-user-edit row">
		
		<div id="post-overview" class="<?php epsilon_columnal_class_bbp( 12 ); ?>">
			<div class="post-wrapper clearfix">
			
				<h1 class="post-title">Bewerk profiel van <?php echo bbp_get_displayed_user_field( 'display_name' ); ?></h1>
				<div class="post-content">
					<?php bbp_get_template_part( 'bbpress/content', 'single-user-edit'   ); ?>
				</div>
				
			</div>
		</div>
		
		<?php get_sidebar( 'right' ); ?>
			
	</div><!-- #bbp-user-<?php bbp_user_id(); ?> -->
	
<?php get_footer(); ?>