<?php

/**
 * Template Name: bbPress - Create Topic
 *
 * @theme VGSR Epsilon
 * @package bbPress
 * @subpackage Theme
 */

?>

<?php get_header(); ?>

	<?php epsilon_breadcrumb(); ?>

	<div id="bbp-new-topic" class="row">
		<div id="post-overview" class="<?php epsilon_columnal_class_bbp(); ?>">

		<?php do_action( 'bbp_template_notices' ); ?>

		<?php while ( have_posts() ) : the_post(); ?>

			<h1 class="post-title"><?php the_title(); ?></h1>
			<div class="post-content">

				<?php the_content(); ?>

				<?php bbp_get_template_part( 'bbpress/form', 'topic' ); ?>

			</div>

		<?php endwhile; ?>

		</div>
		
		<?php get_sidebar( 'forum' ); ?>
		<?php get_sidebar( 'right' ); ?>
			
	</div><!-- #bbp-new-topic -->

<?php get_footer(); ?>
