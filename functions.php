<?php

/**
 * Theme Functions
 *
 * @theme VGSR Epsilon
 * @todo - FEATURES
 *       - fix this all: [c/r = check/rewrite, p = plugin]
 *       - css front end perfection
 *       - c/r bbpress theme pages, bbp_notices
 *       - c/r breadcrumbs (bbpress)
 *       - user section (bbpress/user), avatars, member info
 *       - [fixed] user edit section (bbpress/user-edit), upload avatar, upload peronal image (p)
 *       - p? header image front page, per page
 *       - p member management, mail members, group members
 *       - p agenda functionality, cpt, comments
 *       - p? econozel, cpt, search, comments
 *       - p? enquetes/polls, cpt, comments
 *       - p file management
 *       - fuse replies and comments in query for user activity
 */

/**
 * Prepend the_content with user agent details (browser and desktop)
 */
function epsilon_content( $content ){
	// return $_SERVER['HTTP_USER_AGENT'] . "\n\n" . $content;
}
// add_filter( 'the_content', 'epsilon_content' );

/**
 * Add theme support on theme setup and set other defaults
 *
 * Hooked to after_setup_theme action
 *
 * @uses add_theme_support(), to add various theme features
 * @uses set_post_thumbnail_size(), to reset default post thumbnail image size
 * @uses add_image_size(), to add extra thumbnail image size
 * @uses register_nav_menus(), to register a navigation menu
 */
function epsilon_the_theme_setup(){

	// we use post thumbnails
	add_theme_support( 'post-thumbnails' );

	// here we set the default post thumbnail
	set_post_thumbnail_size( 440, 138, true );

	// for the header images we set another image size with unlimited height
	add_image_size( 'header-post-thumbnail', 1600, 9999 );

	// to put feed links in the head section
	add_theme_support( 'automatic-feed-links' );

	// this theme supports bbpress forum plugin
	add_theme_support( 'bbpress' );

	// add_editor_style( 'css/editor-style.css' );

	// register menu to be used by wp_nav_menu in header and in the footer sidebar
	register_nav_menus( array( 'header-menu' => 'Header Menu' ) );
}
add_action( 'after_setup_theme', 'epsilon_the_theme_setup' );

/**
 * Add various javascript files
 *
 * Hooked to wp_enqueue_scripts action
 *
 * @uses wp_register_script(), to add js files to the workspace
 * @uses wp_enqueue_script(), to add js files to the page
 */
function epsilon_add_scripts(){
	wp_register_script( 'theme_plugins', get_template_directory_uri() .'/js/plugins.js' );
	wp_enqueue_script ( 'theme_plugins' );

	// Icon Styles
	wp_register_style( 'icomoon', get_template_directory_uri() .'/css/icomoon.css' );
	wp_enqueue_style ( 'icomoon' );

	// js/script.js is loaded through reqruireJS which in turn loads script-main or script-mobile
	// wp_register_script( 'theme_script', get_template_directory_uri() .'/js/script.js' );
	// wp_enqueue_script ( 'theme_script' );
	
	// Enable Tipsy plugin
	// wp_register_script( 'tipsy', get_template_directory_uri() .'/js/jquery.tipsy.js' );
	// wp_enqueue_script ( 'tipsy' );
	// wp_register_style( 'tipsy', get_template_directory_uri() .'/css/tipsy.css' );
	// wp_enqueue_style ( 'tipsy' );

	// wp_register_script( 'photoswipe', get_template_directory_uri() .'/js/mylibs/code.photoswipe.jquery-3.0.4.min.js' );
	// wp_enqueue_script ( 'photoswipe' );
}
add_action( 'wp_enqueue_scripts', 'epsilon_add_scripts' );

/**
 * Add RequireJS to <head> section
 *
 * Doesn't work with wp_register_script, because the data-main attribute needs to be set
 */
function epsilon_script_requirejs(){
	?>	<!-- RequireJS and load js/script.js with it -->
	<script src="<?php echo get_template_directory_uri(); ?>/js/libs/require.js" 
		data-main="<?php echo get_template_directory_uri(); ?>/js/script.js"></script>
	<?php
}
add_action( 'wp_head', 'epsilon_script_requirejs' );

/**
 * Add Tipsy.js and .css to <head> section via RequireJS
 *
 * Doesn't work with wp_register_script, because the css location needs to be set with php
 */
function epsilon_script_tipsy(){
		?><script type="text/javascript">
	// Use Tipsy Tooltips
	require(["jquery.tipsy"], function(){
		jQuery(document).ready( function($) {
		   $('a[rel=tipsy], img[rel=tipsy]').tipsy({ 
		   		fade: false, 
		   		gravity: 'n', 
		   		fallback: 'Nothing here', 
		   		offset: 5, 
		   		opacity: 1 
		   	});
		
			var css = $('<link />');
			css.attr({
				rel: 'stylesheet',
				type: 'text/css',
				href: '<?php echo get_template_directory_uri(); ?>/css/tipsy.css'
			});
			$('head').append(css);

		});

	});</script><?php
}
add_action( 'wp_head', 'epsilon_script_tipsy' );

/**
 * Remove default image sizes from being created
 *
 * Hooked to intermediate_image_sizes_advanced filter
 *
 * @param array $sizes, default and added image sizes
 * @return array $sizes, modified image sizes
 * @author Ade Walker http://www.studiograsshopper.ch
 */
function epsilon_filter_image_sizes( $sizes ){
	unset( $sizes['thumbnail']);
	unset( $sizes['medium']);
	unset( $sizes['large']);

	return $sizes;
}
add_filter( 'intermediate_image_sizes_advanced', 'epsilon_filter_image_sizes' );

/**
 * Checks for bbpress plugin being activated
 *
 * @uses include_once(), to include plugin.php for using is_plugin_active()
 * @uses is_plugin_active(), to check for plugin being active
 * @return boolean, true for plugin being active, false if not
 */
function is_bbp_active(){
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	return is_plugin_active( 'bbpress/bbpress.php' );
}

/**
 * Create breadcrumbs for the current page
 *
 * @param int $id, the post/page id
 * @param string $type, the sort of crumbs we are iterating for
 * @uses is_bbp_active(),
 * @uses is_bbpress(),
 * @uses epsilon_breadcrumb_bbp(),
 * @uses is_home(),
 * @uses epsilon_get_blog_page(),
 * @uses get_post(),
 * @uses is_404(),
 * @uses is_search(),
 * @uses is_category(),
 * @uses get_category(),
 * @uses get_query_var(),
 * @uses get_permalink(),
 * @uses get_category_link(),
 * @uses is_single(),
 * @uses epsilon_breadcrumb(), recurring usage of this function for different type
 * @uses home_url(),
 */
