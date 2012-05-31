<?php

/**
 * bbPress - Topic Archive
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

			<h1 class="post-title"><?php bbp_topic_archive_title(); ?></h1>
			<div class="post-content">

				<?php bbp_get_template_part( 'bbpress/content', 'archive-topic' ); ?>

			</div>

		</div>
		
		<?php get_sidebar( 'forum' ); ?>
		<?php get_sidebar( 'right' ); ?>
			
	</div><!-- #bbp-topic-front -->

<?php get_footer(); ?>
