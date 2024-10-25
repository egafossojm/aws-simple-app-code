<?php
/* -------------------------------------------------------------
 * Get any existing copy of our transient data for market_watch
 * ============================================================*/
if (false === ($avatar_market_watch_arr = get_transient('avatar_market_watch'))) {
    // It wasn't there, so regenerate the data and save the transient
    $avatar_market_watch_arr['status'] = 'live';

    $avatar_globeinvestor_xml = 'http://xml.globeinvestor.com/servlet/Page/xml/v3/transconx/getStockProfile?stockSymbol=TSX-I&stockSymbol=JX-I&stockSymbol=COMP-I&stockSymbol=SPX-I&stockSymbol=CADUSD&lang=en';
    $avatar_globeinvestor_xml_content = file_get_contents($avatar_globeinvestor_xml);

    if (! $avatar_globeinvestor_xml_content) {
        return;
    }

    $avatar_globeinvestor_xml_content = str_replace('xmlns=', 'ns=', $avatar_globeinvestor_xml_content);
    $avatar_simplexml = simplexml_load_string($avatar_globeinvestor_xml_content);

    $avatar_xml_status_code = $avatar_simplexml->xpath('//s:statusCode');
    $avatar_xml_update_time = $avatar_simplexml->xpath('//s:dateTime');

    $avatar_market_watch_code = (string) $avatar_xml_status_code[0];

    if ($avatar_market_watch_code !== '200') {
        return;
    }

    $avatar_market_watch_arr['updated'] = (string) $avatar_xml_update_time[0];
    $avatar_xml_stock_content = $avatar_simplexml->xpath('//stock');

    foreach ($avatar_xml_stock_content as $key => $value) {

        $companyName = (string) $value->indicative->companyName;
        $currency = (string) $value->indicative->currency;
        $last = (float) $value->quote->last;
        $netChange = (float) $value->quote->netChange;

        if ($companyName == 'NASDAQ Composite') {
            $companyName = 'NASDAQ';
        }

        if ($companyName == 'Canadian Dollar/U.S. Dollar') {
            $companyName = 'Dollars (US)';
            $netChange = number_format(round($netChange, 4), 4);
            $last = number_format(round($last, 4), 4);
        } else {
            $netChange = number_format(round($netChange, 2), 2);
            $last = number_format(round($last, 2), 2);
        }

        if ($netChange > 0) {
            $direction = 'up';
        } elseif ($netChange < 0) {
            $direction = 'down';
        } else {
            $direction = 'equal';
        }

        /* -------------------------------------------------------------
         * Create new array
         * ============================================================*/
        $avatar_market_watch_arr['stock'][$key]['companyName'] = $companyName;
        $avatar_market_watch_arr['stock'][$key]['currency'] = $currency;
        $avatar_market_watch_arr['stock'][$key]['last'] = $last;
        $avatar_market_watch_arr['stock'][$key]['netChange'] = $netChange;
        $avatar_market_watch_arr['stock'][$key]['direction'] = $direction;
    }

    /* -------------------------------------------------------------
     * Set transient for 15 minutes
     * ============================================================*/
    set_transient('avatar_market_watch', $avatar_market_watch_arr, 15 * MINUTE_IN_SECONDS);
} else {
    $avatar_market_watch_arr['status'] = 'cache';
}
?>
<?php if (! empty($avatar_market_watch_arr)) { ?>
	<div class="market-watch container-fluid visible-md visible-lg" data-updated="<?php echo esc_attr($avatar_market_watch_arr['updated']); ?>"  data-from="<?php echo esc_attr($avatar_market_watch_arr['status']); ?>" >
		<div class="ticker">
			<div class="scroll-wrap">
				<ul class="menu-marches">
				<?php foreach ($avatar_market_watch_arr['stock'] as $key => $value) { ?>
					<li>
						<?php echo wp_kses_post($value['companyName']); ?>
						<span class="value">
							 <?php echo wp_kses_post($value['last']); ?>
						</span>
						<span class="variation <?php echo esc_attr($value['direction']); ?>">
							 <?php echo wp_kses_post($value['netChange']); ?>
						</span>
					</li>
				<?php } ?>
				</ul>
			</div>
		</div>
	</div>
<?php } ?>