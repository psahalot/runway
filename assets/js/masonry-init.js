/* 
 * Initialize Masonry JS 
 */

jQuery(function($) {
	var $container = $('.main-content');
 
	$container.imagesLoaded( function(){
		$container.masonry({
			itemSelector: '.hentry',
			isAnimated: true,
			gutterWidth: 40
		});
	});
});