<?php

/**
 * Front Page Sidebar
 *
 * @theme VGSR Epsilon
 * @todo remove dummy content
 */

?>

<?php
	if ( ! is_active_sidebar( 'front-page-sidebar-1' ) 
		&& ! is_active_sidebar( 'front-page-sidebar-2' ) 
	)
		// return;
?>

	<div id="front-page-sidebars" role="complementary">
		<div class="sidebar col_12 clearfix">
		<?php if ( is_active_sidebar( 'front-page-sidebar-1' ) ) : ?>
			<?php dynamic_sidebar( 'front-page-sidebar-1' ) ?> 
		<?php else : // dummy content ?>
		
			<div class="widget col_6">
				<h4>Laatste berichten</h4>
				<ul class="latest-posts">
					<?php $args = array(
						'numberposts' => 4
					);
					$posts = get_posts( $args );
					$i = 0; // to iterate over the items
					foreach ( $posts as $post ) :
						$thumbnail = epsilon_post_thumbnail( $post->ID, 'post-thumbnail' );
						echo '<li class="'. ( $i % 2 == 0 ? 'odd' : 'even' ) .'">';
						if ( !empty( $thumbnail ) )
							echo '<a href="'. get_permalink( $post->ID ) .'">'. $thumbnail .'</a>';
						echo '<a href="'. get_permalink( $post->ID ) .'" class="post-title"><strong>'. get_the_title( $post->ID ) .'</strong></a>';
						echo limit_content( 25, false, '<p><a>', 'Lees verder &rarr;' );
						echo "</li>\n";
						$i++;
					endforeach; ?>
				</ul>
			</div>
		
			<div class="widget col_3">
				<h4><a href="#" title="Naar agenda">Agenda</a></h4>
				<ul class="dubbel agenda">
					<li class="odd">
						<a class="mobile-hide" href="#"><img src="<?php echo get_template_directory_uri(); ?>/featured/ketel1-440.png" /></a>
						<strong>Activiteiten</strong>
						<table>
							<tr>
								<th>do 13-10</th>
								<td>Familieavond</td>
							</tr>
							<tr>
								<th>vr 14-10</th>
								<td>Bruiloft am. Bosscha sr. &amp; ama Van den Dool</td>
							</tr>
							<tr>
								<th>do 20-10</th>
								<td>HH</td>
							</tr>
							<tr>
								<th>do 27-10</th>
								<td>Lezing I</td>
							</tr>
							<tr>
								<th>do 03-11</th>
								<td>Dispuut</td>
							</tr>
						</table>
					</li>
					<li class="even">
						<strong>Verjaardagen</strong>
						<table>
							<tr>
								<th>ma 02-04</th>
								<td>ama Bredemeijer</td>
							</tr>
							<tr>
								<th>wo 05-04</th>
								<td>am. Van den Beukel</td>
							</tr>
							<tr>
								<th>vr 16-04</th>
								<td>ama Van Gelder</td>
							</tr>
							<tr>
								<th>do 28-04</th>
								<td>am. Joosse</td>
							</tr>
							<tr>
								<th>zo 06-05</th>
								<td>am. Jansen</td>
							</tr>
						</table>
					</li>
				</ul>
			</div>
			
			<div class="widget col_3 last">
				<h4>Reacties</h4>
				<ul class="dubbel">
					<li class="odd">
						<a class="mobile-hide" href="#"><img src="<?php echo get_template_directory_uri(); ?>/featured/vgsr_das-440.png" /></a>
						<?php // do WP_Widget_Recent_Comments
							$instance = array(
								'title' => 'Bericht Reacties',
								'number' => '5'
							);
							
							$args = array(
								'before_title' => '<h4>',
								'after_title' => '</h4>'
							);
							
							the_widget( WP_Widget_Recent_Comments, $instance, $args );
						?>
					</li>
					<li class="even">
						<?php // do BBP_Replies_Widget
							$instance = array(
								'title' => 'Forum Reacties',
								'count' => '5'
							);
							
							$args = array(
								'before_title' => '<h4>',
								'after_title' => '</h4>'
							);
							
							the_widget( BBP_Replies_Widget, $instance, $args );
						?>
					</li>
				</ul>
			</div>
			
		<?php endif; ?>
		</div>
		
		<div class="sidebar col_12 clearfix">
		<?php if ( is_active_sidebar( 'front-page-sidebar-2' ) ) : ?>
			<?php dynamic_sidebar( 'front-page-sidebar-2' ) ?> 
		<?php else : // dummy content ?>
			<div class="widget col_3">
				<h4>Wij zijn aangesloten bij</h4>
				<a href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/ads/vgs-nederland.png" /></a>
			</div>
			
			<div class="widget col_9 last">
				<h4>Sponsoren</h4>
				<ul class="trippel">
					<li>
						<a href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/ads/visserenvisser.png" /></a>
					</li>
					<li>
						<a href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/ads/secuplus.png" /></a>
					</li>
					<li class="last">
						<a href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/ads/ketel1.png" /></a>
					</li>
				</ul>
			</div>
			
		<?php endif; ?>
		</div>
		
	</div>
