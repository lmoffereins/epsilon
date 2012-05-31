<?php

/**
 * Single View
 *
 * @theme VGSR Epsilon
 * @package bbPress
 * @subpackage Theme
 */

?>

<?php get_header(); ?>

	<?php epsilon_breadcrumb(); ?>

	<div id="bbp-view" class="row">
		<div id="post-overview" class="<?php epsilon_columnal_class_bbp(); ?>">

			<div id="bbp-view-<?php bbp_view_id(); ?>" class="post-wrapper bbp-view clearfix">
				<h1 class="post-title"><?php bbp_view_title(); ?></h1>
				<div class="post-content">

					<?php bbp_get_template_part( 'bbpress/content', 'single-view' ); ?>

				</div>
			</div><!-- #bbp-view-<?php bbp_view_id(); ?> -->

		</div>
		
		<?php get_sidebar( 'forum' ); ?>
		<?php get_sidebar( 'right' ); ?>
			
	</div><!-- #bbp-view -->

<?php get_footer(); ?>
