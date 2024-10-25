<div class="container container-breadcrumbs">
	<div class="row">
		<div class="col-md-12">
			<?php if (function_exists('yoast_breadcrumb')) {
			    $breadcrumbs_internallinks = get_option('wpseo_internallinks');
			    $breadcrumbs_sep = $breadcrumbs_internallinks['breadcrumbs-sep'];

			    if (is_singular('feature')) {
			        $child_page_id = get_post_meta(get_the_ID(), 'acf_feature_parent_sub_category', true);
			        if (! $child_page_id == null) {

			            $parent_page_id = wp_get_post_parent_id($child_page_id);
			            ?>
						<span xmlns:v="http://rdf.data-vocabulary.org/#">
							<span typeof="v:Breadcrumb">
								<a href="<?php echo get_home_url(); ?>" rel="v:url" property="v:title">
									<?php echo esc_html($breadcrumbs_internallinks['breadcrumbs-home']); ?>
								</a>
								<?php echo $breadcrumbs_sep; ?>
								<span rel="v:child" typeof="v:Breadcrumb">
										<a href="<?php echo esc_url(get_page_link($parent_page_id)); ?>" rel="v:url" property="v:title">
											<?php echo get_the_title($parent_page_id); ?>
										</a>
										<!-- mschmit - It's a temporary fix, we should finish the "Feature" feature before using it ...  -->
										<?php if (get_the_title($child_page_id) !== esc_html($breadcrumbs_internallinks['breadcrumbs-home'])
			                                && get_the_title($parent_page_id) !== the_title('', '', false)) { ?>
											<?php echo $breadcrumbs_sep; ?>
											<span rel="v:child" typeof="v:Breadcrumb">
												<a href="<?php echo esc_url(get_page_link($child_page_id)); ?>" rel="v:url" property="v:title">
													<?php echo get_the_title($child_page_id); ?>
												</a>
												<?php echo $breadcrumbs_sep; ?>
												<span class="breadcrumb_last"><?php the_title(); ?></span>
											</span>
										<?php } ?>
								</span>
							</span>
						</span>
					<?php }
			        } elseif ((get_field('acf_article_type') == 'feature' and is_singular('post')) and (! get_field('acf_article_video'))) {
			            $indepth_page_obj = get_field('acf_in_depth_breadcrumb', 'option');
			            $indepth_page_id = $indepth_page_obj->ID;
			            $feature_object = get_field('acf_article_feature');
			            $brand_curr_id = $feature_object->ID;

			            $feature_main_sub_page = get_field('acf_feature_parent_sub_category', $brand_curr_id);
			            ?>
					<span xmlns:v="http://rdf.data-vocabulary.org/#">
						<span typeof="v:Breadcrumb">
							<a href="<?php echo get_home_url(); ?>" rel="v:url" property="v:title">
								<?php echo esc_html($breadcrumbs_internallinks['breadcrumbs-home']); ?>
							</a>
							<?php echo $breadcrumbs_sep; ?>
							<span rel="v:child" typeof="v:Breadcrumb">
								<a href="<?php echo esc_url(get_page_link($indepth_page_id)); ?>" rel="v:url" property="v:title">
									<?php echo get_the_title($indepth_page_id); ?>
								</a>
								<?php echo $breadcrumbs_sep; ?>
								<?php if (is_int($feature_main_sub_page)) { ?>
								<span rel="v:child" typeof="v:Breadcrumb">
										<a href="<?php echo esc_url(get_page_link($feature_main_sub_page)); ?>" rel="v:url" property="v:title">
											<?php echo get_the_title($feature_main_sub_page); ?>
										</a>
										<?php echo $breadcrumbs_sep; ?>
								<?php } ?>
									<span rel="v:child" typeof="v:Breadcrumb">
										<a href="<?php echo esc_url(get_post_permalink($brand_curr_id)); ?>" rel="v:url" property="v:title">
											<?php echo get_the_title($brand_curr_id); ?>
										</a>
										<?php echo $breadcrumbs_sep; ?>
										<span rel="v:child" typeof="v:Breadcrumb">
											<span class="breadcrumb_last"><?php the_title(); ?></span>
										</span>
									</span>
								</span>
							</span>
						</span>
					</span>
				<?php
			        } elseif (is_singular('brand')) {
			            $page_obj = get_field('acf_brand_knowledge_page', 'option'); ?>
					<span xmlns:v="http://rdf.data-vocabulary.org/#">
						<span typeof="v:Breadcrumb">
							<a href="<?php echo get_home_url(); ?>" rel="v:url" property="v:title">
								<?php echo esc_html($breadcrumbs_internallinks['breadcrumbs-home']); ?>
							</a>
							<?php echo $breadcrumbs_sep; ?>
							<span rel="v:child" typeof="v:Breadcrumb">
									<a href="<?php echo esc_url(get_page_link($page_obj->ID)); ?>" rel="v:url" property="v:title">
										<?php echo get_the_title($page_obj->ID); ?>
									</a>
									<?php echo $breadcrumbs_sep; ?>
								<span rel="v:child" typeof="v:Breadcrumb">
									<span class="breadcrumb_last"><?php the_title(); ?></span>
								</span>
							</span>
						</span>
					</span>
				<?php
			        } elseif (get_field('acf_article_type') == 'brand' and is_singular('post')) {
			            $brand_object = get_field('acf_article_brand');
			            $brand_page_obj = get_field('acf_brand_knowledge_page', 'option');
			            $brand_knowledge_id = $brand_page_obj->ID;
			            $brand_curr_id = $brand_object->ID; ?>
					<span xmlns:v="http://rdf.data-vocabulary.org/#">
						<span typeof="v:Breadcrumb">
							<a href="<?php echo get_home_url(); ?>" rel="v:url" property="v:title">
								<?php echo esc_html($breadcrumbs_internallinks['breadcrumbs-home']); ?>
							</a>
							<?php echo $breadcrumbs_sep; ?>
							<span rel="v:child" typeof="v:Breadcrumb">
								<a href="<?php echo esc_url(get_page_link($brand_knowledge_id)); ?>" rel="v:url" property="v:title">
									<?php echo get_the_title($brand_knowledge_id); ?>
								</a>
								<?php echo $breadcrumbs_sep; ?>
								<span rel="v:child" typeof="v:Breadcrumb">
										<a href="<?php echo esc_url(get_permalink($brand_curr_id)); ?>" rel="v:url" property="v:title">
											<?php echo get_the_title($brand_curr_id); ?>
										</a>
										<?php echo $breadcrumbs_sep; ?>
									<span rel="v:child" typeof="v:Breadcrumb">
										<span class="breadcrumb_last"><?php the_title(); ?></span>
									</span>
								</span>
							</span>
						</span>
					</span>
				<?php
			        } elseif (is_singular('writer')) {

			            $author_origin = get_field('acf_columnist_site_source', get_the_ID());
			            $is_columnist = get_field('acf_author_is_columnist', get_the_ID());

			            if (strcmp('CIR blog', $author_origin) === 0) {
			                $page_obj = get_field('acf_inside_track_breadcrumb_cir', 'option');
			            } else {
			                $page_obj = get_field('acf_inside_track_breadcrumb', 'option');
			            }
			            ?>
					<span xmlns:v="http://rdf.data-vocabulary.org/#">
						<span typeof="v:Breadcrumb">
							<a href="<?php echo get_home_url(); ?>" rel="v:url" property="v:title">
								<?php echo esc_html($breadcrumbs_internallinks['breadcrumbs-home']); ?>
							</a>
							<?php if ($page_obj->post_parent) { ?>
								<?php echo $breadcrumbs_sep; ?>
								<span rel="v:child" typeof="v:Breadcrumb">
									<a href="<?php echo esc_url(get_page_link($page_obj->post_parent)); ?>" rel="v:url" property="v:title">
										<?php echo get_the_title($page_obj->post_parent); ?>
									</a>
								</span>
							<?php } ?>
							<?php echo $breadcrumbs_sep; ?>
							<span rel="v:child" typeof="v:Breadcrumb">
								<?php if ($is_columnist) { ?>
									<a href="<?php echo esc_url(get_page_link($page_obj->ID)); ?>" rel="v:url" property="v:title">
										<?php echo get_the_title($page_obj->ID); ?>
									</a>
									<?php echo $breadcrumbs_sep; ?>
								<?php } ?>
								<span rel="v:child" typeof="v:Breadcrumb">
									<span class="breadcrumb_last"><?php the_title(); ?></span>
								</span>
							</span>
						</span>
					</span>
				<?php
			        } elseif ((avatar_is_columnist(get_the_ID()) and is_singular('post')) and (! get_field('acf_article_video'))) {
			            $author_id = get_field('acf_article_author');
			            $author_origin = get_field('acf_columnist_site_source', $author_id[0]->ID);

			            if (strcmp('CIR blog', $author_origin) === 0) {
			                $page_obj = get_field('acf_inside_track_breadcrumb_cir', 'option');
			            } else {
			                $page_obj = get_field('acf_inside_track_breadcrumb', 'option');
			            }

			            if (is_array($author_id)) {
			                $author_id = $author_id[0];
			            }
			            ?>
					<span xmlns:v="http://rdf.data-vocabulary.org/#">
						<span typeof="v:Breadcrumb">
							<a href="<?php echo get_home_url(); ?>" rel="v:url" property="v:title">
								<?php echo esc_html($breadcrumbs_internallinks['breadcrumbs-home']); ?>
							</a>
							<?php if ($page_obj->post_parent) { ?>
								<?php echo $breadcrumbs_sep; ?>
								<span rel="v:child" typeof="v:Breadcrumb">
									<a href="<?php echo esc_url(get_page_link($page_obj->post_parent)); ?>" rel="v:url" property="v:title">
										<?php echo get_the_title($page_obj->post_parent); ?>
									</a>
								</span>
							<?php } ?>
							<?php echo $breadcrumbs_sep; ?>
							<span rel="v:child" typeof="v:Breadcrumb">
								<a href="<?php echo esc_url(get_page_link($page_obj->ID)); ?>" rel="v:url" property="v:title">
									<?php echo get_the_title($page_obj->ID); ?>
								</a>
									<?php echo $breadcrumbs_sep; ?>
								<span rel="v:child" typeof="v:Breadcrumb">
									<a href="<?php the_permalink($author_id->ID); ?>" rel="v:url" property="v:title">
										<?php echo get_the_title($author_id->ID); ?>
									</a>
									<?php echo $breadcrumbs_sep; ?>
									<span rel="v:child" typeof="v:Breadcrumb">
										<span class="breadcrumb_last"><?php the_title(); ?></span>
									</span>
								</span>
							</span>
						</span>
					</span>
				<?php

			        } elseif (get_field('acf_article_video') and is_singular('post') and get_field('acf_featured_video_page')) {
			            // for page title and url
			            $cur_cat_id = get_field('article_side_main_subcategory');

			            $avatar_video_page_id = avatar_get_page_by_cat($cur_cat_id);

			            $avatar_video_page_parent_id = wp_get_post_parent_id($avatar_video_page_id);

			            $page_obj = get_field('acf_inside_track_breadcrumb', 'option'); ?>
					<span xmlns:v="http://rdf.data-vocabulary.org/#">
						<span typeof="v:Breadcrumb">
							<a href="<?php echo get_home_url(); ?>" rel="v:url" property="v:title">
								<?php echo esc_html($breadcrumbs_internallinks['breadcrumbs-home']); ?>
							</a>
							<?php echo $breadcrumbs_sep; ?>
							<span rel="v:child" typeof="v:Breadcrumb">
								<a href="<?php echo esc_url(get_page_link($avatar_video_page_parent_id)); ?>" rel="v:url" property="v:title">
									<?php echo get_the_title($avatar_video_page_parent_id); ?>
								</a>
									<?php echo $breadcrumbs_sep; ?>
								<span rel="v:child" typeof="v:Breadcrumb">
									<a href="<?php echo esc_url(get_page_link($avatar_video_page_id)); ?>" rel="v:url" property="v:title">
										<?php echo get_the_title($avatar_video_page_id); ?>
									</a>
									<?php echo $breadcrumbs_sep; ?>
									<span rel="v:child" typeof="v:Breadcrumb">
										<span class="breadcrumb_last"><?php the_title(); ?></span>
									</span>
								</span>
							</span>
						</span>
					</span>
				<?php
			        } elseif (is_singular('newspaper')) {
			            $page_id = get_field('acf_newspaper_page', 'option'); ?>
					<span xmlns:v="http://rdf.data-vocabulary.org/#">
						<span typeof="v:Breadcrumb">
							<a href="<?php echo get_home_url(); ?>" rel="v:url" property="v:title">
								<?php echo esc_html($breadcrumbs_internallinks['breadcrumbs-home']); ?>
							</a>
							<?php echo $breadcrumbs_sep; ?>
							<span rel="v:child" typeof="v:Breadcrumb">
									<a href="<?php echo esc_url(get_page_link($page_id)); ?>" rel="v:url" property="v:title">
										<?php echo get_the_title($page_id); ?>
									</a>
									<?php echo $breadcrumbs_sep; ?>
								<span rel="v:child" typeof="v:Breadcrumb">
									<span class="breadcrumb_last"><?php the_title(); ?></span>
								</span>
							</span>
						</span>
					</span>
				<?php
			        } elseif (get_field('acf_article_newspaper') and is_singular('post')) {
			            $newspaper_object = get_field('acf_article_newspaper');
			            $newspaper_curr_id = $newspaper_object->ID;
			            $newspaper_page_id = get_field('acf_newspaper_page', 'option'); ?>
					<span xmlns:v="http://rdf.data-vocabulary.org/#">
						<span typeof="v:Breadcrumb">
							<a href="<?php echo get_home_url(); ?>" rel="v:url" property="v:title">
								<?php echo esc_html($breadcrumbs_internallinks['breadcrumbs-home']); ?>
							</a>
							<?php echo $breadcrumbs_sep; ?>
							<span rel="v:child" typeof="v:Breadcrumb">
								<a href="<?php echo esc_url(get_page_link($newspaper_page_id)); ?>" rel="v:url" property="v:title">
									<?php echo get_the_title($newspaper_page_id); ?>
								</a>
								<?php echo $breadcrumbs_sep; ?>
								<span rel="v:child" typeof="v:Breadcrumb">
										<a href="<?php echo esc_url(get_permalink($newspaper_curr_id)); ?>" rel="v:url" property="v:title">
											<?php echo get_the_title($newspaper_curr_id); ?>
										</a>
										<?php echo $breadcrumbs_sep; ?>
									<span rel="v:child" typeof="v:Breadcrumb">
										<span class="breadcrumb_last"><?php the_title(); ?></span>
									</span>
								</span>
							</span>
						</span>
					</span>
				<?php
			        } else {
			            $avatar_breadcrumbs = yoast_breadcrumb('', '', true);
			        }

			} ?>
		</div>
	</div>
</div>