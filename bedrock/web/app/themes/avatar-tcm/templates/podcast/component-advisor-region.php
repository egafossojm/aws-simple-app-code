<div class="row">
					                <div class="bloc">
					                <div class="row head">
					                    <div class="col-md-12">
					                        <h2><?php _e('Regions', 'avatar-tcm'); ?></h2>
					                    </div>
					                </div>
<?php $terms = get_terms([
    'taxonomy' => 'post_region',
    'parent' => 0,
]);

					                        ?>
    <ul class="row">
    	<?php
					                            foreach ($terms as $term) {
					                                $posts_array[$term->name] = get_posts(
					                                    [
					                                        'posts_per_page' => -1,
					                                        'post_type' => 'post',
					                                        'tax_query' => [
					                                            [
					                                                'taxonomy' => 'post_region',
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
					                            }?>
        
	</ul>
	</div>
					    	</div>
					