function epsilon_breadcrumb( $id = 0, $type = 'current' ){

	// When on bbPress page we use a different breadcrumb function
	if ( is_bbp_active() && is_bbpress() ) // Dismiss last query if first arg is false
		return epsilon_breadcrumb_bbp();

	// When on blog page get it's correct id
	if ( is_home() )
		$id = epsilon_get_blog_page();

	// Assign post object to $item and fetch title
	$item = get_post( $id );
	$title = $item->post_title;

	// when on 404-error page, search page or category page, overwrite $title
	if ( $type != 'parent' ){
		if ( is_404() )
			$title = 'Pagina niet gevonden';
		if ( is_search() )
			$title = 'Zoekresultaten voor: &#8220;'. get_search_query() .'&#8221;';
		if ( is_category() ){
			$category = get_category( get_query_var( 'cat' ), false );
			$title = $category->cat_name .' ('. $category->count .')';
		}
	}

	// use type of breadcrumb to give it the right html tags
	if ( $type == 'current' )
		$return .= '&rsaquo; <span class="current">'. $title .'</span></p></div>';
	elseif ( $type == 'parent'  )
		$return .= '&rsaquo; <a class="post-'. $item->ID .'" href="'. get_permalink( $item->ID ) .'">'. $title .'</a> ';

	// iterate over the post/page parents
	while ( !is_404() && $item->post_parent != 0 ){
		$item = get_post( $item->post_parent );
		$return = '&rsaquo; <a class="post-'. $item->ID .' href="'. get_permalink( $item->ID ) .'">'. $item->post_title .'</a> '. $return;
	}

	// iterate over the category parents
	while ( is_category() && $category->category_parent != 0 ){
		$category = get_category( $category->cat_ID );
		$return = '&rsaquo; <a href="'. get_category_link( $category->cat_ID ) .'">'. $category->cat_name .'</a> '. $return;
	}

	// add group name after all the items
	if ( isset( $category ) && $category->category_parent == 0 )
		$return = '&rsaquo; <a href="">Onderwerpen</a> '. $return;

	// specially for posts: prepend the blog page and it's parents for single posts
	if ( ( $item->post_type == 'post' || is_category() ) && $item->post_parent != epsilon_get_blog_page() ){ // when on single post and not while looping for blog page...
		epsilon_breadcrumb( epsilon_get_blog_page(), 'parent' ); // ...prepend the breadcrumbs of blog page...
		echo $return; // ...to this single post
		return; // end breadcrumbs here
	}

	// output the crumbz with a nice home link in front of them all
	echo '<div class="breadcrumb row"><p class="col_12"><a href="'. home_url() .'/">Home</a> '. $return;
}

/**
 * Create breadcrumbs for bbpress pages
 *
 * Uses bbp_breadcrumb() for all pages except user profiles
 *
 * @param string $wrapped, name of the div in which the crumbz are wrapped
 * @uses bbp_is_single_user(), to determine the profile page
 * @uses bbp_is_single_user_edit(), to determine the profile edit page
 * @uses bbp_get_displayed_user_field(), to get user details
 * @uses bbp_get_user_profile_link(), to get user link
 * @uses apply_filters() - calls epsilon_breadcrumb_bbp_profile_root
 * @uses home_url(), to fetch link to home
 * @uses bbp_breadcrumb(), to generate bbp breadcrumbs
 * @echo string of html breadcrumbs
 */
function epsilon_breadcrumb_bbp( $wrapped = '' ){
	$class = ( $wrapped == 'content' && is_bbpress() ) ? epsilon_get_columnal_class_bbp() : 'col_12';

	// make exception for user profile page
	if ( bbp_is_single_user() || bbp_is_single_user_edit() ) :

		if ( bbp_is_single_user()      ){ $title = bbp_get_displayed_user_field( 'display_name' );  }
		if ( bbp_is_single_user_edit() ){ $title = 'Bewerk profiel'; }

		$return = '&rsaquo; <span class="current">'. $title .'</span></p></div>';

		if ( bbp_is_single_user_edit() )  $return = '&rsaquo; '. bbp_get_user_profile_link() .' '. $return;

		$root_text = 'Profiel';

		// set filter for possible plugin adjustment
		$root_text = apply_filters( 'epsilon_breadcrumb_bbp_profile_root', $root_text );

		echo '<div class="bbp-breadcrumb row"><p class="'. $class .'"><a href="'. home_url() .'/">Home</a> &rsaquo; '. $root_text .' '. $return;

	// in all other cases use original bbp_breadcrumb function
	else :

		$args = array(
			'before' => '<div class="bbp-breadcrumb row"><p class="'. $class .'">' // use columnal classes
		);
		return bbp_breadcrumb( $args );

	endif;
}

/**
 * Do the bbp_template_notices action
 *
 * @uses do_action(), to get the bbp_template_notices handle
 * @todo get it working
 */
function epsilon_bbp_template_notices(){
	global $post;
	do_action( 'bbp_template_notices' );
}

/**
 * Output post meta for the post
 *
 * @uses the_date(), to get the date of the post
 * @uses bbp_get_user_profile_url(), to get the permalink for the author
 * @uses get_the_author_meta(), to get the author ID
 * @uses the_author(), to get the author name
 * @uses the_category(), to get all categories
 * @uses comments_open()
 * @uses have_comments()
 * @uses the_permalink(), to use the permalink for this post
 * @uses comments_number(), to display the comment count
 * @uses get_category_link(), to get the link for the category
 */
function epsilon_postmeta(){
	global $post;

	?><ul class="post-meta">
		<li><i class="icon-calendar"></i> <?php the_date(); ?></li>
		<li><i class="icon-user"></i> <a href="<?php echo bbp_get_user_profile_url( get_the_author_meta( 'ID' ) ); ?>"><?php the_author(); ?></a></li>
		<li><i class="icon-bookmark"></i> <?php the_category(' &#8226; '); ?></li>
		<?php if ( comments_open( $post->ID ) || have_comments() ) : ?>
			<li><i class="icon-comment"></i> <a href="<?php the_permalink(); ?>#entries"><?php comments_number( '0', '1', '%' ); ?></a></li>
		<?php endif; ?>
	</ul><?php
}

/**
 * Do some image handling before content output
 *
 * Hooked into the_content filter
 *
 * @param string $content, the content to process
 * @return string $content
 */
function epsilon_edit_content_imgs( $content ){

	// Remove width and height attributes to make imgs autofit correctly in columns
    $content = preg_replace( '/(width|height)=\"\d*\"\s/', "", $content );

    // Remove autop around (linked) img elements
    $content = preg_replace( '/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content );

    return $content;
}
add_filter( 'the_content', 'epsilon_edit_content_imgs' );

/**
 * Get blog page id or title or permalink
 *
 * @param string $arg, to name which value to get
 * @uses get_option(), to get the show_on_front option
 * @uses get_page(), to get the page object by it's id
 * @uses get_page_uri(), to get the uri of the page by it's id
 * @return int $posts_page_id, the id of the blog page
 *         string $posts_page_title, the page title of the blog page
 *         string $posts_page_url, the permalink to the blog page
 */
function epsilon_get_blog_page( $arg = 'id' ) {

	// Is blog page set to custom page?
	if ( get_option( 'show_on_front' ) == 'page' ){
		$posts_page_id    = get_option( 'page_for_posts' );
		$posts_page       = get_page( $posts_page_id );
		$posts_page_title = $posts_page->post_title;
		$posts_page_url   = get_page_uri( $posts_page_id );
	} else {
		$posts_page_id = 0;
		$posts_page_title = $posts_page_url = '';
	}

	switch ( $arg ) :
		case 'title' : return $posts_page_title;
			break;
		case 'url'   : return home_url() .'/'. !empty( $posts_page_url ) ? $post_page_url . '/' : '';
			break;
		case 'id'    : 
		default      : return $posts_page_id;
			break;
	endswitch;
}

/**
 * Generate url of current url to redirect to
 *
 * @uses esc_url(), to create a clean url
 * @uses $_SERVER[ 'HTTP_HOST' ], to fetch current domain
 * @uses $_SERVER[ 'REQUEST_URI' ], to fetch current uri
 * @return generated current url
 */
function epsilon_current_url(){
	return esc_url( $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] );
}

