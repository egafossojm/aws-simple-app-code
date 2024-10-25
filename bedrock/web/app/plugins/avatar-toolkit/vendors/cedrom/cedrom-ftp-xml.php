<?php
class AT_Cedrom_FTP_XML_Import
{
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

    /**
     * Start up
     */
    public function __construct()
    {
        add_action('admin_menu', [$this, 'at_cedrom_add_plugin_page']);
        add_action('admin_init', [$this, 'at_cedrom_page_init']);
    }

    /**
     * Add options page
     */
    public function at_cedrom_add_plugin_page()
    {
        // This page will be under "Settings"
        add_options_page(
            __('Settings Admin', 'avatar-toolkit'),
            __('Import XML News', 'avatar-toolkit'),
            'webeditor',
            'at_cedrom_ftp_xml_2_post',
            [$this, 'at_cedrom_create_admin_page']
        );
    }

    /**
     * Options page callback
     */
    public function at_cedrom_create_admin_page()
    {
        // Set class property
        $this_options = get_option('at_cedrom_ftp_xml_2_post_option_name');
        ?>
		<div class="wrap">
			<h1><?php _e('Import XML News', 'avatar-toolkit'); ?></h1>
			<h2><?php _e('Click the "Import" button to trigger the process. The following actions will happen:', 'avatar-toolkit'); ?></h2>
			<ol type="1">
				<li><?php _e('Connection to CEDROM-SNI\'s FTP,', 'avatar-toolkit'); ?></li>
				<li><?php _e('Copy of the XML files,', 'avatar-toolkit'); ?></li>
				<li><?php _e('Creation of a Newspaper Date,', 'avatar-toolkit'); ?></li>
				<li><?php _e('Import the XML News from within the copied files.', 'avatar-toolkit'); ?></li>
			</ol>

			<form method="post" action="options.php">
			<?php
                // This prints out all hidden setting fields
                settings_fields('at_cedrom_ftp_xml_2_post_option_group');
        do_settings_sections('at_cedrom_ftp_xml_2_post');
        submit_button($text = __('Import', 'avatar-toolkit'));
        ?>
			</form>
		</div>
		<?php
    }

    /**
     * Register and add settings
     */
    public function at_cedrom_page_init()
    {
        register_setting(
            'at_cedrom_ftp_xml_2_post_option_group', // Option group
            'at_cedrom_ftp_xml_2_post_option_name', // Option name
            [$this, 'sanitize'] // Sanitize
        );
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param  array  $input  Contains all settings fields as array keys
     */
    public function sanitize($input)
    {

        if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'update') {
            if ($this->at_cedrom_copy_from_ftp()) {
                $this->at_import_xml_content();
            }
        }

    }

    /**
     * Get the Base Upload Folder
     *
     * @return mixed
     */
    public function at_get_base_upload_dir()
    {
        $ud = wp_upload_dir();

        return $ud['basedir'];
    }

