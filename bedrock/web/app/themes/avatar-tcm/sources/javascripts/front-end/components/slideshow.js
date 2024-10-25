//Start the slidershow
$ = jQuery;
$('.modalAvatar').on('show.bs.modal', function(e) {
	var myVar;

	myVar = setInterval(createSlideshow, 325);

	var themeUrl = avatar_theme_url.theme_directory;
	var $slider_article = $(this).find(".bxslider_article");
	var $thumbnails = $(this).find(".slide-thumbnail");

	function refresh_ads() {
		var bigbox_slot = madops.getGPTSlotByElement(document.querySelector('.js_slideshow_bigbox'));
		var leaderboard_slot = madops.getGPTSlotByElement(document.querySelector('.js_slideshow_leaderboard'));
		googletag.pubads().refresh( [bigbox_slot, leaderboard_slot] );
	}

	$thumbnails.click(function (e) {
		refresh_ads();
	});

	function createSlideshow() {

		//console.log('state : initialization');

		// Main slider
		var slideshow = $slider_article.bxSlider({
			pagerCustom: '.bx-pager',
			controls: true,
			nextText: '<img src="' + themeUrl + '/assets/images/chevron-right.png"/>',
			prevText: '<img src="' + themeUrl + '/assets/images/chevron-left.png"/>',
			adaptiveHeight: true,
			onSliderLoad: function(){
			   clearInterval(myVar);
			},
			onSlideNext: function() {
				refresh_ads()
			},
			onSlidePrev: function() {
				refresh_ads()
			},



		});

		// Slider thumbnails
		var thumbnails = $thumbnails.bxSlider({
			pager: false,
			minSlides: 7,
			controls: true,
			maxSlides: 7,
			slideWidth: 100,
			slideMargin : 30,
			moveSlides: 1,
			speed: 1000,
			infiniteLoop: false,
			hideControlOnEnd: true,
			nextText: '<img src="' + themeUrl + '/assets/images/chevron-right.png"/>',
			prevText: '<img src="' + themeUrl + '/assets/images/chevron-left.png"/>',

		});
		// on resize (orentation change), destroy slider
		$(window).resize(function() {
			slideshow.destroySlider();
			slideshow.reloadSlider();
		});
	}

});