/**
 * Generate logout url with redirect to current url
 *
 * @uses esc_url(), to create a clean url
 * @uses wp_logout_url(), to generate logout paramaters
 * @uses epsilon_current_url(), to generate current url
 * @return generated logout url
 * @todo predict if current url is accessible and if not return the parent (recursive)
 */
function epsilon_logout_url(){
	return esc_url( wp_logout_url( epsilon_current_url() ) );
}

/**
 * Create custom search form
 *
 * Hooked to get_search_form filter
 *
 * @param string $form, string with the default search form
 * @uses get_search_query(), to get the performed search query
 * @return $form, string with the rewrited search form in html
 */
function epsilon_search_form( $form ){
    $form = '<form role="search" method="get" id="searchform" action="'. home_url( '/' ) .'" >
    <div class="searchform"><label class="visuallyhidden" for="s">'. __('Search for:') .'</label>
	<div class="input-prepend">
		<span class="add-on"><i class="icon-search"></i></span>
		<input type="text" value="'. get_search_query() .'" name="s" id="s" placeholder="Zoekterm" />
	</div>
	<input type="submit" id="searchsubmit" value="'. esc_attr__('Search') .'" />
	</div>
    </form>';

    return $form;
}
add_filter( 'get_search_form', 'epsilon_search_form' );

/**
 * Custom variation on wp_link_pages()
 *
 * @uses global $page, to read on which subpage we are
 * @uses global $pages, to read how many subpages this page has
 * @uses wp_link_pages(), to return page navigation if applicable
 * @return wp_link_pages(), with edited markup
 */
function epsilon_link_pages(){
	global $page, $pages;
	$text = 'U bent op pagina '. $page .' van '. count($pages) .': ';
	return wp_link_pages( 'before=<div class="post-pagination clearfix">'.$text.'&after=</div>' );
}

/**
 * Return header image attributes
 *
 * @param string $item, the requested image attribute
 * @uses is_home(), to check if we're on the blog page
 * @uses get_post(), to get a post
 * @uses epsilon_get_blog_page(), to get the blog page id
 * @uses has_post_thumbnail(), to check if current post has the required thumbnail
 * @uses wp_get_attachment_image_src(), to get the image properties
 * @uses get_post_thumbnail_id(), to get the thumbnail id
 * @uses get_permalink(), to get the permalink of the post
 * @echo the requested value
 * @todo use theme settings
 */
function epsilon_header_img( $item = 'image', $echo = true ){
	global $post;
	if ( is_home() )
		$post = get_post( epsilon_get_blog_page() );

	if ( ( has_post_thumbnail() && get_the_post_thumbnail( $post->ID, 'header-post-thumbnail' ) != '' ) // If current page has required post thumbnail of its own
		|| is_front_page() || is_home() ){ // Or we're on the front page / home page where we use a custom slideshow
		$image = wp_get_attachment_image_src( get_post_thumbnail_id(), array( 1600, 9999 ) );
		$attachment = get_post( get_post_thumbnail_id() );
		$current_post = get_post( $attachment->post_parent );

		switch( $item ){
			case 'class' :
				$retval = 'custom-header-image';
				break;
			case 'image' :
				$retval = $image[0];
				break;
			case 'url' :
				$retval = get_permalink( $current_post->ID );
				break;
			case 'type' :
				$retval = $current_post->post_type;
				break;
			case 'title' :
				$retval = $current_post->post_title;
				break;
			case 'offset':
				$retval = '150'; // to be set with theme/plugin settings?
				break;
			case 'height':
				$retval = $image[2]; // or top/bottom with theme/plugin settings
				break;
			default:
				$retval = $current_post->post_title;
		};
	} else { // get the default image attributes
		switch( $item ){
			case 'class' :
				$retval = 'default-header-image';
				break;
			case 'image' :
				$retval = get_template_directory_uri() .'/featured/vgsr_das.jpg';
				break;
			case 'url' :
				$retval = home_url() .'/vereniging/berichten/';
				break;
			case 'type' :
				$retval = 'pagina';
				break;
			case 'title' :
				$retval = 'Lees meer over onze activiteiten';
				break;
			case 'offset':
				$retval = '200';
				break;
			case 'height':
				$retval = '1197';
				break;
			default:
				$retval = 'Lees meer over onze activiteiten';
		};
	}

	// Return or output
	if ( !$echo )
		return $retval;
	else
		echo $retval;
}

/** 
 * Add header-image class to the body element (default-header-image or custom-header-image)
 *
 * Hooked into body_class filter
 *
 * @param array $classes, the body classes
 * @return array $classes
 */
function epsilon_header_img_body_class( $classes ){
	$classes[] = epsilon_header_img('class', false);
	return $classes;
}
add_filter( 'body_class', 'epsilon_header_img_body_class' );

/**
 * Construct header image css and rel attributes
 *
 * @uses epsilon_header_img(), to get the image attributes
 * @echo css inline style
 */
function epsilon_header_img_construct(){

	$height = epsilon_header_img('height', false);
	$offset = epsilon_header_img('offset', false);

	$image = 'style="background-image: url('. epsilon_header_img('image', false) .'); 
		background-position: center -'. $offset .'px;" 
		rel="'. $offset .','. $height .'"';

	echo $image;
}

/**
 * Show header-caption on front page
 *
 * @uses is_front_page(), to detect when we're on the front page
 * @uses epsilon_header_img(), to get the image attributes
 * @echo html for header caption
 */
function epsilon_header_img_caption(){
	?><div id="header-caption">
			<p><a href="<?php epsilon_header_img('url'); ?>">&raquo; <span class="cap-type"><?php epsilon_header_img('type'); ?></span>: <span class="cap-title"><?php epsilon_header_img('title'); ?></span></a></p>
		</div><?php
}

/**
 * Return an html img tag with the post thumbnail without size paramaters
 *
 * @param int $postid, the id of the post to return for
 * @param string $class, provide additionail img classes
 * @uses has_post_thumbnail(), to check for existing post thumbnail
 * @uses wp_get_attachment_image_src(), to get the image uri
 * @return $thumbnail, the html img string
 */
function epsilon_post_thumbnail( $postid, $class = '' ){
	// get current post
	$post = get_post( $postid );

	// if this post has no thumbnail we do nothing
	if ( !has_post_thumbnail( $postid ) )
		return '';

	// return the image source for the post thumbnail @ 440 x 138
	$image = wp_get_attachment_image_src( get_post_thumbnail_id( $postid ), array( 440, 138 ) );
	$thumbnail = '<image class="'. $class .'" src="'. $image[0] .'" title="'. $post->post_title .'" />';

	return $thumbnail;
}

/**
 * Dynamically set up a list of images to be rotated in the header and trigger the script
 *
 * Hooked to the wp_footer action
 *
 * @uses is_singular(), to make sure we are on a single post/page
 * @uses get_posts(), to get the attachments that go with the current post
 * @uses wp_get_attachment_image_src(), to get the image path
 * @uses apply_filters(), to have the post title filtered when needed
 * @uses get_permalink(), to get the permalink of the current post
 * @uses is_front_page(), to check current page
 * @uses is_home(), to check current page
 * @uses get_template_directory_uri(), to get the theme directory uri
 * @uses get_theme_root(), to get the image uri
 * @uses getimagesize(), to get the image attributes
 * @echo javascript list of image attributes to be handled by bgimgSlideshow
 * @todo - make it dynamic using epsilon_header_img()
 */
