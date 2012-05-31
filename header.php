<?php

/**
 * header.php
 *
 * @theme VGSR Epsilon
 */

?><!doctype html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<title><?php wp_title('&raquo;', true, 'right'); ?> <?php bloginfo('name'); ?></title>
	<meta name="description" content="VGSR, d&#233; christelijke studentenvereniging van Rotterdam">
	<meta name="author" content="MMC der VGSR">
	<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">

	<link rel="shortcut icon" href="<?php bloginfo('stylesheet_directory'); ?>/images/favicon.ico" />

	<!-- Columnal & Main styles -->
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/columnal/columnal.css" type="text/css" media="screen" charset="utf-8" />
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" />

	<!-- Modernizr & jQuery -->
	<script src="<?php echo get_template_directory_uri(); ?>/js/libs/modernizr-2.0.6.min.js"></script>
	<?php wp_enqueue_script('jquery'); ?>
	
	<!-- WP generated header -->
	<?php wp_head(); ?>
	<!-- End WP generated header -->
	
</head>
<body <?php body_class(); ?>>

<header>
	<div id="header">
		<div id="header-images">
			<div id="header-img1" class="header-image" <?php epsilon_header_img_construct(); ?>></div>
		</div>
		
		<div id="header-wrapper">

			<div id="header-content" class="container">
			
				<div id="logo">
					<a href="<?php echo home_url(); ?>">VGS Rotterdam</a>
					<?php $h1 = ( is_front_page() ) ? 'h1' : 'span'; 
					echo '<'.$h1.'><a href="'. home_url() .'">VGSR</a></'.$h1.'>'; ?>
				</div>
				
				<?php epsilon_header_links(); ?>
				
				<nav>
					<?php wp_nav_menu( array( 'theme-location' => 'header-menu', 'container' => '', 'depth' => 2, 'walker' => new Epsilon_Walker_Main_Menu ) ); ?>
					
					<div class="login">
						<a class="login-link" href="#"><?php echo ( is_user_logged_in() ) 
							? '<i class="icon-unlocked"></i> <span class="ir">Account</span>' 
							: '<i class="icon-locked"></i> <span class="ir">Login</span>'; 
						?></a>
						<div class="login-form">
							<?php epsilon_login_form(); ?>
						</div>
					</div>
				</nav>
				
			</div><!-- #header-content -->
			
		</div><!-- #header-wrapper -->

		<?php epsilon_header_img_caption(); ?>
		
	</div>
</header>

<div id="main" class="container clearfix" role="main">