/*
 * Custom JavaScript
 */
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
/*
 * Konami-JS ~ 
 * :: Now with support for touch events and multiple instances for 
 * :: those situations that call for multiple easter eggs!
 * Code: https://github.com/snaptortoise/konami-js
 * Examples: http://www.snaptortoise.com/konami-js
 * Copyright (c) 2009 George Mandis (georgemandis.com, snaptortoise.com)
 * Version: 1.4.7 (3/2/2016)
 * Licensed under the MIT License (http://opensource.org/licenses/MIT)
 * Tested in: Safari 4+, Google Chrome 4+, Firefox 3+, IE7+, Mobile Safari 2.2.1 and Dolphin Browser
 */

var Konami = function (callback) {
	var konami = {
		addEvent: function (obj, type, fn, ref_obj) {
			if (obj.addEventListener)
				obj.addEventListener(type, fn, false);
			else if (obj.attachEvent) {
				// IE
				obj["e" + type + fn] = fn;
				obj[type + fn] = function () {
					obj["e" + type + fn](window.event, ref_obj);
				}
				obj.attachEvent("on" + type, obj[type + fn]);
			}
		},
		input: "",
		pattern: "38384040373937396665",
		load: function (link) {
			this.addEvent(document, "keydown", function (e, ref_obj) {
				if (ref_obj) konami = ref_obj; // IE
				konami.input += e ? e.keyCode : event.keyCode;
				if (konami.input.length > konami.pattern.length)
					konami.input = konami.input.substr((konami.input.length - konami.pattern.length));
				if (konami.input == konami.pattern) {
					konami.code(link);
					konami.input = "";
					e.preventDefault();
					return false;
				}
			}, this);
			this.iphone.load(link);
		},
		code: function (link) {
			window.location = link
		},
		iphone: {
			start_x: 0,
			start_y: 0,
			stop_x: 0,
			stop_y: 0,
			tap: false,
			capture: false,
			orig_keys: "",
			keys: ["UP", "UP", "DOWN", "DOWN", "LEFT", "RIGHT", "LEFT", "RIGHT", "TAP", "TAP"],
			input: [],
			code: function (link) {
				konami.code(link);
			},
			load: function (link) {
				this.orig_keys = this.keys;
				konami.addEvent(document, "touchmove", function (e) {
					if (e.touches.length == 1 && konami.iphone.capture == true) {
						var touch = e.touches[0];
						konami.iphone.stop_x = touch.pageX;
						konami.iphone.stop_y = touch.pageY;
						konami.iphone.tap = false;
						konami.iphone.capture = false;
					}
				});
				konami.addEvent(document, "touchend", function (evt) {
					konami.iphone.input.push(konami.iphone.check_direction());

					if (konami.iphone.input.length > konami.iphone.keys.length)
						konami.iphone.input.shift();

					if (konami.iphone.input.length === konami.iphone.keys.length) {
						var match = true;
						for (var i = 0; i < konami.iphone.keys.length; i++) {
							if (konami.iphone.input[i] !== konami.iphone.keys[i]) {
								match = false;
							}
						}
						if (match) {
							konami.iphone.code(link);
						}
					}
				}, false);
				konami.addEvent(document, "touchstart", function (evt) {
					konami.iphone.start_x = evt.changedTouches[0].pageX;
					konami.iphone.start_y = evt.changedTouches[0].pageY;
					konami.iphone.tap = true;
					konami.iphone.capture = true;
				});
			},
			check_direction: function () {
				x_magnitude = Math.abs(this.start_x - this.stop_x);
				y_magnitude = Math.abs(this.start_y - this.stop_y);
				x = ((this.start_x - this.stop_x) < 0) ? "RIGHT" : "LEFT";
				y = ((this.start_y - this.stop_y) < 0) ? "DOWN" : "UP";
				result = (x_magnitude > y_magnitude) ? x : y;
				result = (this.tap == true) ? "TAP" : result;
				return result;
			}
		}
	}

	typeof callback === "string" && konami.load(callback);
	if (typeof callback === "function") {
		konami.code = callback;
		konami.load();
	}

	return konami;
};


if (typeof module !== 'undefined' && typeof module.exports !== 'undefined') {
    module.exports = Konami;
} else {
    if (typeof define === 'function' && define.amd) {
        define([], function() {
            return Konami;
        });
    } else {
        window.Konami = Konami;
    }
}

