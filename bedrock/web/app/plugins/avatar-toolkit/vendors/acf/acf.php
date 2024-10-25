<?php
/* -------------------------------------------------------------
 * Save JSON files to upload folder
 * ============================================================*/

if (! function_exists('at_acf_json_save_point')) {
    /**
     * @return string
     */
    function at_acf_json_save_point($path_upload_acf)
    {

        // update path
        $path_upload = wp_upload_dir();
        $path_upload_acf = plugin_dir_path(__DIR__).'acf/acf-json';

        // return

        return $path_upload_acf;

    }

    add_filter('acf/settings/save_json', 'at_acf_json_save_point');
}

/* -------------------------------------------------------------
 * Load JSON files settings
 * ============================================================*/

if (! function_exists('at_acf_json_load_point')) {
    /**
     * @return array
     */
    function at_acf_json_load_point($path_upload_acf)
    {

        // remove original path
        unset($path_upload_acf[0]);

        $path_upload = wp_upload_dir();
        $path_upload_acf[] = plugin_dir_path(__DIR__).'acf/acf-json';

        // return
        return $path_upload_acf;
    }

    add_filter('acf/settings/load_json', 'at_acf_json_load_point');
}

/* -------------------------------------------------------------
 * Customize admin article edit page
 * Use native 'Exerpt', 'Feature Image' and 'Content Editor'
 * ============================================================*/

if (! function_exists('at_acf_admin_head')) {
    /**
     * Mod: design of metabox in admin
     */
    function at_acf_admin_head()
    { ?>
		<script type="text/javascript">
		(function($) {
			$(document).ready(function(){
				/* Move the default WP WYSIWYG to the tab "TEXT" */
				$('#wp_wysiwyg .acf-input').append( $('#postdivrich') );
				/* Move the default WP Excerpt to the tab "TEXT" */
				$('#wp_excerpt .acf-input').append( $('#postexcerpt') );
				/* Move the default Featured Image to the tab "MEDIAS / Image" */
				$('#acf_article_img .acf-input').append( $('#postimagediv') );
				/* Move the default Featured Image to the tab "MEDIAS / Image" */
				$('#acf_author_featured_img .acf-input').append( $('#postimagediv') );
				if( $('#wpseo_meta').length ) {
					$('.post-php .wpseo-metabox').addClass('closed');
				}

			});
		})(jQuery);
		</script>
		<style type="text/css">
			.acf-field #wp-content-editor-tools {
				background: transparent;
				padding-top: 0;
			}
		</style>
		<?php
    }
    add_action('acf/input/admin_head', 'at_acf_admin_head');
}

/* -------------------------------------------------------------
 * Filter to customize the category behavior
 * ============================================================*/

if (! function_exists('at_acf_load_custom_subcat_choices')) {
    /**
     * @return mixed
     */
    function at_acf_load_custom_subcat_choices($field)
    {

        global $pagenow;
        $screen = get_current_screen();

        if (($pagenow === 'post.php' or $pagenow === 'post-new.php') && 'post' === (isset($_GET['post']) ? get_post_type($_GET['post']) : get_post_type())) {
            // reset choices
            $field['choices'] = [];

            // Get all categories
            $args = [
                'hide_empty' => 0,
                'type' => 'post',
                'orderby' => 'name',
                'order' => 'ASC',
            ];
            $categories = get_categories($args);

            $field['choices'][''] = 'Choose the main sub-category';

            // Loop through parent categories
            foreach ($categories as $category_parent) {
                if ($category_parent->parent == 0) {
                    // <Optgroup>
                    $field['choices'][$category_parent->name] = [];

                    // Loop through children categories
                    foreach ($categories as $subcategory) {
                        if ($subcategory->parent == $category_parent->term_id) {
                            // <select>
                            $field['choices'][$category_parent->name][$subcategory->cat_ID] = $subcategory->name;

                            // Loop through children-children categories
                            foreach ($categories as $subsubcategory) {
                                if ($subsubcategory->parent == $subcategory->term_id) {
                                    // <select>
                                    $field['choices'][$category_parent->name][$subsubcategory->cat_ID] = $subsubcategory->name;
                                }
                            }

                        }
                    }
                }
            }

        }

        return $field;
    }
    if (is_admin()) {
        add_filter('acf/load_field/name=article_side_main_subcategory', 'at_acf_load_custom_subcat_choices');
    }
}

/* -------------------------------------------------------------
 * Filter to order articles by date (DESC)
 * ============================================================*/

if (! function_exists('at_acf_change_posts_order')) {
    /**
     * Change the order of posts in ACF
     *
     * @param  $args  for query
     * @return mixed $args
     */
    function at_acf_change_posts_order($args)
    {
        $args['orderby'] = 'date';
        $args['order'] = 'DESC';

        return $args;
    }
    add_filter('acf/fields/post_object/query', 'at_acf_change_posts_order');
}

/* -------------------------------------------------------------
 * Filter to add sponsor type to sponsor name
 * ============================================================*/

if (! function_exists('at_sponsor_post_object_result')) {

    function at_sponsor_post_object_result($title, $term, $field, $post_id)
    {

        // add the term's slug to each result
        $sponsor_type = get_field('acf_sponsor_type', 'post_sponsor'.'_'.$term->term_id);

        if (! empty($sponsor_type)) {
            $sponsor_type_parts = explode(':', $sponsor_type);
            $title .= ' ( '.$sponsor_type_parts[0].' )';
        }

        return $title;

    }
}

add_filter('acf/fields/taxonomy/result/name=acf_article_sponsor', 'at_sponsor_post_object_result', 10, 4);
add_filter('acf/fields/taxonomy/result/name=acf_category_sponsor', 'at_sponsor_post_object_result', 10, 4);
add_filter('acf/fields/taxonomy/result/name=acf_keyword_sponsor', 'at_sponsor_post_object_result', 10, 4);

/* -------------------------------------------------------------
 * Filter to add author type to author name
 * ============================================================*/

if (! function_exists('at_author_post_object_result')) {

    function at_author_post_object_result($title, $term, $fie4ld, $post)
    {

        $author_is_columnist = get_field('acf_author_is_columnist', $term);

        if ($author_is_columnist) {
            $column = get_field('acf_wp_all_import_column_value', $term);
            error_log('--'.$column);
            $title .= ' ( Columnist -- '.$column.' )';
        }

        return $title;
    }
}

add_filter('acf/fields/post_object/result/name=acf_article_author', 'at_author_post_object_result', 10, 4);

function ac_my_acf_column_value_example($value, $id, $column)
{
    if ($column instanceof ACA_ACF_Column_Post) {
        $meta_key = $column->get_meta_key(); // This gets the ACF field key
        if ($meta_key == 'acf_article_author') {
            $author = get_field('acf_article_author', $id);
            $is_columnist = get_field('acf_author_is_columnist', $author[0]);
            if ($is_columnist) {
                return $value.' (columnist)';
            }

        }
    }

    return $value;
}

add_filter('ac/column/value', 'ac_my_acf_column_value_example', 10, 3);

?>