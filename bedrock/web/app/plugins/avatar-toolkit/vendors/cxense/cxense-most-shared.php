<?php
/* -------------------------------------------------------------
 * Most popular cxense
 * ============================================================*/
if (! function_exists('at_the_most_shared_article_list')) {

    function at_the_most_shared_article_list()
    {

        $avatar_most_shared_arr = [];
        if (false === ($avatar_most_shared_arr = get_transient('avatar_most_shared_cx'))) {
            $avatar_most_shared_arr['status'] = 'live';
            $avatar_most_shared_arr['updated'] = date('r');

            $avatar_cxense_api_key = get_field('acf_cxense_api_key', 'option');
            $avatar_cxense_site_id = get_field('acf_cxense_site_id', 'option');
            $avatar_cxense_username = get_field('acf_cxense_username', 'option');

            if ($avatar_cxense_api_key and $avatar_cxense_site_id and $avatar_cxense_username) {

                $date = date('Y-m-d\TH:i:s.000O');
                $signature = hash_hmac('sha256', $date, $avatar_cxense_api_key);
                $url = 'https://api.cxense.com/dmp/traffic/data';
                $plainjson_payload = '{"siteId":"'.$avatar_cxense_site_id.'", "fields":["userId", "type", "customParameters"], "start":"-7d" }';

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

                $events = $result['events'];
                if (empty($events)) {
                    return;
                }

                $most_shared_articles = [];
                $articleIds = [];
                foreach ($events as $event) {

                    $customParamsArray = $event['customParameters'];
                    $customParams = $customParamsArray[0];
                    $group = $customParams['group'];
                    if ($group == 'tcm-facebook-share-articleId') {
                        $item = $customParams['item'];
                        array_push($articleIds, (int) $item);
                    }
                }
                $articleIds = array_count_values($articleIds);
                arsort($articleIds);
                $articleIds = array_keys($articleIds);
                $articleIds = array_splice($articleIds, 0, 5);

                $avatar_most_shared_arr['id'] = $articleIds;
            }
            /* -------------------------------------------------------------
             * Set transient for 60 minutes
             * ============================================================*/
            set_transient('avatar_most_shared_cx', $avatar_most_shared_arr, 60 * MINUTE_IN_SECONDS);
        } else {
            $avatar_most_shared_arr['status'] = 'cache';
        }

        /* -------------------------------------------------------------
         * test if array is ok and the key exist
         * ============================================================*/
        if (is_array($avatar_most_shared_arr) && array_key_exists('id', $avatar_most_shared_arr)) {

            $most_shared = new WP_Query([
                'post__in' => $avatar_most_shared_arr['id'],
                'orderby' => 'post__in',
            ]
            );

            $position = 0;
            if ($most_shared->have_posts()) { ?>
				<ul class="most-top-list text-left row" data-updated="<?php echo esc_attr($avatar_most_shared_arr['updated']); ?>"  data-from="<?php echo esc_attr($avatar_most_shared_arr['status']); ?>">
					<?php while ($most_shared->have_posts()) {
					    $most_shared->the_post(); ?>
						<li class="most-top-list__item col-sm-12" >
							<span class="most-top-list__rank col-sm-1">
								<?php echo ++$position; ?>
							</span>
							<span class="most-top-list__text col-sm-10">
								<a class="most-top-list__link" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
							</span>
						</li>
					<?php } ?>
				</ul>
			<?php wp_reset_postdata();
            }
        }
    }
}
?>