function epsilon_header_img_rotate_script(){
	global $post;
	$rotator = false; // set it later to true if we need to rotate

	// get attachments for current post/page
	if ( is_singular() ){ 
		$args = array(
			'post_type' => 'attachment',
			'numberposts' => -1,
			'post_status' => null,
			'post_parent' => $post->ID,
			'order' => 'ASC'
		);
		$attachments = get_posts( $args );

		foreach ( $attachments as $key => $attachment ) :
			if ( !wp_get_attachment_image_src( $attachment->ID, array( 1600, 9999 ) ) )
				unset( $attachments[$key] );
		endforeach;

		if ( count($attachments) >= 2 ){
			$rotator = true; // We have enough items to get it rotatin' !
		}
	}

	// if we need to rotate add the script
	if ( $rotator ) :
		?>	<script defer type="text/javascript">
		jQuery(document).ready( function($){
			$('#header-images').bgimgSlideshow({
				slideshowSpeed: 5000, // option
				fadeSpeed: 1500, // option
				photos: [<?php
				foreach ( $attachments as $k => $attachment ) : ?>{
					'type':   'foto',
					'title':  '<?php echo apply_filters( 'the_title', $attachment->post_title ); ?>',
					'image':  '<?php $image = wp_get_attachment_image_src( $attachment->ID, array( 1600, 9999 ) ); echo $image[0]; ?>',
					'url':    '<?php echo get_permalink( $attachment->post_parent ); ?>',
					'offset': '150', // to get with theme/plugin settings
					'height': '<?php echo $image[2]; ?>'
					}<?php echo ( $k+1 != count($attachments) ) ? ',' : '';
				endforeach; ?>]
			});
		});
		</script><?php
	endif;

	// setup post requirements
	// only if we are on front page or blog page
	if ( is_front_page() || is_home() ){

		$featured_dir = get_template_directory_uri() .'/featured';
		$images = array(
			array( 	
				'type'   => 'bericht',
				'title'  => 'Kom op de Examenborrel!',
				'src'    => $featured_dir .'/societeit_pr.jpg',
				'url'    => 'vereniging/berichten/',
				'offset' => '150',
			), array(
				'type'   => 'bericht',
				'title'  => 'Amicaal feest 3e dinsdag van september',
				'src'    => $featured_dir .'/feest_110920.jpg',
				'url'    => 'vereniging/berichten/',
				'offset' => '900',
			), array(
				'type'   => 'bericht',
				'title'  => 'Lezing Gender en Mannelijkheid',
				'src'    => $featured_dir .'/lezing_091119.jpg',
				'url'    => 'vereniging/berichten/',
				'offset' => '300',
			), array(
				'type'   => 'pagina',
				'title'  => 'Al 60 jaar VGSR',
				'src'    => $featured_dir .'/vgsr_das.jpg',
				'url'    => 'vereniging/al-sinds-1950/',
				'offset' => '200',
			), array(
				'type'   => 'pagina',
				'title'  => 'Bestuur Bredemeijer',
				'src'    => $featured_dir .'/bestuur_bredemeijer01.jpg',
				'url'    => 'vereniging/bestuur/bredemeijer/',
				'offset' => '150',
			), array(
				'type'   => 'fotogalerij',
				'title'  => 'LIXe Dies Natalis 2010',
				'src'    => $featured_dir .'/diesnatalis_2010.jpg',
				'url'    => 'vereniging/fotogalerij/',
				'offset' => '250',
			), array(
				'type'   => 'pagina',
				'title'  => 'Bestuur Bredemeijer',
				'src'    => $featured_dir .'/bestuur_bredemeijer02.jpg',
				'url'    => 'vereniging/bestuur/bredemeijer/',
				'offset' => '0',
			), array(
				'type'   => 'fotogalerij',
				'title'  => 'Lustrumreis Berlijn',
				'src'    => $featured_dir .'/lustrum_berlijn_groep.jpg',
				'url'    => 'vereniging/fotogalerij/',
				'offset' => '75',
			), array(
				'type'   => 'pagina',
				'title'  => 'Bestuur Suurmond II',
				'src'    => $featured_dir .'/bestuur_suurmond2.jpg',
				'url'    => 'vereniging/bestuur/suurmond-ii/',
				'offset' => '50',
			), array(
				'type'   => 'topic',
				'title'  => 'Amicaal feest VGSR [21 September]',
				'src'    => $featured_dir .'/rdam_erasmusbrug.jpg',
				'url'    => 'discussie/over/amicaal-feest-vgsr-21-september/',
				'offset' => '425',
			), array(
				'type'   => 'bericht',
				'title'  => 'Rondleiding Ketel1',
				'src'    => $featured_dir .'/ketel1.jpg',
				'url'    => 'contact/sponsoren/ketel1',
				'offset' => '500',
			)
		);

		?><script defer type="text/javascript">
			jQuery(document).ready( function($){
				$('#header-images').bgimgSlideshow({
					slideshowSpeed: 5000,
					fadeSpeed: 1500,
					photos: [{<?php foreach ( $images as $k => $image ) : ?>
						'type':   '<?php echo $image['type']; ?>',
						'title':  '<?php echo $image['title']; ?>',
						'image':  '<?php echo $image['src']; ?>',
						'url':    '<?php echo $image['url']; ?>',
						'offset': '<?php echo $image['offset']; ?>',
						'height': '<?php $filesize = getimagesize( $image['src'] ); echo $filesize[1]; ?>',
							<?php echo ( $k != count($images) - 1 ) ? '}, {' : '}';
						endforeach;
						?>]
				});
			});
		</script><?php
	}

	// foreach ( get_post_meta( $post->ID, 'epsilon-header-images', true ) as $post_id => $args ){
	// 	$this_post = get_post( $post_id );
	// 	echo "{'type'  : '$this_post->post_type>',
	// 		'title' : '$this_post->post_title',
	// 		'image' : '{$args['image_url']}',
	// 		'url'   : 'get_the_permalink( $post_id )',
	// 		'offset': '{$args['offset']}',
	// 		'height': '{$args['height']}'}";
	// 	// echo comma except on last item
	// }


}
add_action( 'wp_footer', 'epsilon_header_img_rotate_script' );

/**
 * Check for lidmaatschap of current user
 *
 * @uses is_user_logged_in(), to check if current user is logged in
 * @uses apply_filters(), to make access pluggable
 * @return boolean, true if is lid, false if not
 */
function epsilon_user_access( $id = '' ){
	$access = is_user_logged_in();
		
	// make member control pluggable
	return apply_filters( 'epsilon_user_access', $access, $id );
}

/**
 * Create columnal classes
 *
 * @param int $default, default width of the current column
 * @param bool $last, boolean wether the current column is the last in a row
 * @echo columnal class
 */
function epsilon_columnal_class( $default = 9, $last = true ){
	echo epsilon_get_columnal_class( $default, $last );
}

	/**
	 * Return columnal classes
	 *
	 * @uses epsilon_user_access(), to check if current user is lid
	 * @param int $default, default width of the current column
	 * @param bool $last, boolean wether the current column is the last in a row
	 * @return columnal class
	 *
	 */
	function epsilon_get_columnal_class( $default = 9, $last = true ){
		if ( $last ) $last = ' last';
		return ( epsilon_user_access() ) ? 'col_'. ( $default - 2 ) : 'col_'. $default . $last;
	}

/**
 * Create columnal classes for forum pages
 * Different from epsilon_columnal_class for smaller default column width and sidebar handling
 *
 * Used only on bbPress pages
 *
 * @param int $default, default width of the current column
 * @param bool $last, boolean wether the current column is the last in a row
 * @echo bbp columnal class
 */
function epsilon_columnal_class_bbp( $default = 10, $last = false ){
	echo epsilon_get_columnal_class_bbp( $default, $last );
}

	/**
	 * Return columnal classes for forum pages
	 * Different from epsilon_columnal_class for smaller default column width and sidebar handling
	 *
	 * Used only on bbPress pages
	 *
	 * @uses epsilon_user_access(), to check if current user is lid
	 * @param int $default, default width of the current column
	 * @param bool $last, boolean wether the current column is the last in a row
	 * @return bbp columnal class
	 */
	function epsilon_get_columnal_class_bbp( $default = 10, $last = false ){
		if ( $last ) $last = ' last';
		return ( epsilon_user_access() ) ? 'col_'. ( $default - 2 ) . $last : 'col_'. ( $default - 1 ) . $last;
	}

/**
 * Write columnal classes on bbPress page for sidebar
 *
 * @uses epsilon_user_access(), to check if current user is lid
 * @echo class
 */
function epsilon_sidebar_forum_class(){
	$return = 'col_2';
	if ( ! epsilon_user_access() )
		$return = 'col_3 last';
	echo $return;
}

/**
 * Only enqueue comment-reply script when threaded comments option is on and when comment form is shown
 *
 * Hooked to the comment_form_before action
 *
 * @uses get_option(), to get the thread-ocmments option
 * @uses wp_enqueue_script(), to add the comment-reply script to this page
 */
function epsilon_enqueue_comments_reply(){
	if ( get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );
}
add_action( 'comment_form_before', 'epsilon_enqueue_comments_reply' );

/**
 * Create theme sidebars
 *
 * Hooked to the widgets_init action
 *
 * @uses register_sidebar(), to register the sidebars
 * @uses is_bbp_active(), to check if bbPress plugin is activated
 */
function epsilon_register_sidebars(){
	register_sidebar( array(
		'id'            => "main-sidebar",
		'name'          => "Main Sidebar",
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4>',
		'after_title'   => '</h4>'
	));
	register_sidebar( array(
		'id'            => "sidebar-leden",
		'name'          => "Sidebar Leden",
		'description'   => "Wordt alleen getoond aan ingelogde leden.",
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4>',
		'after_title'   => '</h4>'
	));
	// Front page
	register_sidebar( array(
		'id'            => "front-page-sidebar-1",
		'name'          => "Front Page Sidebar 1",
		'before_widget' => '<div id="%1$s" class="widget col_3 %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4>',
		'after_title'   => '</h4>'
	));
	register_sidebar( array(
		'id'            => "front-page-sidebar-2",
		'name'          => "Front Page Sidebar 2",
		'before_widget' => '<div id="%1$s" class="widget col_3 %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4>',
		'after_title'   => '</h4>'
	));
	// Footer
	register_sidebar( array(
		'id'            => "footer-sidebar-left",
		'name'          => "Footer Sidebar Left",
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h5>',
		'after_title'   => '</h5>'
	));
	register_sidebar( array(
		'id'            => "footer-sidebar-center",
		'name'          => "Footer Sidebar Center",
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h5>',
		'after_title'   => '</h5>'
	));
	register_sidebar( array(
		'id'            => "footer-sidebar-right",
		'name'          => "Footer Sidebar Right",
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h5>',
		'after_title'   => '</h5>'
	));

	// Forum Sidebar
	if ( is_bbp_active() ){
		register_sidebar( array(
			'id'            => "forum-sidebar",
			'name'          => "Forum Sidebar",
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4>',
			'after_title'   => '</h4>'
		));
	}

}
add_action( 'widgets_init', 'epsilon_register_sidebars' );

/**
 * Create header links
 *
 * @uses bloginfo(), to get rss permalink
 * @echo html markup
 * @todo use theme settings
 */
function epsilon_header_links(){
	?><div id="links" class="mobile-hide">
		<a class="vgs-nl" href="http://www.vgs-nederland.nl">VGS-Nederland</a>
		<a class="ketel1" href="http://www.ketel1.nl">Hoofdsponsor Ketel1</a>
		<a class="social maps" href="">Maps</a>
		<a class="social twitter" href="">VGSR Twitter</a>
		<a class="social mail" href="">RSS Mail</a>
		<a class="social reacties" href="">RSS Reacties</a>
		<a class="social feed" href="<?php bloginfo('rss2_url'); ?>">RSS Feed</a>
	</div><?php
}

/**
 * Create login form
 *
 * @uses is_user_logged_in(), to check if user is logged in
 * @uses get_permalink(), to get the current permalink for redirection
 * @uses epsilon_get_blog_page(), to get the current permalink when on blog page
 * @uses global $current_user, to fetch the current user
 * @uses get_avatar(), to get the avatar of current user
 * @uses is_bbp_active(), to check if bbPress is activated for additional logged-in features
 * @uses bbp_get_user_profile_url(), to get the profile url of current user
 * @uses epsilon_logout_url(), to use the custom logout url
 * @echo html markup
 */
function epsilon_login_form(){
	if ( !is_user_logged_in() ){
		?><form name="loginform" method="post" action="<?php echo home_url(); ?>/wp-login.php">
			<fieldset>
				<p class="input-prepend">
					<span class="add-on"><i class="icon-user"></i></span>
					<input type="text" name="log" id="user_login" placeholder="Naam"/>
				</p>
				<p class="input-prepend">
					<span class="add-on"><i class="icon-key"></i></span>
					<input type="password" name="pwd" id="user_pass" placeholder="Wachtwoord"/>
				</p>
				<p class="rememberme"><label><input name="rememberme" type="checkbox" id="rememberme" value="forever" tabindex="90" /> Onthoud mij</label></p>
				<p class="submit">
					<?php wp_referer_field( true ); ?>
					<input type="hidden" name="redirect_to" value="<?php echo epsilon_current_url(); ?>" />
					<input type="hidden" name="testcookie" value="1" />
					<input type="submit" name="wp-submit" class="submit" value="Login" />
				</p>
			</fieldset>
		</form><?php
	} else { // user is logged in
		global $current_user;

		?><div class="loggedin">
			<p class="loggedin-as">U bent ingelogd als <em><?php echo $current_user->display_name; ?></em></p>
			<p class="loggedin-avatar"><?php echo get_avatar( $current_user->ID, 32 ); ?></p>
			<ul class="loggedin-links">
				<?php if ( is_bbp_active() ) echo '<li><i class="icon-user"></i> <a href="'. bbp_get_user_profile_url( $current_user->ID ) .'">Profiel</a></li>'; ?>
				<?php if ( is_bbp_active() ) echo '<li><i class="icon-write"></i> <a href="'. bbp_get_user_profile_edit_url( $current_user->ID ) .'">Mijn gegevens</a></li>'; ?>
				<?php if ( current_user_can( 'edit_users' ) ) echo '<li><i class="icon-settings"></i> <a href="'. admin_url() .'">Dashboard</a></li>'; ?>
				<li><i class="icon-reply"></i> <a href="<?php echo epsilon_logout_url(); ?>">Uitloggen</a></li>
			</ul>
		</div><?php
	}
}

/**
 * Callback for wp_list_comments to display the entries
 *
 * @param array $comment, the current comment
 * @param array $args, arguments for comment_reply_link
 * @param int $depth, set the structure depth of the comment listings
 * @uses comment_class(), to get the css classes for this comment
 * @uses comment_ID(), to get the ID of this comment
 * @uses get_avatar(), to get the avatar of the commenter
 * @uses get_comment_author_link(), to get the name with permalink of the commenter
 * @uses get_comment_time(), get the commented time
 * @uses get_comment_date(), get the commented date
 * @uses comment_text(), get the comment
 * @uses edit_comment_link(), create permalink to edit this comment
 * @uses comment_reply_link(), create permalink to reply on this comment
 * @echo html markup
 */
function epsilon_entries( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
			// ignore
			break;
		default :
	?>
	<li <?php comment_class( 'row post-entry' ); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment clearfix">
			<footer class="entry-author vcard entry-meta col_3 clearfix">
				<div class="entry-wrapper">
					<?php
						if ( is_bbp_active() ){
							printf( '<a href="%1$s" rel="nofollow">%2$s</a>', bbp_get_user_profile_url( $comment->user_id ), get_avatar( $comment, 50 ) );
							printf( '<cite class="fn">%s</cite>', bbp_get_user_profile_link( $comment->user_id ) );
						} else {
							echo get_avatar( $comment, 50 );
							printf( '<cite class="fn">%s</cite>', get_comment_author_link() );
						}
					?>
					<div class="entry-metadata">
						<?php
						printf( '<a href="%1$s"><time pubdate datetime="%2$s">%3$s</time></a>',
							esc_url( get_comment_link( $comment->comment_ID ) ),
							get_comment_time( 'c' ),
							sprintf( __( '%1$s<br /> om %2$s', 'epsilon' ), get_comment_date(), get_comment_time() )
						);
						?>
					</div>
				</div><!-- .entry-author .vcard -->
			</footer>

			<div class="comment-content entry-body col_9 last">
				<div class="entry-wrapper">

					<?php if ( $comment->comment_approved == '0' ) : ?>
						<em class="comment-awaiting-moderation"><?php _e( 'Uw reactie moet nog geaccordeerd worden.', 'epsilon' ); ?></em>
						<br />
					<?php endif; ?>

					<?php comment_text(); ?>
					<div class="entry-admin-links">
						<?php edit_comment_link( __( 'Bewerk', 'epsilon' ), '<span class="edit-link">', '</span> | ' ); ?>
						<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Beantwoorden &rarr;', 'epsilon' ), 'depth' => $depth, 'max_depth' => 3 ) ) ); ?>
					</div><!-- .entry-admin-links -->
				</div>
			</div>
		</article><!-- #comment-<?php comment_ID(); ?> -->

	<?php
			break;
	endswitch;
}

/**
 * Add columnal classes to comment_form() to fit the form in the theme
 *
 * Hooked to
 *    comment_form_logged_in filter
 *    comment_form_field_author filter
 *    comment_form_field_email filter
 *    comment_form_field_url filter
 *    comment_form_field_comment filter
 *    comment_form_defaults filter
 *    comment_form action
 *
 * @param string $field, the html of the current field
 * @param array $defaults, array with string variables for form text
 * @return $field, the html current field with columnal classes added
 * @return $defaults, edited array with string variabels for form text
 * @echo html
 */
function epsilon_comment_form_logged_in( $field ){
	$field = str_replace( '<p class="', '<p class="pre_3 col_9 last ', $field );
	return $field;
}
function epsilon_comment_form_fields( $field ){
	$field = str_replace( '<p class="', '<p class="col_3 ', $field );
	$field = str_replace( '<input', '</p><p class="col_9 last"><input', $field );
	return $field;
}
function epsilon_comment_form_field_comment( $field ){
	$field = str_replace( '<p class="', '<p class="col_3 ', $field );
	$field = str_replace( '<textarea', '</p><p class="col_9 last"><textarea', $field );
	return $field;
}
function epsilon_comment_form_defaults( $defaults ){
	$defaults['title_reply'] = 'Geef uw reactie';
	$defaults['title_reply_to'] = 'Geef uw reactie op %s';
	$defaults['cancel_reply_link'] = 'Beantwoorden annuleren';
	$defaults['must_log_in'] = '<p class="pre_3 col_9 last must-log-in">' .  sprintf( __( 'Je moet <a href="%s">ingelogd</a> zijn om een reactie achter te laten.' ), wp_login_url( apply_filters( 'the_permalink', get_permalink( ) ) ) ) . '</p>';
	$defaults['comment_notes_before'] = '<p class="pre_3 col_9 last comment-notes">' . __( 'Je email wordt niet gepubliceerd.' ) . '</p>';

	$comment_notes = '<p class="pre_3 col_9 last form-allowed-tags">' . sprintf( __( 'You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes: %s' ), ' <code>' . allowed_tags() . '</code>' ) . '</p>';
	// Adds opening div tag with columnal class before <p class="form-submit"></p> � see epsilon_comment_form_bottom() for closing </div>
	$comment_notes .= '<div class="pre_3 col_9 last">';
	$defaults['comment_notes_after'] = $comment_notes;

	return $defaults;
}
function epsilon_comment_form_bottom(){
	// Adds closing div tag after <p class="form-submit"></p> � see epsilon_comment_form_defaults()
	echo '</div>';
}
add_filter( 'comment_form_logged_in', 'epsilon_comment_form_logged_in' );
add_filter( 'comment_form_field_author', 'epsilon_comment_form_fields' );
add_filter( 'comment_form_field_email', 'epsilon_comment_form_fields' );
add_filter( 'comment_form_field_url', 'epsilon_comment_form_fields' );
add_filter( 'comment_form_field_comment', 'epsilon_comment_form_field_comment' );
add_filter( 'comment_form_defaults', 'epsilon_comment_form_defaults' );
add_action( 'comment_form', 'epsilon_comment_form_bottom' );

/**
 * Auto pre-install plugins on theme activation
 *
 * Hooked to tgmpa_register action from tgmpa plugin
 *
 * @link https://github.com/thomasgriffin/TGM-Plugin-Activation
 * @uses class-tgm-plugin-activation, to use the plugin
 */
function epsilon_register_required_plugins() {
	require_once dirname( __FILE__ ) . '/inc/class-tgm-plugin-activation.php';
	$plugins = array(
		array(
			'name' => 'bbPress',
			'slug' => 'bbpress',
			// 'source'   => get_stylesheet_directory() . '/lib/plugins/tgm-example-plugin.zip', // The plugin source
			'required' => true
		)
	);

	$config = array( 'notices' => true );

	tgmpa( $plugins, $config );
}
add_action( 'tgmpa_register', 'epsilon_register_required_plugins' );

/**
 * Detect and add platform and browser name to body class
 * Query vars 'platform' and 'browser' are added by Mobile Client Detection plugin
 *
 * Hooked to body_class filter
 *
 * @link http://wordpress.org/extend/plugins/mobile-client-detection-plugin/
 * @uses get_query_var(), to read given var from the post query
 * @param arary $classes, classes for the body
 * @return array $classes, extra classes added
 */
function epsilon_platform_browser_class( $classes ){
 	if ( get_query_var( 'platform' ) )
		$classes[] = get_query_var( 'platform' );
	if ( get_query_var( 'browser' ) )
		$classes[] = get_query_var( 'browser' );
	return $classes;
}
add_filter( 'body_class', 'epsilon_platform_browser_class' );

/**
 * Limit outputted content to maximum words
 *
 * @link http://www.fusedthought.com/archives/wordpress-custom-content-length-code-snippet
 * @param int $content_length, int number of words to output
 * @param bool $allowtags, boolean whether to allow html tags
 * @param string $allowedtags, string of tags to allow
 * @param string $readmore, string with read-more text
 * @uses apply_filters(), to filter the_content
 * @return limited content
 */
function limit_content( $content_length = 250, $allowtags = true, $allowedtags = '', $readmore = '' ){
	global $post;
	$content = $post->post_content;
	$content = apply_filters( 'the_content', $content );

	if ( !$allowtags ){
		$allowedtags .= '<style>';
		$content = strip_tags( $content, $allowedtags );
	}
	$wordarray = explode( ' ', $content, $content_length + 1 );
	if ( count( $wordarray ) > $content_length ) :
		array_pop( $wordarray );
		array_push( $wordarray, '...' );
		$content = implode( ' ', $wordarray );
		if ( !empty( $readmore ) )
			$content .= ' <a href="'. get_permalink( $post->ID ) .'">'. $readmore .'</a>';
		$content .= "</p>";
	endif;

	return $content;
}

/**
 * Limit outputted content to maximum words with the content to be processed inserted
 *
 * See limit_content function
 *
 * @param string $content, the content to process
 * @param int $content_length, int number of words to output
 * @param bool $allowtags, boolean whether to allow html tags
 * @param string $allowedtags, string of tags to allow
 * @param string $readmore, string with read-more text
 * @uses apply_filters(), to filter the_content
 * @return limited content
 */
function limit_content_extra( $content, $content_length = 250, $allowtags = true, $allowedtags = '', $readmore = '' ){
	if ( !$allowtags ){
		// for [post_type = reply] delete all the divs with class quotetitle or quotecontent -- KONING!
		$content = preg_replace( '~<div([^>]*)(class\\s*=\\s*["\'](quotetitle|quotecontent)["\'])([^>]*)>(.*?)</div>~i', '', $content );
	
		$allowedtags .= '<style>';
		$content = strip_tags( $content, $allowedtags );
	}
	$wordarray = explode( ' ', $content, $content_length + 1 );
	if ( count( $wordarray ) > $content_length ) :
		array_pop( $wordarray );
		array_push( $wordarray, '...' );
		$content = implode( ' ', $wordarray );
		if ( !empty( $readmore ) )
			$content .= ' <a href="'. get_permalink( $post->ID ) .'">'. $readmore .'</a>';
		// $content .= "</p>";
	endif;

	return $content;
}

/**
 * Extend Walker_Nav_Menu to set menu depth and parent globals
 *
 * @sets global bool $epsilon_menu_parent, whether the current item has children
 * @sets global int $epsilon_menu_depth, the depth of the current item
 */
class Epsilon_Walker_Main_Menu extends Walker_Nav_Menu {
	function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ){
	    $GLOBALS['epsilon_menu_parent'] = ( isset( $children_elements[$element->ID] ) ) ? 1 : 0;
        $GLOBALS['epsilon_menu_depth'] = (int) $depth;
        parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
    }
}

