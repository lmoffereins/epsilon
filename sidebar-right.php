<?php

/**
 * Main Sidebar
 *
 * @theme VGSR Epsilon
 */

?>
<?php if( epsilon_user_access() ) : ?>

	<div id="right-sidebar-wrapper" class="sidebar sidebar-wrapper col_2 last">
		<?php do_action( 'epsilon_sidebar_right' ); ?>

		<?php if ( is_active_sidebar( 'sidebar-leden'  ) ) : ?>
			<?php dynamic_sidebar( 'sidebar-leden' ) ?> 
		<?php else : // dummy content ?>
		
			<div class="widget">
				<h4>Admin</h4>
				<ul>
					<li><a href="<?php echo home_url(); ?>/wp-admin/">Dashboard</a></li>
					<li><?php edit_post_link(); ?></li>
				</ul>
			</div>
			
			<div class="widget">
				<h4><a href="#" title="Bestanden met tag 'Bestuur Suurmond II'">Bestanden</a></h4>
				<ul class="files">
					<li><a href="#.doc">Beleid & Visie bestuur Suurmond II</a></li>
					<li><a href="#.pdf">Eerste Semesterbundel 2010/2011</a></li>
					<li><a href="#.pdf">Tweede Semesterbundel 2010/2011</a></li>
				</ul>
			</div>
			
		<?php endif; ?>
	
	</div><!-- #right-sidebar-wrapper -->
		
<?php endif; ?>