;
//
(function() {

    // Read Also Botton for MCE Visual Editor
    tinymce.PluginManager.add( 'avatar_read_also_btn', function( editor, url ) {
        // Add Button to Visual Editor Toolbar
        editor.addButton('avatar_read_also_btn', {
            title: 'Also Read',
            cmd: 'columns',
            image: url + '/../images/mce_read_also.png',
        });

        editor.addCommand('columns', function() {
            var selected_text = editor.selection.getContent({
                'format': 'html'
            });
            if ( selected_text.length === 0 ) {
                alert( 'Please select some text.' );
                return;
            }
            var open_column = '<div class="avatar-also_read">';
			var theLabel = '<div class="avatar-also_read__link-label avatar-also_read__link-label--color">Also read</div><div>';
            var close_column = '</div></div>';
            var return_text = '';
            return_text = open_column + theLabel + selected_text + close_column;
            editor.execCommand('mceReplaceContent', false, return_text);
            return;
        });
    });

    //next one :)
})();