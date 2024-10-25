<?php
function spit_microsite_sidebar(
    $title_field, $repeater_field, $button_url_field, $button_text_field)
{
    $repeater = get_field($repeater_field, 'option');
    // Test if array exist and create new array with ID only
    if (is_array($repeater)) {
        $repeater_array = [];
        foreach ($repeater as $key => $value) {
            $repeater_array[] = $value['acf_promoted_microsite'];
        }
    } else {
        return;
    }

    $wp_query_microsites_arg = [
        'post_type' => 'microsite',
        'post_status' => 'publish',
        'post__in' => $repeater_array,
        'orderby' => 'post__in',
    ];

    $wp_query_microsites = new WP_Query($wp_query_microsites_arg);
    if ($wp_query_microsites) {
        ?>
    <div class="col-sm-6 col-md-12 micro-module">
            <div class="row">
                <div class="bloc">
                <div class="row head">
                    <div class="col-md-12">
                        <h2><?php echo get_field($title_field, 'option'); ?></h2>
                    </div>
                </div>
                <ul class="row">
    <?php
            while ($wp_query_microsites->have_posts()) {
                $wp_query_microsites->the_post();
                $post_id = get_the_id();
                $post_title = get_the_title();
                $post_excerpt = get_the_excerpt();
                $partner_site_url = get_field('acf_microsite_partner_url', $post_id);
                $partner_name = get_field('acf_microsite_partner_name', $post_id);
                $partner_logo_array = get_field('acf_microsite_partner_logo', $post_id);
                $logo_sizes = $partner_logo_array['sizes'] ?? null;
                $partner_logo = $logo_sizes['thumbnail'] ?? null;
                $sidebar_logo = get_field('acf_microsite_sidebar_banner', $post_id)['url'];
                ?>
        <li class="col-sm-12">
        <?php if (isset($sidebar_logo)) { ?>
            <a href="<?php echo get_post_permalink($post_id); ?>"><img class="partner-logo" src="<?php echo $sidebar_logo; ?>"/></a>
        <?php } else { ?>
            <div class="bg">

                <?php if (get_field('acf_show_microsite_title', $post_id)) { ?>
                    <a href="<?php echo get_post_permalink($post_id); ?>"><h3><?php echo $post_title ?></h3></a>
                <?php } ?>

                <?php if (get_field('acf_show_microsite_description', $post_id)) { ?>
                    <p class="excerpt"><?php echo $post_excerpt; ?></p>
                <?php } ?>

                <div class="foot">
                    <?php if (isset($partner_logo)) { ?>
                    <figure>
                        <figcaption><?php _e('Sponsored by ', 'avatar-tcm'); ?></figcaption>
                            <a href="<?php echo $partner_site_url; ?>" target="_blank"><img src="<?php echo $partner_logo; ?>"/></a>
                    </figure>
                    <?php } elseif (($partner_name !== '') && ($partner_name !== null)) { ?>
                    <span class="sponsor-label"><?php _e('Sponsored by ', 'avatar-tcm'); ?></span><a href="<?php echo $partner_site_url; ?>" class="sponsor-link" target="_blank"><?php echo $partner_name; ?></a>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
        </li>


<?php
            }

    }?>
            </ul>
			<?php if (($button_text_field) && ($button_url_field)) {?>
				<div class="text-center">
					<a class="btn" href="<?php echo get_field($button_url_field, 'option'); ?>"><?php echo get_field($button_text_field, 'option'); ?></a>
				</div>
			<?php } ?>
        </div>
    </div>
</div>
<?php } // end of spitsection()
