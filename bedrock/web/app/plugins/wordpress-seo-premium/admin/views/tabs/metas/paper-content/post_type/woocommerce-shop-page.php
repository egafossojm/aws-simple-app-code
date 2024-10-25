<?php
/**
 * WPSEO plugin file.
 *
 *
 * @uses WP_Post_Type $wpseo_post_type
 */
$woocommerce_shop_page = new WPSEO_WooCommerce_Shop_Page;
$description = __('You haven\'t set a Shop page in your WooCommerce settings. Please do this first.', 'wordpress-seo');

if ($woocommerce_shop_page->get_shop_page_id() !== -1) {
    $description = sprintf(
        /* translators: %1$s expands to an opening anchor tag, %2$s expands to a closing anchor tag. */
        __('You can edit the SEO meta-data for this custom type on the %1$sShop page%2$s.', 'wordpress-seo'),
        '<a href="'.get_edit_post_link($woocommerce_shop_page->get_shop_page_id()).'">',
        '</a>'
    );
}

/* translators: %s expands to the post type name. */
echo '<h3>'.esc_html(sprintf(__('Settings for %s archive', 'wordpress-seo'), $wpseo_post_type->labels->name)).'</h3>';
echo '<p>'.$description.'</p>';
