function at_get_slideshow_values() {
	var data = {'action': 'at_get_slideshow'};

	var q = jQuery.ajax({
		type: 'POST',
		url: ajax_backend.ajax_url,
		data: data,
		async: false,
		dataType: 'json'
	});

	var values = q.responseJSON;
	return values;
}