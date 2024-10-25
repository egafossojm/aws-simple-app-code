/*
 * Custom JavaScript
 */
//= ../javascripts/front-end/components/infiniteajaxscroll.js
//= ../javascripts/front-end/components/slideshow.js
//= ../javascripts/front-end/components/konami.js

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