<?php

/**
 * Merge topic page
 *
 * @theme VGSR Epsilon
 * @package bbPress
 * @subpackage Theme
 */

?>

<?php get_header(); ?>

	<?php epsilon_breadcrumb(); ?>

	<div id="bbp-edit-page" class="row">
		<div id="post-overview" class="<?php epsilon_columnal_class_bbp(); ?>">

		<?php while ( have_posts() ) : the_post(); ?>

			<h1 class="post-title">Bewerk <?php the_title(); ?></h1>
			<div class="post-content">

				<?php bbp_get_template_part( 'bbpress/form', 'topic-merge' ); ?>

			</div>
			
		<?php endwhile; ?>

		</div>
		
		<?php get_sidebar( 'forum' ); ?>
		<?php get_sidebar( 'right' ); ?>
			
	</div><!-- #bbp-edit-page -->

<?php get_footer(); ?>
