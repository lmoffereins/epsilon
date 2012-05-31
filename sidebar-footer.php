<?php

/**
 * Footer Sidebar
 *
 * @theme VGSR Epsilon
 */

?>

<?php
	if ( ! is_active_sidebar( 'footer-sidebar-left' ) 
		&& ! is_active_sidebar( 'footer-sidebar-center' ) 
		&& ! is_active_sidebar( 'footer-sidebar-right' ) 
	)
		// return;
?>

	<ul id="footer-widgets" class="col_12 clearfix">
				
		<li class="col_3 left">
			<?php if ( is_active_sidebar( 'footer-sidebar-left' ) ) : ?>
				<?php dynamic_sidebar( 'footer-sidebar-left' ); ?> 
			<?php else : // dummy content ?>

				<div class="widget">
					<h5>Colofon</h5>
					<p>De VGSR is een christelijke studentenvereniging in Rotterdam en is aangesloten bij <a href="http://www.vgs-nederland.nl">VGS-Nederland</a>.
					</p>
				</div>

			<?php endif; ?>
		</li>
		
		<li class="col_7 center-left">
			<?php if ( is_active_sidebar( 'footer-sidebar-center' ) ) : ?>
				<?php dynamic_sidebar( 'footer-sidebar-center' ); ?> 
			<?php else : // dummy content ?>

				<div class="widget">
					<h5>Navigatie</h5>
					<?php wp_nav_menu( array( 'theme-location' => 'header-menu', 'container' => '' ) ); ?>
				</div>

			<?php endif; ?>
		</li>
		
		<li class="col_2 right last">
			<?php if ( is_active_sidebar( 'footer-sidebar-right' ) ) : ?>
				<?php dynamic_sidebar( 'footer-sidebar-right' ); ?> 
			<?php else : // dummy content ?>

				<div class="widget">
					<h5>Contact</h5>
					<p>Ab-actiaat der VGSR<br />
					Ruilstraat 24<br />
					3023 XS Rotterdam<br />
					ab-actis@vgsr.nl
					</p>
				</div>
				
			<?php endif; ?>
		</li>
		
	</ul>
