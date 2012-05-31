
// usage: log('inside coolFunc', this, arguments);
// paulirish.com/2009/log-a-lightweight-wrapper-for-consolelog/
window.log = function(){
  log.history = log.history || [];   // store logs to an array for reference
  log.history.push(arguments);
  if(this.console) {
    arguments.callee = arguments.callee.caller;
    var newarr = [].slice.call(arguments);
    (typeof console.log === 'object' ? log.apply.call(console.log, console, newarr) : console.log.apply(console, newarr));
  }
};

// make it safe to use console.log always
(function(b){function c(){}for(var d="assert,count,debug,dir,dirxml,error,exception,group,groupCollapsed,groupEnd,info,log,timeStamp,profile,profileEnd,time,timeEnd,trace,warn".split(","),a;a=d.pop();){b[a]=b[a]||c}})((function(){try
{console.log();return window.console;}catch(err){return window.console={};}})());

/* PLUGIN DIRECTORY
De plugins in dit bestand [op volgorde]

	1.) Animate Background Position - http://css-tricks.com/examples/GarageDoorMenu/js/jquery.backgroundPosition.js [plugins.jquery.com/project/backgroundPosition-Effect]
	2.) Get Background Image - https://gist.github.com/1276118
	3.) Background Image Slider - http://www.marcofolio.net/webdesign/advanced_jquery_background_image_slideshow.html
	4.) jQuery extension :parent selector - http://stackoverflow.com/questions/965816/what-jquery-selector-excludes-items-with-a-parent-that-matches-a-given-selector
	   
*/

/**
 * 1.) Animate Background Position - http://css-tricks.com/examples/GarageDoorMenu/js/jquery.backgroundPosition.js [plugins.jquery.com/project/backgroundPosition-Effect]
 * Author: Alexander Farkas
 * v. 1.22
 */
(function($) { if(!document.defaultView || !document.defaultView.getComputedStyle){ /* IE6-IE8 */ var oldCurCSS = $.curCSS; $.curCSS = function(elem, name, force){ if(name === 'background-position'){ name = 'backgroundPosition'; } if(name !== 'backgroundPosition' || !elem.currentStyle || elem.currentStyle[ name ]){ return oldCurCSS.apply(this, arguments); } var style = elem.style; if ( !force && style && style[ name ] ){ return style[ name ]; } return oldCurCSS(elem, 'backgroundPositionX', force) +' '+ oldCurCSS(elem, 'backgroundPositionY', force); }; } var oldAnim = $.fn.animate; $.fn.animate = function(prop){ if('background-position' in prop){ prop.backgroundPosition = prop['background-position']; delete prop['background-position']; } if('backgroundPosition' in prop){ prop.backgroundPosition = '('+ prop.backgroundPosition; } return oldAnim.apply(this, arguments); }; function toArray(strg){ strg = strg.replace(/left|top/g,'0px'); strg = strg.replace(/right|bottom/g,'100%'); strg = strg.replace(/([0-9\.]+)(\s|\)|$)/g,"$1px$2"); var res = strg.match(/(-?[0-9\.]+)(px|\%|em|pt)\s(-?[0-9\.]+)(px|\%|em|pt)/); return [parseFloat(res[1],10),res[2],parseFloat(res[3],10),res[4]]; } $.fx.step. backgroundPosition = function(fx) { if (!fx.bgPosReady) { var start = $.curCSS(fx.elem,'backgroundPosition'); if(!start){/* FF2 no inline-style fallback */ start = '0px 0px'; } start = toArray(start); fx.start = [start[0],start[2]]; var end = toArray(fx.end); fx.end = [end[0],end[2]]; fx.unit = [end[1],end[3]]; fx.bgPosReady = true; } /*return;*/ var nowPosX = []; nowPosX[0] = ((fx.end[0] - fx.start[0]) * fx.pos) + fx.start[0] + fx.unit[0]; nowPosX[1] = ((fx.end[1] - fx.start[1]) * fx.pos) + fx.start[1] + fx.unit[1]; fx.elem.style.backgroundPosition = nowPosX[0]+' '+nowPosX[1]; }; })(jQuery); 