/**
 * Add depth and parent classes to nav menu elements
 *
 * Requires Epsilon_Walker_Main_Menu to set the extra globals
 *
 * @param array $classes, the current element classes
 * @param obj $item, the current item
 * @uses global int $epsilon_menu_depth, the depth of the current item
 * @uses global bool $epsilon_menu_parent, whether the current item has children
 * @return array $classes, the new classes added
 */
function epsilon_add_menu_class( $classes, $item ){
     global $epsilon_menu_depth, $epsilon_menu_parent;
     $classes[] = 'menu-depth-' . $epsilon_menu_depth;
     if( $epsilon_menu_parent )
         $classes[] = 'menu-parent';
    return $classes;
}
add_filter( 'nav_menu_css_class', 'epsilon_add_menu_class', 10, 2 );


/**
 * PHP Helper func change array key name
 *
 * @param int|string $orig, original key name
 * @param int|string $new, new key name to set
 * @param array $array, whose key to rename
 */
function array_change_key_name( $orig, $new, &$array ){
    foreach ( $array as $k => $v )
        $return[ ( $k === $orig ) ? $new : $k ] = $v;
    return ( array ) $return;
}

/**
 *
 */
function epsilon_nice_date( $date ){
	$days_ago = round( ( date('U') - $date ) / ( 60*60*24 ) );
	if($days_ago == 0) return 'vandaag';
	elseif($days_ago == 1) return 'gisteren';
	else return $days_ago.' dagen geleden';
}

