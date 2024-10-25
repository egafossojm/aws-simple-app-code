<?php
/* -------------------------------------------------------------
 * Most popular cxense
 * ============================================================*/
if (! function_exists('at_the_most_popular_articles_lists')) {

    function at_the_most_popular_articles_lists()
    {
        $avatar_most_popular_arr = [];
        if (false === ($avatar_most_popular_arr = get_transient('avatar_most_popular_cx'))) {
            $avatar_most_popular_arr['status'] = 'live';
            $avatar_most_popular_arr['updated'] = date('r');

            $avatar_cxense_api_key = get_field('acf_cxense_api_key', 'option');
            $avatar_cxense_site_id = get_field('acf_cxense_site_id', 'option');
            $avatar_cxense_username = get_field('acf_cxense_username', 'option');

            if ($avatar_cxense_api_key and $avatar_cxense_site_id and $avatar_cxense_username) {

                $date = date('Y-m-d\TH:i:s.000O');
                $signature = hash_hmac('sha256', $date, $avatar_cxense_api_key);
                $url = 'https://api.cxense.com/traffic/custom';

                $plainjson_payload = '{"siteId":"'.$avatar_cxense_site_id.'", "groups":["tcm-article-wp-id"], "count":7, "start":"-7d" }';
                $options = [
                    'http' => [
                        'header' => "Content-Type: application/json; charset=UTF-8\r\n".
                            "X-cXense-Authentication: username=$avatar_cxense_username date=$date hmac-sha256-hex=$signature\r\n",
                        'method' => 'POST',
                        'content' => $plainjson_payload,
                        'timeout' => 5,
                    ],
                ];
                $context = stream_context_create($options);
                $result = file_get_contents($url, false, $context);
                $result = json_decode($result, true);

                $items = $result['groups'][0]['items'];

                foreach ($items as $key => $item) {
                    $avatar_most_popular_arr['id'][$key] = (int) $item['item'];
                }

            }
            /* -------------------------------------------------------------
             * Set transient for 60 minutes
             * ============================================================*/
            set_transient('avatar_most_popular_cx', $avatar_most_popular_arr, 60 * MINUTE_IN_SECONDS);
        } else {
            $avatar_most_popular_arr['status'] = 'cache';
        }

        /* -------------------------------------------------------------
         * test if array is ok and the key exist
         * ============================================================*/
        if (is_array($avatar_most_popular_arr) && array_key_exists('id', $avatar_most_popular_arr)) {
            $args = [
                'post_status' => 'publish',
                'post_type' => 'post',
                'posts_per_page' => 5,
                'post__in' => $avatar_most_popular_arr['id'],
                'orderby' => 'post__in',
            ];
            $the_query = new WP_Query($args); ?>
			<?php if ($the_query->have_posts()) {
			    $i = 1; ?>
				<ul class="most-top-list text-left row" data-updated="<?php echo esc_attr($avatar_most_popular_arr['updated']); ?>"  data-from="<?php echo esc_attr($avatar_most_popular_arr['status']); ?>">
					<?php while ($the_query->have_posts()) {
					    $the_query->the_post(); ?>
						<li class="most-top-list__item col-sm-12">
							<span class="most-top-list__rank col-sm-1">
								<?php echo $i++; ?>
							</span>
							<span class="most-top-list__text col-sm-10">
								<a class="most-top-list__link" href="<?php the_permalink(); ?>">
									<?php the_title(); ?>
								</a>
							</span>
						</li>
					<?php } ?>
				</ul>
			<?php wp_reset_postdata();
			}
        } else {
            error_log('The array most_popular_articles dosent exist');
        }

    }
}

?>