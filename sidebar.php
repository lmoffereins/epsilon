<?php

/**
 * Sidebar
 *
 * @theme VGSR Epsilon
 */

?>
<div id="main-sidebar-wrapper" class="sidebar sidebar-wrapper col_3 mobile-hide" role="complementary">
	<?php if ( is_active_sidebar( 'main-sidebar'  ) ) : ?>
		<?php dynamic_sidebar( 'main-sidebar' ) ?> 
	<?php else : // dummy content ?>
	
		<div class="widget">
			<?php // Nav menu with children pages, else siblings
				$children = get_children( array(
					'post_parent' => $post->ID,
					'post_status' => 'publish'
				) ); ?>

			<h4><?php echo !$children ? get_the_title( $post->post_parent ) : $post->post_title; ?></h4>
			<ul>
				<?php // if post has no children show siblings else show them
					$children = get_children( array( 'post_parent' => !$children ? $post->post_parent : $post->ID ) );
					
					echo '<ul>';
					foreach ( $children as $child ){
						$current_page = ( $post->ID == $child->ID ) ? 'current-page-item' : '';
						echo '<li class="'. $child->post_type .'-item '. $child->post_type.'-item-'. $child->ID .' '.
							$current_page .'"><a href="'. get_permalink( $child->ID ) .'">'. get_the_title( $child->ID ) .'</a></li>';
					}
					echo '</ul>';
				?>
			</ul>
		</div>
		
		<?php if ( is_singular() && has_post_thumbnail() ) : ?>
			<div class="widget">
				<?php 
				// because the_post_thumbnail sets width and height inline we use wp_get-attachment_image_src instead
				$image = wp_get_attachment_image_src( get_post_thumbnail_id(), array( 440, 138 ) ); ?>
				<img src="<?php echo $image[0]; ?>" />
			</div>
		<?php endif; // add extra nav-options and more? ?>
		
		<div class="widget">
			<h4>Contact</h4>
			<p>Ab-actiaat der VGSR<br />
			Ruilstraat 24ab<br />
			3023 XS Rotterdam<br />
			ab-actis@vgsr.nl</p>
		</div>

		<div class="widget">
			<h4>Recente berichten</h4>
			<ul>
				<?php 
				$latest_posts = get_posts();
				foreach ( $latest_posts as $post ) : setup_postdata( $post ); ?>
					<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
				<?php endforeach; ?>
			</ul>
		</div>
		
	<?php endif; ?>
	
</div> <!-- #main-sidebar-wrapper -->