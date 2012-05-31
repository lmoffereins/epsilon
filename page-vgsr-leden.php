<?php

/**
 * Template Name: VGSR - Leden
 *
 * @theme VGSR Epsilon
 * @package VGSR Functions
 * @subpackage Leden Section
 */

// Only for leden
vgsr_user_not_lid_redirect();

// Set up $users array of VGSR_User objects
$group_id = vgsr_user_get_main_group_id();
$users = vgsr_user_get_group_members( $group_id );

// Begin Template
get_header(); ?>

	<?php epsilon_breadcrumb( $post->ID ); ?>

	<div id="page-leden" <?php post_class('row'); ?>>
		
		<div id="leden-sidebar-wrapper" class="sidebar sidebar-wrapper col_3">
			
			<div class="widget">
				<h4>Ledenlijst <?php echo vgsr_user_get_group_name_by_id( $group_id ); ?></h4>

				<?php vgsr_user_list_profile_fotos( $users );

				foreach ( $users as $lid ){
					$leden_ids[] = $lid->data->ID;
				} ?>

			</div>

			<?php do_action( 'vgsr_page_leden_sidebar', $users ); ?>
			
		</div><!-- #leden-sidebar-wrapper -->
		
		<?php while ( have_posts() ) : the_post(); ?>

		<div id="post-overview" class="<?php epsilon_columnal_class(); ?>">

			<?php echo epsilon_post_thumbnail( $post->ID, 'mobile-only' ); ?>

			<h1 class="post-title"><?php the_title(); ?></h1>
			<div class="post-wrapper clearfix">
			
				<div class="post-content">
					<?php $args = array(
						'showposts' => 25,
						'author' => implode( ',', $leden_ids )
					);

					echo '<h3>Leden activiteit</h3>';

					if ( $query_posts = epsilon_bbp_user_activity( $args ) ) :

						echo '<ul class="post-list">';

						global $post; $tmp_post = $post;

						foreach ( $query_posts as $post ) : setup_postdata( $post );
							foreach ( $users as $lid ){
								if ( $lid->data->ID == $post->post_author ){
									$user_link = $lid->profile_link( true, true ); // true == amice/amica
									continue;
								}
							}

							echo '<li>'. $user_link;

							switch ( $post->post_type ) :
								case 'topic':
									echo ' schreef <a href="'. bbp_get_topic_permalink( $post->ID ) .'">'. bbp_get_topic_title( $post->ID ) .'</a>';
									break;
								case 'comment':
									echo ' heeft gereageerd op <a href="'. get_comment_link( $post->ID ) .'">'. get_the_title( $post->post_parent ) .'</a>';
									break;
								case 'reply':
									echo ' heeft gereageerd op <a href="'. bbp_get_reply_url( $post->ID ) .'">'. bbp_get_reply_topic_title( $post->ID ) .'</a>';
									break;
								case 'post':
								default:
									echo ' schreef <a href="'. get_permalink( $post->ID ) .'">'. get_the_title( $post->ID ) .'</a>';
									break;
							endswitch;

							echo ', '. epsilon_nice_date( get_the_date( 'U' ) ) .'.</li>';

						endforeach; 

						echo '</ul>';

					else :
						echo '<p>Er is geen activiteit van leden gevonden.</p>';
					endif; setup_postdata( $tmp_post ); ?>

					<?php the_content(); ?>
				</div>
				
			</div>
			
			<?php epsilon_link_pages(); ?>
			
		</div>
		
		<?php endwhile; ?>
		
		<?php get_sidebar( 'right' ); ?>
		
	</div>
	
<?php get_footer(); ?>