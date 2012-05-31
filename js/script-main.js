/* Author: 
	MMC der VGSR 
	- Laurens Offereins
*/

/**
 * Short scripts
 */
jQuery(document).ready( function($){

	// Show/hide forum admin links on hover
	$('li.type-reply .entry-admin-links').hide();
	$('li.type-reply').hover( function(){
		$('.entry-admin-links', this).show();
	}, function(){
		$('.entry-admin-links', this).hide();
	});

	// Correct html background on .default-header-image pages
	if ( $('body').hasClass('default-header-image') )
		$('html').css({ 'background': 'none' });

});

/**
 * Image header animation
 */
jQuery(document).ready( function($){
	var slideSpeed  = 300,
	    origHeight  = parseInt( $('#header').height() ),
	    origPosHTML = origHeight + 5,
	    origPosMain = parseInt( $('#main').css('margin-top') ),
	    origPosCap  = parseInt( $('#header-caption').css('margin-top') );
		
	// Move to fullscreen or back
	animateWindow = function(direction){
		var windowHeight = parseInt( $(window).height() );

		// if admin-bar is active
		if ( $('body').hasClass('admin-bar') ){ windowHeight -= parseInt( $('html').css('margin-top') ); }

		if ( direction == 'down' ){
			// first move the image position
			bgPosImage( function(){ 
			
				// calculate window/image height difference
				var windowDif = windowHeight - origHeight;
				
				// then move content 
				$('#header, .header-image').animate({ 'height' : windowHeight + 'px' }, slideSpeed ); 
				$('#main').animate({ 'margin-top' : '0px' }, slideSpeed, function(){ 
					// show navigation buttons, not on .home
					if ( $('#header-caption, #header-button').filter( ':parents( .home )' ).css( 'display' ) == 'none' ){
						$('#header-caption').fadeIn( slideSpeed );
						$('#header-controls').addClass('fullscreen');
					}
					$('#header-controls #screen').removeClass('icon-fullscreen').addClass('icon-fullscreen_exit');
				});
				$('html').animate({ 'backgroundPosition' : '0 ' + ( windowHeight + 5 ) + 'px' }, slideSpeed );
				$('#header-caption').animate({ 'margin-top' : ( windowDif + origPosCap ) + 'px' }, slideSpeed );

				// then move the header and keep the ribbon
				$('#header-wrapper').animate({ 'top' : '-145px' }, slideSpeed, function(){
					$('#header #logo h1, #header #logo span').hide();
					$('#header-wrapper #logo').addClass('single-ribbon').animate({ 'top' : '145px' }, slideSpeed, 'swing' );
				});
		
				// then hide content
				$('#main').hide( function(){ 
					$('#footer-widgets').css({ 'border-color' : '#fff' });
				}); 

			});			
		}
		else if ( direction == 'up' ){
			// first move the header and the ribbon back
			$('#header-wrapper #logo').animate({ 'top' : '0px' }, slideSpeed, 'swing', function(){ 
				$('#header-wrapper #logo').removeClass('single-ribbon').css({ 'top' : '0px' });
				$('#header #logo h1, #header #logo span').show();
				$('#header-wrapper').animate({ 'top' : '20px' }, slideSpeed );
			});
			
			// hide navigation buttons, not on .home
			if ( $('#header-caption, #header-button').filter(':parents( .home )').css('display') == 'block' ){
				$('#header-caption').fadeOut( slideSpeed );
				$('#header-controls').removeClass('fullscreen');
			}
			$('#header-controls #screen').addClass('icon-fullscreen').removeClass('icon-fullscreen_exit');
			
			// then show content
			$('#main').show( function(){
				// then move content and change img size
				$('#footer-widgets').css({ 'border-color' : '#eee' });
				$('#header, .header-image').animate({ 'height' : origHeight + 'px' }, slideSpeed );
				$(this).animate({ 'margin-top' : origPosMain + 'px' }, slideSpeed );
				$('html').animate({ 'backgroundPosition' : '0 ' + origPosHTML + 'px' }, slideSpeed );
				$('#header-caption').animate({ 'margin-top' : origPosCap + 'px' }, slideSpeed );
				
				// then move the image position
				bgPosImage();
			});
		}
		else {
			// do nothing
		}
	}
	
	bgPosImage = function(callback){
		var windowHeightNow = parseInt( $( window ).height() ),
		    origHeightNow   = parseInt( $('#header').height() ),
		    imagesSelect    = $('#header-img1, #header-img2'),
		    positions       = [],
		    y               = 0;
		
		// if admin-bar is active
		if ( $('body').hasClass('admin-bar') ){ windowHeightNow -= parseInt( $('html').css('margin-top') ); }

		// how are we viewing the image?
		if ( origHeightNow == windowHeightNow ){ // image is viewed in full window, not for long
			imagesSelect.each( function(){
				positions = $(this).attr('rel').split(',');
				if ( ( positions[1] - windowHeightNow ) > 0 ){ y = Math.abs( Math.ceil(( positions[1] - windowHeightNow ) / 2) ); };
				$(this)
					.css({ 'backgroundPosition' : '50% -' + y + 'px' })
					.animate({ // set image
						'backgroundPosition' : '(50% -' + positions[0] + 'px)'
					}, slideSpeed, callback );
			});
		}
		else { // image is now viewed in small window, not for long
			imagesSelect.each( function(){
				positions = $(this).attr('rel').split(',');
				if ( ( positions[1] - windowHeightNow ) > 0 ){ y = Math.abs( Math.ceil(( positions[1] - windowHeightNow ) / 2) ); };
				$(this).animate({ 'backgroundPosition' : '(50% -' + y + 'px)' }, slideSpeed, callback ); // center image
			});
		}
	}
	
	// Toggle full window image header on click #header-controls #screen
	$('#header-controls #screen')
		.click(
			function(){
				console.log('clicked!');
			})
		.toggle( 
			function(){
				animateWindow('down');
				console.log('fullscreen');
			}, function(){
				animateWindow('up');
				console.log('smallwindow');
		});
	
});

