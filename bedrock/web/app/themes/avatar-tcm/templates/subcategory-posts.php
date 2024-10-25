<?php
/* -------------------------------------------------------------
 * Show all subcategories of main category
 * ============================================================*/
// WP_Term_Query arguments
$avatar_subcategory_args = [
    'taxonomy' => ['category'],
    'meta_key' => 'category_sub_cat_order',
    'orderby' => 'meta_value_num',
    'order' => 'ASC',
    'child_of' => $catid,
];

$avatar_subcategory_term_data = new WP_Term_Query($avatar_subcategory_args);
if (empty($avatar_subcategory_term_data->terms)) {
    error_log('empty $avatar_subcategory_term_data');

    return;
}
$i = 0;
?>
<div class="row category-regular-listing">
	<?php foreach ($avatar_subcategory_term_data->terms as $sub_category) {
	    $avatar_sub_category_posts_args = [
	        'post_type' => 'post',
	        'post_status' => 'publish',
	        'cat' => $sub_category->term_id,
	        'order' => 'DESC',
	        'order_by' => 'post_date',
	        'posts_per_page' => 3,
	        'post__not_in' => $avatar_exclude_ids,
	    ];

	    $avatar_sub_category_posts = new WP_Query($avatar_sub_category_posts_args);
	    $conditional_col = ($i % 2 == 0) ? 'col-no-padding-right' : '';
	    ?>

	<?php if ($avatar_sub_category_posts->have_posts()) { ?>
		<div class="col-sm-6 <?php echo esc_attr($conditional_col); ?>">
			<div>
				<div>
					<h2 class="bloc-title bloc-title--border-top bloc-title--no-margin-bottom">
						<a class="bloc-title__link" href="<?php echo esc_url(get_category_link($sub_category->term_id)); ?>" title="<?php echo esc_html($sub_category->name); ?>">
							<?php echo esc_html($sub_category->name); ?>
							<i class="fa fa-caret-right bloc-title__caret" aria-hidden="true"></i>
						</a>
					</h2>
				</div>

				<?php while ($avatar_sub_category_posts->have_posts()) {

				    $avatar_sub_category_posts->the_post();
				    $curr_post_id = get_the_ID();
				    $avatar_exclude_ids[] = $curr_post_id;

				    ?>
					<div>
						<div class="text-content no-padding-bottom  ">
							<h3 class="text-content__title icons <?php echo avatar_article_get_icon($curr_post_id); ?>"><a class="text-content__link" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
							<p class="text-content__excerpt"><?php echo wp_trim_words(get_the_excerpt($curr_post_id), 25); ?></p>
							<ul class="pub-details">
								<?php avatar_display_post_author($curr_post_id, $single = false); ?>
								<?php avatar_display_post_source($curr_post_id, $single = false); ?>
								<?php avatar_display_post_date($curr_post_id, $single = false); ?>
							</ul>
						</div>
					</div>
				<?php } ?>
 			</div>
 		</div><!--end col-sub -->
		<?php } //have_posts?>
	<?php $i++;
	}  //endforeach?>
</div>
<hr>