 <?php
/**
* Template Name: DEV_publish_all_articles_in_categories
*
* This is the template only used to AUTO PUBLISHED all articles in a specific category
*
* @link https://codex.wordpress.org/Template_Hierarchy
* @since 1.0.0
*
* @version 1.0.0
*/

/* -------------------------------------------------------------
 * Update all category articles (category_sub_cat_order)
 * ============================================================*/

remove_role('supereditor');
remove_role('webeditor');
if (isset($_GET['category_name'])) {

    // Set some variables
    $articles_with_links_in_content = [];
    $count_articles_with_links = 0;
    $count_links = 0;

    $query = [
        'post_type' => 'post',
        'category_name' => $_GET['category_name'],
        'posts_per_page' => -1,
        //'offset'			=> 10,
        'post_status' => 'publish',
    ];
    $loop = new WP_Query($query);

    while ($loop->have_posts()) {
        $loop->the_post();
        // Variables
        //------------------------------------------------
        $video_media_unchecked = 'false';
        $content = get_the_content(true);

        // 1- Treat Content in order to be happy :D
        //------------------------------------------------

        // Remove white spaces at the begining and the end of content
        $my_new_content = trim($content);

        // Unchecked 'Video' if no Brighcove ID
        if (is_array(get_field('acf_article_media', get_the_ID()))
            && in_array('video', get_field('acf_article_media', get_the_ID()))
            && trim(get_field('acf_article_video', get_the_ID())) == '') {
            // Array of media
            $media_with_video = get_field('acf_article_media', get_the_ID());
            // Index of video in array
            $video_index_inarray = array_search('video', $media_with_video);
            //remove video from array
            $media_without_video = array_splice($media_with_video, $video_index_inarray + 1);
            // Update ACF field
            update_field('acf_article_media', $media_without_video, get_the_ID());
            $video_media_unchecked = 'true';
        }

        // Restore authors list from wp all import string value
        $authors_id = [];
        $wp_all_import_authors = get_field('acf_wp_all_import_author_name', get_the_ID());
        if (! is_empty($wp_all_import_authors)) {
            $authors = explode(',', $wp_all_import_authors);
            if (count($authors) > 1) {
                foreach ($authors as $author) {
                    $obj_authors_id_register = get_page_by_title($author, 'OBJECT', 'writer');
                    array_push($authors_id, $obj_authors_id_register->ID);
                }
                update_field('acf_article_author', $authors_id, get_the_ID());

            }
        }

        // 2- Update New content to concretize happinness!
        //------------------------------------------------------
        wp_update_post(
            [
                'ID' => get_the_ID(),
                'post_content' => $my_new_content,
            ]
        );

        // 3- Set Main-Sub Categories for articles of columnist (Inside Track)
        //------------------------------------------------------
        if ($_GET['category_name'] == 'inside-track_') {
            foreach (get_the_category() as $value) {
                if ($value->slug != 'inside-track_') {
                    update_field('article_side_main_subcategory', $value->term_id, get_the_ID());
                    update_field('_yoast_wpseo_primary_category', $value->term_id, get_the_ID());
                }
            }
        }

        // 4- Print or get some info!
        //------------------------------------------------------
        $doc = new DOMDocument('1.0', 'UTF-8');
        $fragment = $doc->createDocumentFragment();
        $fragment->appendXML($content);
        $doc->appendChild($fragment);
        $links_extracted = $doc->getElementsByTagName('a');

        // Detect links
        if ($links_extracted->length > 0) {
            $links_in_article = [];

            // Construct array of links
            foreach ($links_extracted as $link_extracted) {
                array_push($links_in_article, $link_extracted->getAttribute('href'));
                $count_links++;
            }

            $articles_with_links_in_content[] = [
                'id' => get_the_ID(),
                'title' => get_the_title(),
                'links' => $links_in_article,
            ];

            $count_articles_with_links++;

        }

        /*print_r('<pre>');
        print_r( '<b>'. get_the_ID() .' -> '. get_the_title() .'</b>');
        print_r( '<br>' );
        print_r( '<b>Media Video unchecked:</b> '. $video_media_unchecked );
        print_r( '<br><br>' );
        print_r('</pre>');*/

    }
    wp_reset_postdata();

    echo '<h1>Summary in "'.$_GET['category_name'].'"</h1>';

    /*echo '<h2>ARTICLE AVEC PDF</h2>';
    print_r('<pre>');
    print_r($articles_with_pdf_in_content);
    print_r('</pre>');*/

    echo '<h2>ARTICLES AVEC LIENS</h2>';
    echo '<h4>Il y a '.$count_links.' liens dans '.$count_articles_with_links.' / '.$loop->found_posts.' articles.</h4>';
    print_r('<pre>');
    print_r($articles_with_links_in_content);
    print_r('</pre>');

    echo '<br /><hr /><hr /><hr /><br /><br /><br />';

} // endif $_GET

/* -------------------------------------------------------------
 * Display all categories
 * ============================================================*/
?>
<body>
	<div style="height:100%; overflow:scroll; position:fixed; width:100%;">
		<img src="http://www.freeiconspng.com/uploads/duck-png-16.png" style="float:left; width:200px;">
		<h1>28 - Process articles after Import (from a specific category)! <br />Koinkoin!</h1>
		<ul>   
			<?php
                $get_parent_cats = [
                    'parent' => '0', //get top level categories only
                ];
$all_categories = get_categories($get_parent_cats); //get parent categories

foreach ($all_categories as $single_category) {
    //for each category, get the ID
    $catID = $single_category->cat_ID;

    echo '<li><b><a href="?category_name='.$single_category->slug.' ">'.$single_category->name.'</a></b>'; //category name & link
    $get_children_cats = [
        'child_of' => $catID, //get children of this parent using the catID variable from earlier
    ];

    $child_cats = get_categories($get_children_cats); //get children of parent category
    echo '<ul>';
    foreach ($child_cats as $child_cat) {
        //for each child category, get the ID
        $childID = $child_cat->cat_ID;

        //for each child category, give us the link and name
        echo '<li><a href="?category_name='.$child_cat->slug.' ">'.$child_cat->name.'</a></li>';

    }
    echo '</ul><br /><br /></li>';
} //end of categories logic?>
		</ul><!--end of category-sidebar-->
	</div>
	<div style="background-image:url(https://img00.deviantart.net/dea2/i/2014/052/5/0/duck_in_the_dark_by_wulliedrodger-d77etyl.jpg); bottom:0; left:0; margin:auto; opacity:0.2; position:absolute; right:0; top:0; width:100%; z-index:-1;"></div>
</body>