$ = jQuery;
var speed = 300;
var easter_egg = new Konami(function() { 
	$(".leaderboard, .bigbox, [id^='adgear']").each(function(k, v){
		var el = this;
		setTimeout(function(){ 
			$(el).addClass("konami_falldown");
		}, k*speed);
		setTimeout(function(){ 
			$(el).hide();
		}, 4000);
	});
});

;
(function($) {
	//"use strict";

	var avatarie = {

		// Start Functions
		startAvatar: function() {
			avatarie.MenuSwipeAvatar();
			avatarie.DropdownHoverAvatar();
			avatarie.ShareButtonsAvatar();
			avatarie.SignInToggleAvatar();
			avatarie.ProfileFormAvatar();
			avatarie.NewspaperAvatar();
			avatarie.SearchBoxAvatar();
			//avatarie.M32AdTagsAvatar();
			avatarie.M32DispalyAds();
		},
		//Make sure Bootstrap menus can't be opened at the same time
		MenuSwipeAvatar: function() {

			jQuery('button').click( function(e) {
				jQuery('.collapse').collapse('hide');

			});

			jQuery('#button-menu-main-js').click( function(e) {
				if(jQuery('#menu-header-main .current-nav-parent').hasClass('mobile-open')){
					setTimeout(function(){//Default Bootstrap behavior counter : if click on button menu main add class Open for the current parent menu item
						jQuery('#menu-header-main .current-nav-parent').addClass("open");
						jQuery('#menu-header-main .current-nav-parent').removeClass('mobile-open');
					}, 90);
				}
			});

			jQuery('.user-form__radio-boolean-js').click( function(e) {
				jQuery('.collapse-radio').collapse('hide'); //close opened tab
				jQuery('input[name="licensed-to-sell"]').attr('checked', false); //set to unchecked any radio
			});
		},

		//Make sure on hover when a menu that has children the leaderboard M32 ads move to prevent overlapse.
		MenuHoverLeaderBoardAvatar: function(){
			if (jQuery(window).width() > 990) {
				jQuery(".menu-item-has-children").hover(function(){
					jQuery(".m32-stick").css('marginTop', '40px');
				}, function(){
					 jQuery(".m32-stick").css('marginTop', '0px');
				});
			}
		},
		DropdownHoverAvatar: function() {
			jQuery("#menu-header-main .dropdown-menu .open").addClass("active");
		},

		//Make sure there is only one drop down menu opened when hover
		DropdownHoverAvatar: function() {
			jQuery("#menu-header-main .dropdown-menu .open").addClass("active");
		},
		// Share buttons
		ShareButtonsAvatar: function () {
			jQuery( ".share-post" ).click(function() {
				window.open( jQuery(this).data("share-url"), "sharewin", "height=400,width=550,resizable=1,toolbar=0,menubar=0,status=0,location=0" ) ;
			});
		},
		// Events for sign in box
		SignInToggleAvatar: function(event){
			// Open Forgot Password Section
			jQuery( "#trigger-form-forgot" ).on( "click", function(event) {
				event.preventDefault ? event.preventDefault() : event.returnValue = false;
				 jQuery('#forgot-password-container').slideDown("slow", function(){
					 jQuery( "#user_login_forgot" ).focus();
				 });
				 jQuery('#sign-in-container').slideUp();
			});
			// Open Login Section
			jQuery( "#trigger-form-login" ).on( "click", function(event) {
				event.preventDefault ? event.preventDefault() : event.returnValue = false;
				jQuery('#sign-in-container').slideDown("slow",function(){
					jQuery( "#user_login" ).focus();
				});
				jQuery('#forgot-password-container').slideUp();
			});
			// On load, open Forgot Password section right away
			if(window.location.hash == "#f2"){
				jQuery( "#trigger-form-forgot" ).click();
			}
		},

		NewspaperAvatar: function() {
			jQuery("#js_newspaper_years").on('change', function() {
				jQuery('#js_newspaper_date_form').attr( 'action', '#' ); // no redirect url
				jQuery('.js_newspaper_btn').attr('disabled', 'disabled');
				jQuery('#js_newspaper_month').removeAttr('disabled');
				var year = jQuery(this);
				var newspaper = year.find(':selected').data('newspaper');
				var newspaper_type = jQuery('#newspaper_type').val();
				var newspaper_name = jQuery('#newspaper_name').val();
				var newspaper_cat_id = jQuery('#newspaper_cat_id').val();
				$.post( avatar_theme_url.ajaxurl, { action: 'avatar-main', newspaper: newspaper, newspaper_type: newspaper_type, newspaper_name: newspaper_name, newspaper_cat_id: newspaper_cat_id, nonce: avatar_theme_url.nonce, }, function( response ) {

					jQuery("#js_newspaper_month").html(response);

				});

				return false;
			});

			jQuery('#js_newspaper_month').on('change', function() {
				var url = jQuery(this).val(); // get selected value
				if (url) { // require a URL
					//jQuery('#newspaper_type').remove();
					//jQuery('#newspaper_cat_id').remove();
					jQuery('#js_newspaper_date_form').attr( 'action', url ); // redirect
					jQuery('.js_newspaper_btn').removeAttr('disabled');
				}
				return false;
			});
		},

		SearchBoxAvatar: function() {
			// Focus on search input field after collapse is opened
			jQuery('#search-box').on('shown.bs.collapse', function () {
				jQuery('.search-box__input').focus();
			});
		},

		M32AdTagsAvatar: function() {
			if( jQuery.isPlainObject(m32_context) ) {
				console.log(m32_context);
			}
		},

		M32DispalyAds: function() {
			var windowWidth = jQuery(window).width();

			if ( windowWidth < 768 ) {
				// single article
				jQuery( '.article-related' ).find( '.js_bigbox_aside' ).remove();
				var bigbox = jQuery( 'aside.primary' ).find( '.js_bigbox_primary' );
				bigbox.addClass( 'bigbox-content' );

				if( jQuery( '.article-body .row' ).find( 'p' ).length > 1 ) {
					bigbox.prependTo( '.article-body .row p:eq(2)' );
				} else{
					bigbox.appendTo( '.article-body  .row p' );
				}

				/*category page*/
				jQuery( '.homepage' ).find( '.bigbox' ).remove();

				/*slideshow*/
				jQuery( '.slideshow-bottom-ads' ).find( '.bigbox-slideshow' ).remove();
			}
		},

		//Events for profile account form
		ProfileFormAvatar: function(){
			//show container for state/province on selected countries
			jQuery("select#f_Country").load(function () {
				if( jQuery(this).val() == "Canada")
				{
					jQuery("#container_f_ProvinceState").slideDown();
				}
			});
			jQuery("select.js_ProvinceState").change(function () {
				var currentSelection = jQuery(this).val();
				jQuery("#f_ProvinceState").val(currentSelection);
			});
			jQuery("select#f_Country").change(function () {
				if( jQuery(this).val() == "Canada")
				{
					jQuery(".f_ProvinceState_US").val("");
					jQuery("#f_ProvinceState").val("");
					jQuery("#container_f_ProvinceState").slideDown();
					jQuery(".f_ProvinceState_CA").slideDown();
					jQuery(".f_ProvinceState_US").slideUp();
				}
				else if( jQuery(this).val() == "United States" || jQuery(this).val() == "États-Unis")
				{
					jQuery(".f_ProvinceState_CA").val("");
					jQuery("#f_ProvinceState").val("");
					jQuery("#container_f_ProvinceState").slideDown();
					jQuery(".f_ProvinceState_US").slideDown();
					jQuery(".f_ProvinceState_CA").slideUp();
				}
				else{
					jQuery(".f_ProvinceState_CA").val("");
					jQuery(".f_ProvinceState_US").val("");
					jQuery("#f_ProvinceState").val("");
					jQuery("#container_f_ProvinceState").slideUp();
					jQuery(".f_ProvinceState_CA").slideUp();
					jQuery(".f_ProvinceState_US").slideDown();
				}

			});
			//show container for primary occupation on selected option
			jQuery("select#f_PrimaryOccupation").change(function () {
			if( jQuery("option#other_f_PrimaryOccupation:selected").length )
				{
					jQuery("#container_f_PrimaryOccupation_Other").slideDown();}
				else{
					jQuery("#container_f_PrimaryOccupation_Other").slideUp();
				}
			});
			//show container for prof organizations on selected option
			jQuery("select#f_CompletedCourses").change(function () {
				if( jQuery("option#other_f_CompletedCourses:selected").length )
				{
					jQuery("#container_f_CompletedCourses_Other").slideDown();
				}
				else{
					jQuery("#container_f_CompletedCourses_Other").slideUp();
				}
			});
			//show container for prof designations on selected option
			jQuery("select#f_ProfOrganizations").change(function () {
				if( jQuery("option#other_f_ProfOrganizations:selected").length )
				{
					jQuery("#container_f_ProfOrganizations_Other").slideDown();
				}
				else{
					jQuery("#container_f_ProfOrganizations_Other").slideUp();
				}
			});
			//
			if (jQuery("#js_is_display_newspaper").length > 0) {
				// Newspaper register
				jQuery("#f_BusinessAddress, #f_City, #f_Country, #f_PostalCode, #f_Telephon").prop('required',true);
			}

			jQuery('#newspaper-yes-input').click( function(e) {
				// Standard register
				jQuery("#f_BusinessAddress, #f_City, #f_Country, #f_PostalCode, #f_Telephone").prop('required',this.checked);

			});

		}
	};
	jQuery(document).ready(function() {
		avatarie.startAvatar();
	});
})(jQuery);

