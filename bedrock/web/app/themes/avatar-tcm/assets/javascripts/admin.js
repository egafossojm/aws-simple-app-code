;(function ($) {

	/**
	 * MANAGE METABOX - "Articles - Main Sub-Category"
	 *
	 */

	// Main Variables
	var $metabox_main_subcategory = $('#acf-group_59303be8413b5'),
	$subcategory_select = $metabox_main_subcategory.find("select"),
	$metabox_categories = $("#categorydiv"),
	actual_main_subcategory_value,
	$subcategory_selected;


	/**
	 * On load
	 */
	// Move MetaBox "Articles - Main Sub-Category" just before native MetaBox "Categories"
	$metabox_categories.before( $metabox_main_subcategory );
	// Show or hide the listing of all categories
	show_hide_categories();


	/**
	 * On Change Main Sub-Category (select)
	 */
	$subcategory_select.change(function(){
		show_hide_categories();
		auto_select_checkbox();
	});


	/**
	 * On Change Categories (checkbox)
	 */
	$metabox_categories.on('change', "input", function(){
		auto_select_parent_cat($(this));
	});



	/**
	 * On Click "Publish" (validation)
	 */
	$("body.wp-admin.post-type-post #publish").on("click", function(){
		// Block if no Main Sub Category selected
		if( !$subcategory_select.val() ){
			$metabox_main_subcategory.find(".acf-error-message").remove();
			$subcategory_select.before('<div class="acf-error-message"><p>Please choose the main subcategory</p></div>');
			return false;
		}
	});


	/**
	 * In SCHEDULER NEWSLETTER (for sale coordinators), disabled the template select field
	 * so the sale coordinator does not mess with it...
	 * In order to add a new template, just remove the remove the HTML attribute 'disabled' on the select,
	 * so you can change it.
	 */
	$('.disabled-template [data-name="acf_newsletter_template"] select').attr("disabled", true);




	/**
	 * FUNCTIONS
	 */
	// Show or hide the categories listing
	function show_hide_categories() {
		actual_main_subcategory_value = $subcategory_select.val();

		// If a subcategory isnt selected yet
		if(actual_main_subcategory_value == ""){
			$metabox_categories.hide();

		// If a subcategory was already selected
		} else {
			$metabox_categories.show();
		}
	}

	// Auto select the checkbox depending of the main subcategory selected
	function auto_select_checkbox() {
		actual_main_subcategory_value = $subcategory_select.val();
		$subcategory_selected = $metabox_categories.find ("input[value='"+ actual_main_subcategory_value +"']");

		// If a subcategory was already selected
		if(!actual_main_subcategory_value == ""){
			$subcategory_selected.prop('checked', true);
			auto_select_parent_cat($subcategory_selected);
		}
	}

	// Auto select the parent category if a child is clicked
	function auto_select_parent_cat(elem) {
		// If the checkbox as been checked
		if(elem.is(":checked")){
			elem.parents("li").parents("li").children("label").children("input").prop('checked', true);
		}
	}


	/*
	 * Zoom help image
	 */
	$(".imgZoom")
		.css({
			"cursor"		: "zoom-in",
			"float"			: "left",
			"margin"		: "0 20px 0 0",
			"max-height"	: "20vw",
			"max-width"		: "20%",
			"transition"	: "all .4s ease-in-out"
		})
		.toggle(
			function(){
				$(this).css({
					"cursor"	: "zoom-out",
					"max-height": "100%",
					"max-width"	: "100%"
				})
			},
			function(){
				$(this).css({
					"cursor"	: "zoom-in",
					"max-height": "20vw",
					"max-width"	: "20%"
				})
			}
		)



	// Function to transform normale ACF description into tooltips
	// also used in change_template.js
	window.create_description_tooltips = function() {
		var i = 0;

		// Tranform descriptions in tooltips
		$('.acf-label > .description, .bg_gray > .acf-input').each(function(){
			// Variables
			var $this 		= $(this),
				description = $this.html();

			// Apply modifications
			//console.log("description '"+description +"'")
			if(description.trim() != "") {
				$this
					.after('<div href="#" class="tooltip"> ? <span>'+ description +'</span></div>')
					.remove();

				i++;
			}
		});
		// Return number of modification for change_template.js
		return i;
	}
	// Run this function once on page load
	create_description_tooltips();



	var avataradmin = {

		// Start Functions
		startAvatar: function() {
			avataradmin.NewsletterAvatar();
		},

		NewsletterAvatar: function() {
			// Newsletter articles
			jQuery('#newsletter_flexible_content').on('change', '.js_acf_newsletter_article select', function() {
				var post_id = jQuery(this); // get selected value
					$.post(
						avatar_admin_url.ajaxurl, {
							action: 'avatar-admin',
							newslatter_post_id: post_id.val(),
							nonce: avatar_admin_url.nonce,
							//dataType: 'json',
						}, function( response ) {

					var parent = post_id.closest('.acf-row');
					parent.find('.js_acf_newsletter_article_new_title input').val(response.title);
					parent.find('.js_acf_newsletter_article_excerpt textarea').val(response.excerpt);

				});

				return false;


			});

			// Newsletter Features
			jQuery('#newsletter_flexible_content').on('change', '.js_acf_newsletter_features_repeater select', function() {

				var post_id = jQuery(this); // get selected value
					$.post(
						avatar_admin_url.ajaxurl, {
							action: 'avatar-admin',
							newslatter_post_id: post_id.val(),
							nonce: avatar_admin_url.nonce,
						}, function( response ) {

					var parent = post_id.closest('.acf-row');
					parent.find('.js_acf_newsletter_new_feature_name input').val(response.title);
					parent.find('.js_acf_newsletter_feature_excerpt textarea').val(response.excerpt);

				});

				return false;

			});

			// Newsletter categories
			jQuery('#newsletter_flexible_content').on('change', '.js_acf_newsletter_category select', function() {
				var cat_str = jQuery(this).find(":selected"); // get selected value
				var parent = cat_str.closest('.acf-fields');

				parent.find('.js_acf_newsletter_new_category_name input').val(cat_str.text().replace(/(- )/g,''));

			});

		},
	};
	jQuery(document).ready(function() {
		avataradmin.startAvatar();
	});


})(jQuery);