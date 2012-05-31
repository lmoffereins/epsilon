<?php

/**
 * Comments List
 *
 * @theme VGSR Epsilon
 */

?>

	<div id="post-<?php the_ID(); ?>-comments" class="entries row">
		
	<?php 
	if ( ! empty ( $_SERVER['SCRIPT_FILENAME'] ) && 'comments.php' == basename( $_SERVER['SCRIPT_FILENAME'] ) )
		die( 'Please do not load this page directly. Thanks!' );
	
	if ( post_password_required() ) : ?>
		<p class="nopassword pre_3 col_9 last">Dit bericht is beschermd met een wachtwoord. Voer het wachtwoord in om de reacties te zien.</p>
		
	</div><!-- #post-<?php the_ID(); ?>-comments -->
		<?php return; ?>
		
	<?php endif; ?>

		<h3 class="entries-title col_12">
			<?php 
				comments_number( 'Er zijn geen reacties', 'Er is 1 reactie', 'Er zijn % reacties' ); 
				echo ' op <em>' . get_the_title() . '</em>'; 
			?>
		</h3>

	<?php if ( have_comments() ) : ?>
	
		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
			<div class="navigation col_12">
				<div class="nav-previous"><?php previous_comments_link( __( '<span class="meta-nav">&larr;</span> Oudere reacties', 'epsilon' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( __( 'Nieuwere reacties <span class="meta-nav">&rarr;</span>', 'epsilon' ) ); ?></div>
			</div> <!-- .navigation -->
		<?php endif; // check for comment navigation ?>

		<ol class="entrieslist">
			<?php wp_list_comments( array( 'callback' => 'epsilon_entries' ) ); // list the entries ?>
		</ol>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
			<div class="navigation col_12">
				<div class="nav-previous"><?php previous_comments_link( __( '<span class="meta-nav">&larr;</span> Oudere reacties', 'epsilon' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( __( 'Nieuwere reacties <span class="meta-nav">&rarr;</span>', 'epsilon' ) ); ?></div>
			</div><!-- .navigation -->
		<?php endif; // check for comment navigation ?>

	<?php endif; // end have_comments() ?>

	<?php if ( comments_open() ) : ?>
	
		<?php comment_form(); ?>
	
	<?php else : ?>
	
		<p class="nocomments pre_3 col_9 last">Reacties zijn gesloten.</p>

	<?php endif; // end comments_open()?>

	</div><!-- #entries -->