/******************************************************************************************
 *                                                                                        *
 * Bbpress functionalities                                                                *
 *                                                                                        *
 ******************************************************************************************/
 
/**
 * Display links to posts written by viewed author
 */
function epsilon_bbp_user_activity_posts(){
	if ( bbp_is_single_user() ) : ?>
		<div class="widget widget_bbp_user_activity_posts">

			<?php global $post; $args = array(
				'post_per_page' => -1,
				'showposts' => -1,
				'author' => bbp_get_user_id()
			);
			$query_posts = get_posts( $args );
			
			if ( $query_posts ) : ?>
			
				<h4>Publicaties (<?php echo count( $query_posts ); ?>)</h4>
				<ul><?php foreach( $query_posts as $post ) : setup_postdata( $post ); ?>
					<li><?php echo get_the_date(); ?> &#8212; <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a> (<a href="<?php the_permalink(); ?>#post-<?php the_ID(); ?>-comments"><?php comments_number( '0', '1', '%' ); ?></a>)</li>
				<?php endforeach; wp_reset_postdata(); ?></ul>
			
			<?php else : ?>

				<h4>Publicaties</h4>
				<p><?php echo bbp_is_user_home() ? 'Je hebt nog niets gepubliceerd.' : 'Deze gebruiker heeft nog niets gepubliceerd.'; ?></p>

			<?php endif; 
			
			// option for other functions to hook in this position
			do_action( 'epsilon_bbp_user_activity_posts' ); ?>
			
		</div>
	<?php endif;
}
add_action( 'epsilon_bbp_widgets', 'epsilon_bbp_user_activity_posts' );

