<?php	

/**
 * footer.php
 *
 * @theme VGSR Epsilon
 */

?>

</div><!-- #main -->

<footer class="clearfix">
	<div id="footer" class="container clearfix">
		<div id="footer-content" class="row">
		
			<?php get_sidebar( 'footer' ); ?>

		</div>
	</div>
	<div id="footer-end">
		<div class="container">
			<div class="row">
				<p class="col_12">
					&copy; 2011 <a href="<?php echo get_template_directory_uri(); ?>/humans.txt">MMC der VGSR</a> 
					&#8226; gebouwd op <a href="http://wordpress.org">WordPress</a> 
					<?php if ( current_user_can( 'administrator' ) ) : ?>
						&#8226; <?php echo get_num_queries(); ?> queries in <?php timer_stop(1); ?>  seconden
					<?php endif; ?>
				</p>
			</div>
		</div>
	</div>
</footer>

	<!-- WP generated footer -->
	<?php wp_footer(); ?>
	<!-- End WP generated footer -->
	
	<!--[if lt IE 7 ]>
	<script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
	<script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
	<![endif]-->

</body>
</html>
