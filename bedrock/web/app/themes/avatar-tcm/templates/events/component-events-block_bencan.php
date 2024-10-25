
	<div class="bbox-wrap col-xs-12 col-sm-6 col-md-12 col-lg-12">
						<?php
                            at_get_the_m32banner(
                                $arr_m32_vars = [
                                    'kv' => [
                                        'pos' => [
                                            'atf',
                                            'but1',
                                            'right_bigbox',
                                            'top_right_bigbox',
                                        ],
                                    ],
                                    'sizes' => '[ [300,250] ]',
                                    'sizeMapping' => '[ [[0,0], [[320,50]]], [[768,0], [[300,250]]], [[1024, 0], [[300,250]]] ]',
                                ],
                                $arr_avt_vars = [
                                    'class' => 'bigbox text-center',
                                ]
                            );
						?>
	</div>
<div class="col-sm-6 col-md-12 micro-module sponsor-bg">
    <div class="row">
        <div class="bloc events-widget">
            <div class="row head">
                <div class="col-md-12">
                    <h2>Events</h2>
                </div>
            </div>
            <ul class="row">
                <li class="col-sm-12">
                    <div class="bg-events-widget">
                        <a class="btn btn-footer btn-events" href="<?php echo get_field('acf_event_widget_page_bencan_link', 'option'); ?>"><span>Check out our events here!</span></a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>