/**
 * Display replies of viewed author
 */
function epsilon_bbp_user_activity_entries(){
	global $post; 
	$args = array(
		'author' => bbp_get_user_id(),
		'showposts' => 10
	); ?>
	<div id="bbp-author-replies" class="bbp-author-preplies">
		<h2 class="post-title">Laatste activiteit</h2>
		<div class="post-content">
		
			<?php if ( $query_posts = epsilon_bbp_user_activity( $args ) ) : ?>
			
				<ul class="post-list"><?php foreach( $query_posts as $post ) : setup_postdata( $post ); 
					$datelink = epsilon_nice_date( get_the_date('U') ) .' &rarr;'; 
					$datetitle = 'title="'. get_the_date() .' om '. esc_attr( get_the_time() ) .' uur"'; ?>
					<li>
					<?php switch ( $post->post_type ) : 
						case 'attachment' : ?>
							<p><small>
								<code class="type_media">Media</code>
								<a href="<?php echo get_permalink( $post->ID ); ?>"><?php echo get_the_title( $post->ID ); ?></a> toegevoegd op <a href="<?php the_permalink(); ?>" <?php echo $datetitle; ?>><?php echo $datelink; ?></a>
							</small></p>
						<?php break;
						
						case 'post' : ?>
							<p><small>
								<code class="type_post"><?php _e( 'Post' ); ?></code>
								<a href="<?php echo get_permalink( $post->ID ); ?>"><?php echo get_the_title( $post->ID ); ?></a> op <a href="<?php the_permalink(); ?>" <?php echo $datetitle; ?>><?php echo $datelink; ?></a>
							</small></p>
							<p><em><?php the_content(); ?></em></p>
						<?php break; 
						
						case 'comment' : ?>
							<p><small>
								<code class="type_comment"><?php _e( 'Comment' ); ?></code>
								Op <a href="<?php echo get_comment_link( $post->ID ); ?>"><?php echo get_the_title( $post->post_parent ); ?></a> op <a href="<?php echo get_comment_link( $post->ID ); ?>" <?php echo $datetitle; ?>><?php echo $datelink; ?></a>
							</small></p>
							<p><em><?php the_content(); ?></em></p>
						<?php break; 
						
						case 'topic' : ?>
							<p><small>
								<code class="type_topic"><?php _e( 'Topic', 'bbpress' ); ?></code>
								<a href="<?php bbp_topic_permalink( $post->ID ); ?>"><?php bbp_topic_title( $post->ID ); ?></a> in <a href="<?php bbp_forum_permalink( bbp_get_topic_forum_id( $post->ID ) ); ?>"><?php bbp_forum_title( bbp_get_topic_forum_id( $post->ID ) ); ?></a> op <a href="<?php bbp_topic_permalink(); ?>" <?php echo $datetitle; ?>><?php echo $datelink; ?></a>
							</small></p>
							<p><em><?php the_content(); ?></em></p>
						<?php break; 
						
						case 'reply' : ?>
							<p><small>
								<code class="type_reply"><?php _e( 'Reply', 'bbpress' ); ?></code>
								Op <a href="<?php bbp_topic_permalink( bbp_get_reply_topic_id( $post->ID ) ); ?>"><?php bbp_reply_topic_title( $post->ID ); ?></a> op <a href="<?php bbp_reply_url( $post->ID ); ?>" <?php echo $datetitle; ?>><?php echo $datelink; ?></a>
							</small></p>
							<p><em><?php the_content(); ?></em></p>
						<?php break; 
						
						default : ?>
							<p><small>
								<code class="type_<?php echo $post->post_type; ?>"><?php echo $post->post_type; ?></code>
								In <a href="<?php echo get_permalink( $post->post_parent ); ?>"><?php echo get_the_title( $post->post_parent ); ?></a> op <a href="<?php the_permalink( $post->ID ); ?>" <?php echo $datetitle; ?>><?php echo $datelink; ?></a>
							</small></p>
							<p><em><?php the_content(); ?></em></p>
						<?php break;
						
					endswitch; ?>
					</li>
				<?php endforeach; wp_reset_postdata(); ?></ul>
				
			<?php else : // no replies found ?>
			
				<p><?php echo bbp_is_user_home() ? 'Je hebt nog geen activiteit om te tonen.' : 'Deze gebruiker heeft nog geen activiteit om te tonen.'; ?></p>
			
			<?php endif; ?>
		</div>
	</div><!-- #bbp-author-replies --><?php 
}
add_action( 'bbp_user_activity_before', 'epsilon_bbp_user_activity_entries' );

