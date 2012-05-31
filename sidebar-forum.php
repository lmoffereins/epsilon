<?php

/**
 * Forum Sidebar
 *
 * @theme VGSR Epsilon
 * @requires bbPress
 */

?>

	<div id="forum-sidebar-wrapper" class="sidebar sidebar-wrapper <?php epsilon_sidebar_forum_class(); ?>">
		
		<div class="widget">
			<h4>Stats</h4>

			<?php if ( bbp_is_forum_archive() ){

			} elseif ( bbp_is_single_forum() ){
				bbp_single_forum_description( array( 'before' => '<p class="bbp-forum-description">', 'after' => '</p>' ) ); 
				//if ( !bbp_is_forum_category( $post->ID ) )
					//echo 'RSS: '. bbp_get_forum_topics_feed_link();
			} elseif ( bbp_is_single_topic() ){
				bbp_single_topic_description( array( 'before' => '<p class="bbp-topic-description">', 'after' => '</p>' ) );
				bbp_topic_tag_list(); 
				bbp_user_favorites_link();
			} elseif ( bbp_is_single_user() ){
				global $bbp;
				// printf( '<p>%1$s heeft %2$s onderwerpen aangemaakt en %3$s reacties geplaatst.</p>',
				// 	bbp_get_displayed_user_field( 'display_name' ),
				// 	bbp_get_user_topic_count_raw( $bbp->displayed_user->ID ),
				// 	bbp_get_user_reply_count_raw( $bbp->displayed_user->ID )
				// );
			}

			?>
		</div>
		
		<?php if ( is_active_sidebar( 'forum-sidebar'  ) ) : ?>
			<?php dynamic_sidebar( 'forum-sidebar' ) ?> 
		<?php else : // dummy content ?>
		
			<?php do_action( 'epsilon_bbp_widgets' ); ?>
		
			<?php // do BBP_Replies_Widget
			$instance = array(
				'title' => 'Laatste Reacties',
				'count' => '5'
			);
			
			$args = array(
				'before_title' => '<h4>',
				'after_title' => '</h4>'
			);
			
			the_widget( BBP_Replies_Widget, $instance, $args );
			?>
			
			<?php // do BBP_Topics_Widget
			$instance = array(
				'title' => 'Actieve Topics',
				'count' => '5'
			);
			
			$args = array(
				'before_title' => '<h4>',
				'after_title' => '</h4>'
			);
			
			the_widget( BBP_Topics_Widget, $instance, $args );
			?>
			
		<?php endif; ?>
	
	</div><!-- #forum-sidebar-wrapper -->
