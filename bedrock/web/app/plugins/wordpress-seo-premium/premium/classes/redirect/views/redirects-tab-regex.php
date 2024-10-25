<?php
/**
 * WPSEO Premium plugin file.
 */

/**
 * Redirect origin.
 *
 * @var string $origin_from_url
 */

/**
 * Instance of the WPSEO_Redirect_Quick_Edit_Presenter class.
 *
 * @var WPSEO_Redirect_Quick_Edit_Presenter $quick_edit_table
 */

/**
 * Instance of the WPSEO_Redirect_Table class.
 *
 * @var WPSEO_Redirect_Table $redirect_table
 */

/**
 * Instance of the WPSEO_Redirect_Form_Presenter class.
 *
 * @var WPSEO_Redirect_Form_Presenter $form_presenter
 */
?>

<div id="table-regex" class="tab-url redirect-table-tab">
<?php echo '<h2>'.esc_html__('Regular Expression redirects', 'wordpress-seo-premium').'</h2>'; ?>
	<p>
		<?php
        printf(
            /* translators: 1: opens a link to a related knowledge base article. 2: closes the link. */
            esc_html__('Regular Expression (regex) Redirects are extremely powerful redirects. You should only use them if you know what you are doing. %1$sRead more about regex redirects on our knowledge base%2$s.', 'wordpress-seo-premium'),
            '<a href="https://yoa.st/3lo" target="_blank">',
            '</a>'
        );
?>
	</p>

	<form class='wpseo-new-redirect-form' method='post'>
		<div class='wpseo_redirect_form'>
<?php
$form_presenter->display(
    [
        'input_suffix' => '',
        'values' => [
            'origin' => $origin_from_url,
            'target' => '',
            'type' => '',
        ],
    ]
);
?>

			<button type="button" class="button button-primary"><?php esc_html_e('Add Redirect', 'wordpress-seo-premium'); ?></button>
		</div>
	</form>

	<p class='desc'>&nbsp;</p>

	<?php
    $quick_edit_table->display(
        [
            'form_presenter' => $form_presenter,
            'total_columns' => $redirect_table->count_columns(),
        ]
    );
?>

	<form id='regex' class='wpseo-redirects-table-form' method='post'>
		<input type='hidden' class="wpseo_redirects_ajax_nonce" name='wpseo_redirects_ajax_nonce' value='<?php echo esc_attr($nonce); ?>' />
		<?php
    // The list table.
    $redirect_table->prepare_items();
$redirect_table->search_box(__('Search', 'wordpress-seo-premium'), 'wpseo-redirect-search');
$redirect_table->display();
?>
	</form>
</div>