$(document).ready(function () {
    $("#newsletter-yes-input").click(function (e) {
    	$('.newsletter-yes').prop('checked', true);
    });
});

$(document).ready(function () {
	$('input[type="radio"]').click(function(){
		  
		  if($(this).attr("value")=="Job Posting without Logo $600"){
		    $(".show-logo-posting").hide('slow');
		  }
		  if($(this).attr("value")=="Job Posting with Logo $700"){
		    $(".show-logo-posting").show('slow'); 

		  }        
		});
});

jQuery(document).ready(function() {

$(".keypop-trigger").popover({
	trigger: "manual",
	html: true,
	animation:false,
	container: '.article-body',
	placement: 'auto bottom',
	content: function () {
            var clone = $($(this).data('popover-content')).clone(true).removeClass('hide');
            return clone;
        }
	})
	.on("mouseenter", function () { 
		
        var _this = this;
        $(this).popover("show");
        $(".popover").on("mouseleave", function () {
            $(_this).popover('hide');
        });
    }).on("mouseleave", function () {
        var _this = this;
        setTimeout(function () {
            if (!$(".popover:hover").length) {
                $(_this).popover("hide");
            }
        }, 300);

	});

	$('.closepop').click ( function () {
			
			 $(this).closest('.popover').hide();
	});

	/*lazy load footer ad trigger*/
    //jQuery(window).scroll(function() {
	  // var hT = jQuery('#lazy-footer').offset().top,
	       //hH = jQuery('#lazy-footer').outerHeight(),
	       //wH = jQuery(window).height(),
	       //wS = jQuery(this).scrollTop();
		   //console.log((hT-wH) , wS);
		   	//if (wS > (hT+hH-wH)){
		     	//madops.addDynamicAd(document.querySelector('#lazy-footer'));
				//jQuery(window).off('scroll');
		   //}
	//});				
});
//(jQuery);

//
// Get the navbar
var navbar = document.getElementById("js-sticky-banner");
if (navbar) {
	//
	// When the user scrolls the page, execute myFunction
	window.onscroll = function() { addStickyNavbar() };
	// Get the offset position of the navbar
	var sticky = navbar.offsetTop + 200;
	// Add the sticky class to the navbar when you reach its scroll position. Remove "sticky" when you leave the scroll position
	function addStickyNavbar() {
		if (window.pageYOffset >= sticky) {
			navbar.classList.add("sticky-banner")
		} else {
			navbar.classList.remove("sticky-banner");
		}
	}
}
// Get the navbar in single posts
var navbar_single = document.getElementById("js-sticky-banner-single");
if (navbar_single) {
	//
	// When the user scrolls the page, execute myFunction
	window.onscroll = function() { addStickyNavbarSingle() };
	// Get the offset position of the navbar
	var sticky = navbar_single.offsetTop - 200;
	// Add the sticky class to the navbar when you reach its scroll position. Remove "sticky" when you leave the scroll position
	function addStickyNavbarSingle() {
		if (window.pageYOffset >= sticky) {
			navbar_single.classList.add("sticky-banner")
		} else {
			navbar_single.classList.remove("sticky-banner");
		}
	}
}
