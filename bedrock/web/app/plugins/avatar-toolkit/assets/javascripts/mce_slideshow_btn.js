(function () {
	tinymce.PluginManager.add('at_add_shortcode_button', function (editor, url) {
		editor.addButton('at_add_shortcode_button', {
			title: 'Add slideshow',
			icon: 'wp-media-library',
			onclick: function () {
				// Open window
				editor.windowManager.open({
					title: 'Add slideshow shortcode',
					body: [{
						type: 'listbox',
						name: 'slideshow',
						label: 'Select Slideshow',
						values: at_get_slideshow_values()
					}],
					onsubmit: function (e) {
						// Insert content when the window form is submitted
						editor.insertContent('[slideshow id="' + e.data.slideshow + '"]');
					},
					width: 500,
					height: 100
				});
			}
		});
	});

})();