/**
 * 2.) Get Background Image - https://gist.github.com/1276118
 * Author: schmidsi
 * Note:   @var path toegevoegd aan @params en inner benoeming @var path uitgeschakeld
 */
(function($) { $.fn.getBgImage = function(path,callback) { var height = 0; /*var path = $(this).css('background-image').replace('url', '').replace('(', '').replace(')', '').replace('"', '').replace('"', '');*/ var tempImg = $('<img />'); tempImg.hide(); tempImg.bind('load', callback); $('body').append(tempImg); tempImg.attr('src', path); $('#tempImg').remove(); }; })(jQuery); 


/**
 * 3.) Background Image Slider - http://www.marcofolio.net/webdesign/advanced_jquery_background_image_slideshow.html
 * Author: Marco Kuiper (http://www.marcofolio.net/), Sylvain Papet (http://www.com-ocean.com/), Toxic Web (http://www.toxic-web.co.uk/) 
 * v. 1.0.1
 * Note:   Er zitten aardig wat custom tweaks in dit script (selectors, positioning etc.)
 */
(function($) {
	$.bgimgSlideshow = {version: '1.0.1'};

	$.fn.bgimgSlideshow = function(options) {
	options = jQuery.extend({
		slideshowSpeed: 6000,
		method: 'fade',
		transition: 500,
		fadeSpeed: 2000,
		contDiv: '#header',
		photos: [],
		markup1: '<div id="header-img2" class="header-image" rel="0,0"></div>',
		markup2: '<div id="header-button" class="container">\
				   <div id="header-controls">\
					  <div id="back" class="icon-fast-backward"></div>\
					  <div id="control" class="icon-play"></div>\
					  <div id="next" class="icon-fast-forward"></div>\
					  <div id="screen" class="icon-fullscreen"></div>\
				   </div>\
				 </div>'
	  },options);

	var interval;
	var activeContainer = 2;	
	var currentImg = 0;
	var started = false;
	var animating = false;
	var currentZindex = -1;

	var image_cache = [];
	
	$.bgimgSlideshow.preLoadImages = function(photoObjects) {
	  for(i in photoObjects){
		var cacheImage = document.createElement('img');
		cacheImage.src = photoObjects[i].image;
		image_cache.push(cacheImage);
		}
	}

	$.bgimgSlideshow.initialize = function() {
	  $(options.contDiv + ' #header-images').append(options.markup1);
	  $(options.contDiv).append(options.markup2);
	  // $.bgimgSlideshow.preLoadImages(options.photos);

	  // Backwards navigation
	  $('#back').click(function() {
		$.bgimgSlideshow.stopSlideshow();
		$.bgimgSlideshow.navigate('back');
	  });
	  
	  // Forward navigation
	  $('#next').click(function() {
		$.bgimgSlideshow.stopSlideshow();
		$.bgimgSlideshow.navigate('next');
	  });
	  
	  $('#control').click(function(){ 
		if(started)
			$.bgimgSlideshow.stopSlideshow();
		else
			$.bgimgSlideshow.startSlideshow();
	  });
	  $.bgimgSlideshow.startSlideshow();
	};

	$.bgimgSlideshow.navigate = function(direction) {
		// Check if no animation is running. If it is, prevent the action
		if(animating)
			return;
		
		// Check which current image we need to show
		if(direction == 'next') {
			currentImg++;
			if(currentImg == options.photos.length + 1)
				currentImg = 1;
		} else {
			currentImg--;
			if(currentImg == 0)
				currentImg = options.photos.length;
		}
		
		// Check which container we need to use
		var currentContainer = activeContainer;
		if(activeContainer == 1)
			activeContainer = 2;
		else
			activeContainer = 1;
		
		$.bgimgSlideshow.showImage((currentImg - 1), currentContainer, activeContainer);
	};

	$.bgimgSlideshow.showImage = function(numImg, currentContainer, activeContainer) {
	  var photoObject = options.photos[numImg];
		animating = true;
		
		// Make sure the new container is always on the background
		currentZindex--;
		
		// Set the background image of the new active container
		$('#header-img' + activeContainer).css({
			'background-image' : "url(" + photoObject.image + ")",
			'backgroundPosition' : "50% -" + photoObject.offset + "px",
			'display' : "block",
			'z-index' : currentZindex
		})
		// Set the rel value
		.attr("rel", photoObject.offset + ',' + photoObject.height );
		
		// Make sure the image position is set correctly
		$.bgimgSlideshow.bgPosImage(activeContainer);
		
		// Hide the header text
		//$("#header-caption").css({"display" : "none"});
		
		// Set the new header text
		$('#header-caption p a').attr('href', photoObject.url)
		$('#header-caption .cap-type').html(photoObject.type);
		$('#header-caption .cap-title').html(photoObject.title);

		// Make sure the containers switch places
		currentZindex++;
		
		// Fade out the current container
		// and display the header text when animation is complete
		$('#header-img' + currentContainer).css({
			'z-index' : currentZindex
		}).fadeOut(options.fadeSpeed,function() {
			setTimeout(function() {
				//$("#header-caption").css({"display" : "block"});
				animating = false;
			}, options.transition);
		});
	};

	// Custom bg-image position animation
	$.bgimgSlideshow.bgPosImage = function(activeContainer){
		var windowHeightNow = parseInt( $(window).height() ),
		    origHeight      = parseInt( $('#header').height() ),
		    image           = $('#header-img' + activeContainer),
		    imageWindow     = parseInt( image.height() ),
		    positions       = image.attr('rel').split(','),
		    factor          = 1,
		    y               = 0;
		
		// If admin-bar is active correct windowHeight for admin-bar's height
		if ( $('body').hasClass('admin-bar') ){ windowHeightNow -= parseInt( $('html').css('margin-top') ); }

		// How are we viewing the image?
		if ( origHeight == windowHeightNow && image.css('display') == 'block' && image.css('opacity') == '1' ){ // Image is viewed in full window

			// Center image vertically if image is bigger than viewport, else top it to the page
			y = ( ( positions[1] - windowHeightNow ) > 0 ) 
				? Math.abs( Math.ceil(( positions[1] - windowHeightNow ) / 2) )
				: 0;

			image.css({ 'backgroundPosition' : '50% -' + y + 'px' });
		}
		else { // Image is viewed in small window

			// Correct image size when viewport is smaller than 500px
			if ( origHeight < 500 ){
				factor = origHeight / 500;
				image.css({ 'background-size' : 'auto ' + factor * positions[1] + 'px' });
			}

			image.css({ 'backgroundPosition' : '50% -' + factor * positions[0] + 'px' });
		}
	}
	
	$.bgimgSlideshow.stopSlideshow = function() {
		// Change the background image to "play"
		$('#control').addClass('icon-pause');
		// Clear the interval
		clearInterval(interval);
		started = false;
	};

	$.bgimgSlideshow.startSlideshow = function() {
		$('#control').removeClass('icon-pause');
		$.bgimgSlideshow.navigate('next');
		interval = setInterval(function() { $.bgimgSlideshow.navigate('next'); }, options.slideshowSpeed);
		started = true;
	};

	// Added pause/play on hover caption	
	$('#header-caption a').hover(
		function(){
			$.bgimgSlideshow.stopSlideshow();
		}, function(){
			$.bgimgSlideshow.startSlideshow();
		}
	);

	$.bgimgSlideshow.initialize();
	return this;
	}

})(jQuery);


/**
 * 4.) jQuery extension :parents selector - http://stackoverflow.com/questions/965816/what-jquery-selector-excludes-items-with-a-parent-that-matches-a-given-selector
 * Author: Paolo Bergantino
 */
jQuery.expr[':'].parents = function(a,i,m){
    return jQuery(a).parents(m[3]).length < 1;
};
	