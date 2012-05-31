<?php

/**
 * Edit handler for replies
 *
 * @theme VGSR Epsilon
 * @package bbPress
 * @subpackage Theme
 */

?>

<?php get_header(); ?>

	<?php epsilon_breadcrumb(); ?>

	<div id="bbp-topic-front" class="row">
		<div id="post-overview" class="<?php epsilon_columnal_class_bbp(); ?>">

		<?php while ( have_posts() ) : the_post(); ?>

			<div id="bbp-edit-page" class="bbp-edit-page">
				<h1 class="post-title"><?php the_title(); ?></h1>
				<div class="post-content">

					<?php bbp_get_template_part( 'bbpress/form', 'reply' ); ?>

				</div>
			</div><!-- #bbp-edit-page -->

		<?php endwhile; ?>

		</div>
		
		<?php get_sidebar( 'forum' ); ?>
		<?php get_sidebar( 'right' ); ?>
			
	</div><!-- #forum-front -->

<?php get_footer(); ?>
