<?php

/**
 * 404.php
 *
 * @theme VGSR Epsilon
 */

?>

<?php get_header(); ?>

	<?php epsilon_breadcrumb(); ?>

	<div class="row">
	
		<div class="niets pre_2 col_8 suf_2">
		
			<div class="post-content">
				<p><img style="margin: 20px 0;" src="<?php echo get_template_directory_uri(); ?>/images/404.png"></p>
				<p>Tja, dit gaat dus niet. De link is kapot of de pagina waar je naar zoekt bestaat niet. Hoe dan ook, je kan misschien beter terug gaan naar <a href="<?php echo home_url(); ?>">de homepage</a> of naar de pagina waar we <a href="<?php echo epsilon_get_blog_page( 'url' ); ?>">onze berichten</a> bewaren. Gebruik onderstaand veld om verder op zoek te gaan.</p>
				<?php get_search_form(); ?>
			</div>
			
		</div>
		
	</div><!-- .row -->

<?php get_footer(); ?>
