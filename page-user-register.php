<?php

/**
 * Template Name: bbPress - User Register
 *
 * @theme VGSR Epsilon
 * @package bbPress
 * @subpackage Theme
 */

// No logged in users
bbp_logged_in_redirect();

// Begin Template
get_header(); ?>

	<?php epsilon_breadcrumb(); ?>

	<div id="bbp-register" class="row">
		<div id="post-overview" class="<?php epsilon_columnal_class_bbp(); ?>">

		<?php while ( have_posts() ) : the_post(); ?>

			<h1 class="post-title"><?php the_title(); ?></h1>
			<div class="post-content">

				<?php the_content(); ?>

				<?php bbp_get_template_part( 'bbpress/form', 'user-register' ); ?>

			</div>

		<?php endwhile; ?>

		</div>
		
		<?php get_sidebar( 'forum' ); ?>
		<?php get_sidebar( 'right' ); ?>
			
	</div><!-- #bbp-register -->

<?php get_footer(); ?>