    /**
     * Import News from XML files
     */
    public function at_import_xml_content()
    {

        // Test if folder exist
        $xml_dir = $this->at_get_base_upload_dir().'/cedrom-sni/'.date('Y_m_d').'/';
        if (is_dir($xml_dir)) {

            $post_imported = 0;
            $xml_files = array_reverse(glob($xml_dir.'*.xml', GLOB_MARK | GLOB_NOSORT));

            foreach ($xml_files as $key => $file) {

                $file_content = file_get_contents($file);
                $file_content = str_replace('xmlns=', 'ns=', $file_content);
                $simplexml = simplexml_load_string($file_content);

                $xml_id = $simplexml->xpath('//head/docdata/doc-id/@id-string') ? str_replace('·', '', (string) ($simplexml->xpath('//head/docdata/doc-id/@id-string')[0])) : false;
                $xml_date = $simplexml->xpath('//head/pubdata/@date.publication') ? strtotime((string) ($simplexml->xpath('//head/pubdata/@date.publication')[0])) : false;
                $xml_cat = $simplexml->xpath('//head/pubdata/@position.section') ? (string) ($simplexml->xpath('//head/pubdata/@position.section')[0]) : false;
                $xml_company = $simplexml->xpath('//head/pubdata/@name') ? (string) ($simplexml->xpath('//head/pubdata/@name')[0]) : false;
                $xml_title = $simplexml->xpath('//body/body.head/hedline/hl1') ? (string) $simplexml->xpath('//body/body.head/hedline/hl1')[0] : '';
                $xml_excerp = $simplexml->xpath('//body/body.head/hedline/hl2') ? (string) $simplexml->xpath('//body/body.head/hedline/hl2')[0] : '';

                $xml_authors = $simplexml->xpath('//body/body.head/byline/person') ? $simplexml->xpath('//body/body.head/byline/person') : false;
                if (is_array($xml_authors)) {
                    $k = 0;
                    $xml_author = [];
                    foreach ($xml_authors as $author) {
                        $xml_author[$k++] = (string) trim($author);
                    }
                }

                $xml_contents = $simplexml->xpath('//block/p') ? $simplexml->xpath('//block/p') : false;
                $xml_content = '';
                foreach ($simplexml->xpath('//block/p') as $j => $value_p) {
                    $xml_content .= $value_p->asXML();
                }

                // $xml_images	 	= $simplexml->xpath( "//media[@media-type='image']") ? $simplexml->xpath( "//media[@media-type='image']") : false;
                // if ( is_array( $xml_images ) ) {
                // 	$k = 0;
                // 	$xml_image = array();
                // 	foreach ($xml_images as $value) {
                // 		$xml_image[$k]['reference'] = (string)$value->{'media-reference'};
                // 		$xml_image[$k++]['producer'] = (string)$value->{'media-producer'};
                // 	}
                // }

                // Create Custom Post Type 'Nespaper Date'
                if ($key == 0) {

                    // Test if CPT exist
                    $args_cpt_bi = [
                        'post_type' => 'newspaper',
                        'meta_key' => 'avatar_cedrom_id',
                        'meta_value' => $xml_id,
                        'posts_per_page' => 1,
                        'no_found_rows' => true,
                        'fields' => 'ids',
                    ];
                    $query_cpt_bi = new WP_Query($args_cpt_bi);

                    $bi_cpt_id = $query_cpt_bi->posts[0] ? $query_cpt_bi->posts[0] : false;

                    $bi_title = (date('j', $xml_date) >= 15) ? 'Mid-'.date('F Y', $xml_date) : date('F Y', $xml_date);

                    if (! $bi_cpt_id) {
                        // Create new CPT newspaper date

                        $bi_defaults_cpt = [
                            'post_title' => $bi_title,
                            'post_status' => 'draft',
                            'post_type' => 'newspaper',
                            'post_date' => date('Y-m-d H:i:s', $xml_date),
                            'post_date_gmt' => date('Y-m-d H:i:s', $xml_date),
                            'meta_input' => [
                                'avatar_cedrom_id' => $xml_id,
                            ],
                        ];
                        $bi_cpt_id = wp_insert_post($bi_defaults_cpt);
                        if ($bi_cpt_id) {
                            add_settings_error('at_message_xmlftp_id', '', __('The newspaper date titled '.$bi_title.' was successfully created.', 'avatar-toolkit'), 'updated');
                        } else {
                            add_settings_error('at_message_xmlftp_id', '', __('Error importing Newspaper date titled '.$bi_title, 'avatar-toolkit'));
                        }
                    }
                }

                // Import all news from XML file

                // Test if the post exist
                $args_post_bi = [
                    'post_type' => 'post',
                    'meta_key' => 'avatar_cedrom_id',
                    'meta_value' => $xml_id,
                    'posts_per_page' => 1,
                    'no_found_rows' => true,
                    'fields' => 'ids',
                ];
                $query_post_bi = new WP_Query($args_post_bi);

                $bi_post_id = $query_post_bi->posts[0] ? $query_post_bi->posts[0] : false;

                if (! $bi_post_id) {
                    $xml_date_p = $xml_date + ($key * 60);
                    $xml_cat_id = $this->at_get_add_bi_category(trim($xml_cat));
                    $bi_defaults_post = [
                        'post_title' => $xml_title,
                        'post_status' => 'draft',
                        'post_type' => 'post',
                        'post_date' => date('Y-m-d H:i:s', $xml_date_p),
                        'post_date_gmt' => date('Y-m-d H:i:s', $xml_date_p),
                        'post_content' => $xml_content,
                        'post_excerpt' => $xml_excerp,
                        'post_category' => $xml_cat_id,
                        'meta_input' => [
                            'avatar_cedrom_id' => $xml_id,
                            'acf_article_source' => $xml_company,
                            'acf_article_newspaper' => $bi_cpt_id,
                            'article_side_main_subcategory' => $xml_cat_id[0],
                            '_yoast_wpseo_primary_category' => $xml_cat_id[0],
                        ],
                    ];
                    $bi_post_id = wp_insert_post($bi_defaults_post);
                    if ($bi_post_id) {
                        $post_imported++;
                        $authors_ids = [];
                        foreach ($xml_author as $key_xml_author => $value_xml_author) {
                            $authors_ids[] = $this->at_get_add_bi_author(trim($value_xml_author));
                        }
                        update_post_meta($bi_post_id, 'acf_article_author', $authors_ids);
                        add_settings_error('at_message_xmlftp_id', '', __('Article <a href="'.get_edit_post_link($id = $bi_post_id).'" title="Edit this article" target="_blank">'.get_the_title($bi_post_id).'</a> was imported. ', 'avatar-toolkit'), 'updated');
                    } else {
                        add_settings_error('at_message_xmlftp_id', '', __('Error importing article with following XML ID '.$xml_id, 'avatar-toolkit'));
                    }
                }
                //delete file please
                unlink($file);
            }

            if ($post_imported) {
                add_settings_error('at_message_xmlftp_id', '', sprintf(_n('The %s article was imported.', 'The %s articles were imported.', $post_imported, 'avatar-toolkit'), $post_imported), 'updated');
            } else {

                add_settings_error('at_message_xmlftp_id', '', __('Articles already in database. Previously imported articles and/or related Newspaper Date '.$bi_title.' must be deleted prior to reimport.', 'avatar-toolkit'));
            }
            // wp_die( 'stop test' );
        } else {
            add_settings_error('at_message_xmlftp_id', '', __('Error creating folder '.('/cedrom-sni/'.date('Y_m_d')), 'avatar-toolkit'));
        }

    }

