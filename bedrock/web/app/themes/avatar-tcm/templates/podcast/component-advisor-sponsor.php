<div class="row">
					                <div class="bloc">
					                <div class="row head">
					                    <div class="col-md-12">
					                        <h2><?php _e('Companies', 'avatar-tcm'); ?></h2>
					                    </div>
					                </div>
<?php $terms = get_terms([
    'taxonomy' => 'post_sponsor',
    'parent' => 0,
]);

					                        ?>
    <ul class="row">
    	<?php
					                            foreach ($terms as $term) {
					                                //$posts_test[$term->name] = get_posts(array( 'posts_per_page' => 5, 'post_type' => 'post', 'tax_name' => $term->name ));

					                                $sponsor_type = get_field('acf_sponsor_type', $term);
					                                if ($sponsor_type == 'podcast') {

					                                    $posts_array[$term->name] = get_posts(
					                                        [
					                                            'posts_per_page' => -1,
					                                            'post_type' => 'post',
					                                            'tax_query' => [
					                                                [
					                                                    'taxonomy' => 'post_sponsor',
					                                                    'field' => 'term_id',
					                                                    'terms' => $term->term_id,
					                                                ],
					                                            ],
					                                        ]
					                                    );

					                                    if (! empty($posts_array[$term->name])) {

					                                        ?>
				<li class="col-xs-6">
					<a href="<?php echo esc_url(get_tag_link($term->term_id)); ?>" rel="tag"><?php
					                                                     echo $term->name;
					                                        ?></a>
				</li>
			<?php
					                                    }
					                                }
					                            } //print_r($posts_test);die;?>
        
	</ul>
	</div>
					    	</div>
						