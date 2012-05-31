<?php

/**
 * Single Reply
 *
 * @theme VGSR Epsilon
 * @package bbPress
 * @subpackage Theme
 */

?>

<?php get_header(); ?>

	<?php epsilon_breadcrumb(); ?>

	<div id="bbp-single-reply" class="row">
		<div id="post-overview" class="<?php epsilon_columnal_class_bbp(); ?>">

		<?php while ( have_posts() ) : the_post(); ?>

			<div id="bbp-reply-wrapper-<?php bbp_reply_id(); ?>" class="post-wrapper bbp-reply-wrapper clearfix">
				<h1 class="post-title"><?php bbp_reply_title(); ?></h1>

				<div class="post-content">

					<table class="bbp-replies" id="topic-<?php bbp_topic_id(); ?>-replies">
						<thead>
							<tr>
								<th class="bbp-reply-author"><?php  _e( 'Author',  'bbpress' ); ?></th>
								<th class="bbp-reply-content"><?php _e( 'Replies', 'bbpress' ); ?></th>
							</tr>
						</thead>

						<tfoot>
							<tr>
								<td colspan="2"><?php bbp_topic_admin_links(); ?></td>
							</tr>
						</tfoot>

						<tbody>
							<tr class="bbp-reply-header">
								<td class="bbp-reply-author">

									<?php bbp_reply_author_display_name(); ?>

								</td>
								<td class="bbp-reply-content">
									<a href="<?php bbp_reply_url(); ?>" title="<?php bbp_reply_title(); ?>">#</a>

									<?php printf( __( 'Posted on %1$s at %2$s', 'bbpress' ), get_the_date(), esc_attr( get_the_time() ) ); ?>

									<span><?php bbp_reply_admin_links(); ?></span>
								</td>
							</tr>

							<tr id="reply-<?php bbp_reply_id(); ?>" <?php bbp_reply_class(); ?>>

								<td class="bbp-reply-author"><?php bbp_reply_author_link( array( 'type' => 'avatar' ) ); ?></td>

								<td class="bbp-reply-content">

									<?php bbp_reply_content(); ?>

								</td>

							</tr><!-- #topic-<?php bbp_topic_id(); ?>-replies -->
						</tbody>
					</table>

				</div>
			</div><!-- #bbp-reply-wrapper-<?php bbp_reply_id(); ?> -->

		<?php endwhile; ?>

		</div>
		
		<?php get_sidebar( 'forum' ); ?>
		<?php get_sidebar( 'right' ); ?>
			
	</div><!-- #bbp-single-reply -->
	
<?php get_footer(); ?>