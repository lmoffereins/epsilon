/* Author: 
	MMC der VGSR 
	- Laurens Offereins
*/

/**
 * Transform wp nav menu into app like navigation
 */
jQuery(document).ready( function($){

	// Position vars
	var elemHeight    = 38,
		msie          = ( $.browser.msie && ( parseInt( $.browser.version.slice(0,3) ) < 10 ) ) // Check if browser is lt IE 10
						? -2 // Move menu 2 pix up
						: 0;

	// Element vars
	var headerMenu    = $('#header nav'),
	    windowWidth   = 0,
	    parentLi      = 0,
	    parentLink    = '',
	    parentLiIndex = 0;
	
	// Create 
	headerMenu.find('ul.sub-menu').each( function(){
		var $this         = $(this),
		    parentLi      = $this.parent(),
		    parentLink    = $('a', parentLi ),
		    parentLiIndex = headerMenu.find('li.menu-depth-0').index( parentLi );

		$this.prepend('<li class="menu-depth-1"><a href="'+ parentLink.attr('href') +'">'+ parentLink.html() +'</a></li>');
		$this.prepend('<li class="return"><a href="#">&larr; Terug</a></li>');
	});
	headerMenu.find('.login-form').addClass('sub-menu').prepend('<div class="return"><a href="#">&larr; Terug</a></div>');
	headerMenu.find('.loggedin-links').insertAfter('.loggedin').each( function(){
		$('li', this ).addClass('menu-depth-1');
	});

	// Fix login link
	headerMenu.find('.login-link').hide().after('<a href="#">'+ headerMenu.find('.login-link').text() +'</a>');
	// Move all icons from outside the a tag INSIDE it
	headerMenu.find('i[class^="icon-"], i[class*=" icon-"]').each( function(){
		var $this = $(this);
		$this.append(' ').prependTo($this.siblings('a'));
	});
	
	// Create the dropdown menu
	mobileMenu = function(){
		windowWidth = parseInt( $(window).width() );
		
		headerMenu.find('#menu-header-menu li, .login-form').css({ width: windowWidth });
		headerMenu.find('.loggedin').css({ width: windowWidth - 40 }); // Minus padding 20px right and left
		headerMenu.css({ top: -elemHeight * ( headerMenu.find('#menu-header-menu li.menu-depth-0').length + 1 ) +msie });
		
		// Position each nav ul.sub-menu
		headerMenu.find('ul.sub-menu').each( function(){
		var $this         = $(this);
			parentLi      = $this.parent();
			parentLiIndex = headerMenu.find('li.menu-depth-0').index( parentLi );
			$this.css({ left: windowWidth, top: -elemHeight * parentLiIndex });
		});

		// Position nav .login-form
		headerMenu.find('.login-form').css({ left: windowWidth, top: -elemHeight * headerMenu.find('#menu-header-menu li.menu-depth-0').length });
		
		// Remove lock login icon on small screen
		if ( windowWidth < 481 )
			headerMenu.find('.login a').removeClass('ir');
		else
			headerMenu.find('.login a').addClass('ir');
	}
	
	// Execute mobileMenu on init and on resizing of window
	mobileMenu();
	$(window).resize( mobileMenu );
	
	// Use label to pull nav menu down
	headerMenu.append('<div class="menu-pull"><a href="#">&darr; Menu</a></div>');
	var navPos = headerMenu.position();
	var navHei = elemHeight * ( headerMenu.find('#menu-header-menu li.menu-depth-0').length + 1 );
	var subHei = 0;

	// Toggle menu down to show or up to hide
	toggleMenu = function(){
		var Menu = $('#header nav'),
		    Pull = Menu.find('.menu-pull a');

		navPos = Menu.position();
		// When nav menu is open close it
		if ( navPos.top == 0 ){
			Pull.html('&darr; Menu');
			if ( navPos.left != 0 )			
				subHei = Menu.find('.sub-menu').filter( function(){ return $(this).css('display') != 'none'; }).height();
			
			subHei = ( !subHei || subHei == 0 ) ? navHei : subHei;
			
			// Move the menu
			Menu.animate({ 
				top: ( subHei * -1 ) +msie
			}, function(){ 
				Menu.find('.sub-menu').hide();
				if ( navPos.left != 0 ){ // Only when we're not on first menu level with left = 0
					$(this).css({ 
						top: Menu.height() * -1,
						left: 0 
					}).animate({ 
						top: ( navHei * -1 ) +msie
					}); 
				}
			});
			
			subHei = 0; // reset var
		} else {
			// Else open it
			Pull.html('&uarr; Menu');
			Menu.animate({ top: 0 });
		}
	}
	
	// When clicking on Menu label
	$('.menu-pull').click( function(e){
		toggleMenu();
		e.preventDefault();
	});
	
	// Varia to determine whether current state is on a sublevel
	var prestate = false; // niet te verwarren met prestat.nl
	
	// When clicking outside open nav menu
	$(window).click( function(){
		navPos = $('#header nav').position();
		if ( navPos.top == 0 )
			toggleMenu();
		return true;
	});
	
	// When clicking on a toplevel link
	headerMenu.find('.menu-depth-0, div.login').click( function(e){
		if ( !prestate ){ // Are we on the toplevel?
			$('.sub-menu', this).show( function(){
				headerMenu.animate({ left: -windowWidth });
			});
		}
		prestate = false; // We come from the toplevel
		e.preventDefault();
		e.stopPropagation();
	});
	
	// When clicking on a return link
	headerMenu.find('.return').click( function(e){
		headerMenu.animate({ left: 0 }, function(){
			$('.sub-menu', this).hide();
			console.log( 'return:: all is hidden' );
		});
		prestate = true; // We come from a sublevel
		e.preventDefault();
	});
	
	/*
	 * Because all the menu clicks are prevented from executing with e.preventDefault()
	 * we define the clicks that need an actual action here below
	 */
	 
		// when click on nav link navigate to the url and hide menu
		headerMenu.find('.menu-depth-1').click( function(){
			window.location = $('a', this).attr('href');
			var navHeight = $(this).parents('.sub-menu').height();
			headerMenu.animate({ top: -navHeight });
		});
		
		// when click on submit button submit form and hide menu
		headerMenu.find('form .submit').click( function(){
			headerMenu.find('form').submit();
			var navHeight = $(this).parent('.login-form').height();
			headerMenu.animate({ top: -navHeight });
		});
});

/**
 * Other mobile functions
 */
jQuery(document).ready( function($){

	/** Set correct header image dimensions for single header img (always img1) */
	var image     = $('#header-img1'),
		positions = image.attr('rel').split(','),
		factor    = parseInt( image.height() ) / 500; // 500 = standard desktop image header viewport height
	image.css({ 
		'background-size' : 'auto ' + factor * positions[1] + 'px',
		'backgroundPosition' : '50% -' + factor * positions[0] + 'px' 
	});

})