    /**
     * Get category ID by name, if doesn't exist create the category
     *
     * @return int|WP_Error
     */
    public function at_get_add_bi_category($cat_name)
    {

        if ($main_cat_id = get_field('acf_newspaper_main_cat', 'option')) {

            //test if category name exist
            $sub_cat_id = get_cat_ID($cat_name);
            $category = get_term($sub_cat_id, 'category');
            if ($sub_cat_id && $category->parent == $main_cat_id) {
                $sub_bi_cat_id[] = $sub_cat_id;
            } else {
                $sub_bi_cat_id[] = wp_create_category($cat_name, $main_cat_id);
            }
        } else {
            add_settings_error('at_message_xmlftp_id', '', __('Select a main category from the Theme Options (Newspaper tab).', 'avatar-toolkit'));
        }
        $sub_bi_cat_id[] = $main_cat_id;

        return $sub_bi_cat_id;
    }

    /**
     * Get author ID by title, if doesn't exist create new author
     *
     * @return int|WP_Error
     */
    public function at_get_add_bi_author($author_name)
    {

        $obj_author_by_name = get_page_by_title($author_name, 'OBJECT', 'writer');

        if ($obj_author_by_name == null) {
            // author dosent exist, create new and get ID
            $author_bi_id = wp_insert_post(['post_title' => $author_name, 'post_type' => 'writer', 'post_status' => 'publish']);
        } else {
            // author exist
            $author_bi_id = $obj_author_by_name->ID;
        }

        return $author_bi_id;

    }

