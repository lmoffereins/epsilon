<?php

/**
 * Replies Loop - Single Reply
 *
 * @theme VGSR Epsilon
 * @package bbPress
 * @subpackage Theme
 */

?>

	<li id="post-<?php bbp_reply_id(); ?>" <?php bbp_reply_class(); ?>>
		<article id="comment-<?php comment_ID(); ?>" class="reply clearfix">
			<footer class="entry-author vcard entry-meta col_2 clearfix">
				<div class="entry-wrapper">
				
					<?php do_action( 'bbp_theme_before_reply_author_details' ); ?>

					<?php
						printf( '<a href="%1$s" rel="nofollow">%2$s</a><p><cite class="fn"><a href="%1$s" title="Bekijk profiel van %3$s" rel="nofollow">%3$s</a></cite></p>', 
							bbp_get_reply_author_url(), 
							get_avatar( bbp_get_reply_author_id(), 50 ), 
							bbp_get_reply_author_display_name() 
						);
					?>
					
					<div class="entry-metadata">
						<p><?php
						printf( '<a href="%1$s"><time pubdate datetime="%2$s">%3$s</time></a>',
							bbp_get_reply_url(),
							get_comment_time( 'c' ),
							sprintf( __( '%1$s om %2$s uur', 'epsilon' ), get_the_date(), esc_attr( get_the_time() ) )
						);
						?></p>
						
					<?php if ( is_super_admin() ) : ?>

						<?php do_action( 'bbp_theme_before_reply_author_admin_details' ); ?>

						<p class="bbp-reply-ip"><?php bbp_author_ip( bbp_get_reply_id() ); ?></p>

						<?php do_action( 'bbp_theme_after_reply_author_admin_details' ); ?>

					<?php endif; ?>

					<?php do_action( 'bbp_theme_after_reply_author_details' ); ?>

					</div>
					
				</div><!-- .entry-author .vcard -->
			</footer>

			<div class="reply-content entry-body <?php epsilon_columnal_class_bbp( 8, true ); ?>">
				<div class="entry-wrapper">
				
					<?php do_action( 'bbp_theme_after_reply_content' ); ?>

					<?php bbp_reply_content(); ?>

					<?php do_action( 'bbp_theme_before_reply_content' ); ?>
					
					<div class="entry-admin-links">
						<?php do_action( 'bbp_theme_before_reply_admin_links' ); ?>

						<?php bbp_reply_admin_links(); ?>

						<?php do_action( 'bbp_theme_after_reply_admin_links' ); ?>
					</div><!-- .entry-admin-links -->

				</div>
			</div>
		</article>
	</li><!-- #post-<?php bbp_reply_id(); ?> -->
