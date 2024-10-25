//Infinite Ajax Scroll

$ = jQuery;
var ias = $.ias({
	container: "#js-regular-listing-container",
	item: ".js-regular-listing",
	pagination: ".pagination",
	next: ".pagination .next",
	delay: 0
});

ias.extension(new IASSpinnerExtension({
	src: translated_string.get_template_directory_uri + '/assets/images/load_more.svg'
}));

ias.extension(new IASTriggerExtension({
	text: translated_string.next_news
	//textPrev          : translated_string.previous_news  Not used at the time
}));

ias.extension(new IASPagingExtension());

ias.extension(new IASHistoryExtension({
	prev: '.prev'
}));

// Change the image for a svg so we can change color depending of setions
ias.on('next', function(url) {
	setTimeout(function() {
		var $img = $(".ias-spinner img");
		var imgURL = $img.attr('src');

		jQuery.get(imgURL, function(data) {
			// Get the SVG tag, ignore the rest
			var $svg = jQuery(data).find('svg');

			// Remove any invalid XML tags as per http://validator.w3.org
			$svg = $svg.removeAttr('xmlns:a');

			// Check if the viewport is set, if the viewport is not set the SVG wont't scale.
			if (!$svg.attr('viewBox') && $svg.attr('height') && $svg.attr('width')) {
				$svg.attr('viewBox', '0 0 ' + $svg.attr('height') + ' ' + $svg.attr('width'))
			}

			// Replace image with new SVG
			$img.replaceWith($svg);

		}, 'xml');

	}, 20);
});