    /**
     * Copy all files (xml and images) from FTP to our local directory
     *
     * @return bool
     */
    public function at_cedrom_copy_from_ftp()
    {

        // FTP connection details
        $ftp_host = get_field('acf_cedrom_host', 'option');
        $ftp_user = get_field('acf_cedrom_user', 'option');
        $ftp_pass = get_field('acf_cedrom_pass', 'option');
        $ftp_path = get_field('acf_cedrom_path', 'option');

        // Create cedrom-sni folder if dosent exist
        $to_dir = wp_mkdir_p($this->at_get_base_upload_dir().'/cedrom-sni/'.date('Y_m_d'));

        if ($ftp_host && $ftp_user && $ftp_pass && $ftp_path) {

            //Include FTP WordPress class
            require_once ABSPATH.'wp-admin/includes/class-ftp.php';

            $ftp = new ftp(false);
            // for testing only
            // $ftp->Verbose = false;
            // $ftp->LocalEcho = false;

            // Connect to FTP server
            if (! $ftp->SetServer($ftp_host)) {
                $ftp->quit();
                add_settings_error('at_message_xmlftp_id', '', __('Cannot connect to '.$ftp_host.' host.', 'avatar-toolkit'));

                return;
            }

            if (! $ftp->connect()) {
                add_settings_error('at_message_xmlftp_id', '', __('Cannot connect to FTP.', 'avatar-toolkit'));

                return;
            }
            if (! $ftp->login($ftp_user, $ftp_pass)) {
                $ftp->quit();
                add_settings_error('at_message_xmlftp_id', '', __('Cannot connect to FTP : wrong login info.', 'avatar-toolkit'));

                return;
            }

            if (! $ftp->SetType(FTP_AUTOASCII)) {
                add_settings_error('at_message_xmlftp_id', '', __('Cannot set FTP type to "AUTOASCII".', 'avatar-toolkit'));
            }

            if (! $ftp->Passive(true)) {
                add_settings_error('at_message_xmlftp_id', '', __('Cannot connect to FTP in passive mode.', 'avatar-toolkit'));
            }
            // go to our folder
            if ($ftp->chdir($ftp_path)) {

                $ftp->nlist('-la');
                $list = $ftp->nlist();

                if ($list === false) {
                    add_settings_error('at_message_xmlftp_id', '', __('Can\'t get the list of files in CEDROM-SNI folder.', 'avatar-toolkit'));
                } else {
                    $nr_xml_files = 0;
                    foreach ($list as $k => $v) {
                        if ($ftp->get($v, $this->at_get_base_upload_dir().'/cedrom-sni/'.date('Y_m_d').'/'.$v) !== false) {
                            $nr_xml_files++;
                            // for debug only
                            //error_log( $v." has been downloaded." );
                        } else {
                            $ftp->quit();
                            add_settings_error('at_message_xmlftp_id', '', __('Error copying the files from CEDROM-SNI\'s FTP.', 'avatar-toolkit'));
                        }
                    }
                }
                // All done, close FTP connection
                if ($nr_xml_files) {
                    add_settings_error('at_message_xmlftp_id', '', sprintf(_n('The XML %s file was copied to local directory from CEDROM-SNI\'s FTP.', 'The XML %s files were copied to local directory from CEDROM-SNI\'s FTP.', $nr_xml_files, 'avatar-toolkit'), $nr_xml_files), 'updated');

                    return true;
                } else {
                    add_settings_error('at_message_xmlftp_id', '', __('No files were copied to local directory from CEDROM-SNI\'s FTP. Check if XML files exist on the FTP server.', 'avatar-toolkit'));

                    return false;
                }
            } else {
                add_settings_error('at_message_xmlftp_id', '', __('The folder '.$ftp_path.' does not exist on the FTP server.', 'avatar-toolkit'));
            }

            $ftp->quit();

        } else {
            add_settings_error('at_message_xmlftp_id', '', __('Login credentials are empty, see "API Setting page".', 'avatar-toolkit'));
        }
    }
}

if (is_admin()) {
    $at_cedrom_ftp_xml_2_post_settings_page = new AT_Cedrom_FTP_XML_Import;
}
