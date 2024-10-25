<?php
/*
* Location : General (see design)
* Sun Life Retirement side block
* Displays the most recent Sun Life Retirement post from Ad & Co
*/

$site_id = get_current_blog_id();
switch ($site_id) {
    case 5:
        $sponsor_name = 'Sponsored by Sun Life';
        $block_title = 'Retirement Resource Centre';
        $block_title_url = '/microsite/retirement-resource-centre/';
        $cat_name = 'Sun Life retirement';
        break;
    case 4:
        $sponsor_name = 'Commandité par Sun Life';
        $block_title = 'Centre de documentation sur la retraite';
        $block_title_url = '/microsite/centre-de-documentation-sur-la-retraite/';
        $cat_name = 'Retraite-Sunlife';
        break;
}

$avatar_sunlife_args = [
    'post_status' => 'publish',
    'post_type' => 'post',
    'posts_per_page' => 1,
    'orderby' => 'post__in',
    'category_name' => $cat_name,
];
$avatar_sunlife_args_query = new WP_Query($avatar_sunlife_args);

?>

<?php if ($avatar_sunlife_args_query->have_posts()) { ?>
	<div class="component component-ie-tv  col-sm-6 col-md-12" style = "border-style: solid; border-width: medium; border-color: #ccc" >
		<div class="col-md-12">
		<h2 class="text-content__title icons"  >
				<a class="featured-videos-title__link " style = "color: #1a4e59; font-size: 17.5px" href="<?php echo esc_url($block_title_url); ?>">
					<?php echo $block_title; ?>
				</a> </h2>
			<h2 class="text-content__title icons" style = "color: #febd0f; font-size: 14.5px; margin-top: -5px;">
					<?php echo $sponsor_name; ?>
				</h2>
		</div>
	<div class="row">
		<?php while ($avatar_sunlife_args_query->have_posts()) {
		    $avatar_sunlife_args_query->the_post(); ?>
			<?php $curr_post_id = get_the_ID(); ?>

				<div id="post-<?php the_ID(); ?>" <?php post_class('col-xs-12 col-md-12 no-padding-top'); ?> style = "background: transparent">
					<?php if (has_post_thumbnail()) { ?>
					<figure class="text-content no-padding-bottom no-padding-top col-md-6 col-sm-6 col-xs-12 col-no-padding-right">
					  <a href="<?php the_permalink(); ?>">
						<?php the_post_thumbnail($size = 'thumbnail', ['class' => 'img-responsive text-content__image-full', 'title' => get_the_title()]); ?>
					  	
					  </a>
					</figure>
					<?php }?>
					<div class="text-content no-padding-bottom <?php echo esc_attr($css = has_post_thumbnail() ? 'col-md-6 col-sm-6 col-xs-12' : 'col-md-12'); ?>">
						<h3 class="text-content__title">
							<a class="" style ="color: black" href="<?php the_permalink(); ?>">
								<?php the_title(); ?>
							</a>
						 </h3>
						<!--<span class="text-content__excerpt"><?php the_excerpt(); ?></span>-->
					</div>
				</div>
		<?php } ?>
	</div>
</div>
<?php } wp_reset_postdata(); ?>




