<?php

/**
 * Template Name: bbPress - Topic Tags
 *
 * @theme VGSR Epsilon
 * @package bbPress
 * @subpackage Theme
 */

?>

<?php get_header(); ?>

	<?php epsilon_breadcrumb(); ?>

	<div id="bbp-topic-tags" class="row">
		<div id="post-overview" class="<?php epsilon_columnal_class_bbp(); ?>">

		<?php while ( have_posts() ) : the_post(); ?>

			<h1 class="post-title"><?php the_title(); ?></h1>
			<div class="post-content">

				<?php get_the_content() ? the_content() : _e( '<p>This is a collection of tags that are currently popular on our forums.</p>', 'bbpress' ); ?>

				<div id="bbp-topic-hot-tags">

					<?php wp_tag_cloud( array( 'smallest' => 9, 'largest' => 38, 'number' => 80, 'taxonomy' => bbp_get_topic_tag_tax_id() ) ); ?>

				</div>

			</div>

		<?php endwhile; ?>

		</div>
		
		<?php get_sidebar( 'forum' ); ?>
		<?php get_sidebar( 'right' ); ?>
			
	</div><!-- #bbp-topic-tags -->

<?php get_footer(); ?>
