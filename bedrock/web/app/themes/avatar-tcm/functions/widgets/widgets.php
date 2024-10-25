<?php
/* -------------------------------------------------------------
 *  Register our sidebars and widgetized areas.
 * ============================================================*/
if (! function_exists('avatar_widgets_initialisation')) {
    function avatar_widgets_initialisation()
    {
        $before_widget = '';
        $after_widget = '';
        $before_title = "<div class='heading_footer'><span>";
        $after_title = '</span></div>';

        // Footer row 1
        for ($i = 1; $i < 5; $i++) {
            register_sidebar([
                'name' => sprintf(__('Footer column %1$s | row 1', 'avatar-tcm'), $i),
                'id' => 'footer_col_'.$i.'_row_1',
                'before_widget' => $before_widget,
                'after_widget' => $after_widget,
                'before_title' => $before_title,
                'after_title' => $after_title,
            ]);
        }
        // Footer row 2
        for ($i = 1; $i < 5; $i++) {
            register_sidebar([
                'name' => sprintf(__('Footer column %1$s | row 2', 'avatar-tcm'), $i),
                'id' => 'footer_col_'.$i.'_row_2',
                'before_widget' => $before_widget,
                'after_widget' => $after_widget,
                'before_title' => $before_title,
                'after_title' => $after_title,
            ]);
        }
        for ($i = 1; $i < 2; $i++) {
            register_sidebar([
                'name' => sprintf(__('Footer column 5 | row %1$s', 'avatar-tcm'), $i),
                'id' => 'footer_col_5_row_'.$i,
                'before_widget' => $before_widget,
                'after_widget' => $after_widget,
                'before_title' => $before_title,
                'after_title' => $after_title,
            ]);
        }
        // More menu in Footer
        register_sidebar([
            'name' => __('Footer more', 'avatar-tcm'),
            'id' => 'footer_more',
            'before_widget' => '',
            'after_widget' => '',
            'before_title' => '',
            'after_title' => '',
        ]);
        // Copyright in Footer
        for ($i = 1; $i < 3; $i++) {
            register_sidebar([
                'name' => sprintf(__('Copyright column %1$s', 'avatar-tcm'), $i),
                'id' => 'copyright_col_'.$i,
                'before_widget' => $before_widget,
                'after_widget' => $after_widget,
                'before_title' => $before_title,
                'after_title' => $after_title,
            ]);
        }

    }
    add_action('widgets_init', 'avatar_widgets_initialisation');
}