/** 
 * Query comments and replies to return them mixed
 *
 * @param mixed $args, array of query arguments
 * @uses get_post_types(), to get the post types available
 * @uses wp_parse_args(), to merge two arrays
 * @return array $entries, post objects
 */
function epsilon_bbp_user_activity( $args = '' ){

	// set entry post_types and make post_types filterable
	$post_types = apply_filters( 'bbp_user_activity_post_types', array( 'post', 'attachment', 'reply', 'topic' ) ); 

	// default reply args to fetch latest replies
	$defaults = array(
		'showposts' => 10,
		'orderby' => 'date',
		'order' => 'DESC',
		'status' => 'publish', // and for moderators also others?
		'post_type' => $post_types,
		'author' => '', // if author isn't set, get all user activity
		'suppress_filters' => 'false' // make sure filters are run for this search
	);
	
	// merge args
	$entry_args = wp_parse_args( $args, $defaults );
	
	// args merged with default comment args to fetch latest comments
	$comment_args = array(
		'number' => $entry_args['showposts'],
		'orderby' => ( $entry_args['orderby'] == 'date' ) ? 'comment_date' : '',
		'order' => $entry_args['order'],
		'status' => 'approve', // and for moderators also 'hold'?
		'user_id' => $entry_args['author']
	);
	
	// get items
	$entries = get_posts( $entry_args );
	$comments = get_comments( $comment_args );
	
	// transform comments to posts and add them to entries array
	foreach( $comments as $comment ) :
		$entries[] = epsilon_comment_to_post( $comment );
	endforeach;
	
	// sort entries to date
	function cmp( $a, $b ){
		return ( $a->post_date == $b->post_date ) ? 0 : (( $a->post_date < $b->post_date ) ? 1 : -1 );
	}
	usort( $entries, 'cmp' );
	
	// because we have twice as much entries as we need, we delete half of our array
	for ( $i = $entry_args['showposts']; $i <= count( $entries ); $i++ ) :
		unset( $entries[$i] );
	endfor;

	// make result filterable
	return apply_filters( 'epsilon_bbp_user_activity', $entries );
}

/**
 * Transform comment objects into post objects
 *
 * @param object $comment, comment object
 * @return object $new_post, post object
 */
function epsilon_comment_to_post( $comment = '' ){

	// bail out if $comment is not an object
	if ( !is_object( $comment ) )
		return false;

	$new_post = new stdClass(); 
	
	$new_post->ID                    = $comment->comment_ID;
	$new_post->post_author           = $comment->user_id;
	$new_post->post_content          = $comment->comment_content;
	$new_post->post_date             = $comment->comment_date;
	$new_post->post_date_gmt         = $comment->comment_date_gmt;
	$new_post->post_name             = ''; // create slug?
	$new_post->post_parent           = $comment->comment_post_ID;
	$new_post->post_status           = 'publish';
	$new_post->post_type             = 'comment';
	$new_post->ping_status           = get_option('default_ping_status');
	$new_post->menu_order            = 0;
	$new_post->to_ping               = '';
	$new_post->pinged                = '';
	$new_post->post_password         = '';
	$new_post->guid                  = ''; // create guid?
	$new_post->post_content_filtered = '';
	$new_post->post_excerpt          = '';
	$new_post->import_id             = 0;
	$new_post->post_title            = '';
	
	return $new_post;
}

/**
 * Helper function lowercase first character
 *
 * Function available since PHP 5.3.0
 *
 * @param string $string, the string to transform
 * @return string $string, first char lowered
 */
if ( !function_exists('lcfirst') ){
	function lcfirst( $string ){
		$string{0} = strtolower($string{0});
		return $string;
	}
}

/**
 * Edit main query on bbp profile page
 *
 * @param obj $query, the current query
 */
function epsilon_profile_main_query( $query ){

	// Fetch core main query object
	global $wp_the_query;

	// Prevent running this edit on queries other than main query
	if ( $wp_the_query === $query // Or call $query->is_main_query() since WP 3.3
		&& $query->bbp_is_single_user ){ // Edit only bbp profile page
		
		// $query->set( '' );
	}
}
add_action( 'pre_get_posts', 'epsilon_profile_main_query' );