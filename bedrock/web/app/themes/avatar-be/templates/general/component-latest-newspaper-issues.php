<?php
$site_id = get_current_blog_id();
if ($newspaper_name !== '' && ($newspaper_name !== null)) {
    $avatar_newspaper_args = [
        'post_type' => 'newspaper',
        'post_status' => 'publish',
        'posts_per_page' => 9,
        'order' => 'DESC',
        'orderby' => 'post_date',
        'meta_query' => [
            'relation' => 'AND',
            [
                'key' => 'acf_newspaper_type',
                'value' => $newspaper_name,
                'compare' => '=',
            ],
        ],
        'post__not_in' => [$newspaper_id],
    ];
} else {
    $avatar_newspaper_args = [
        'post_type' => 'newspaper',
        'post_status' => 'publish',
        'posts_per_page' => 9,
        'order' => 'DESC',
        'orderby' => 'post_date',
        'post__not_in' => [$newspaper_id],
    ];
}

$avatar_newspaper_cpt_query = new WP_Query($avatar_newspaper_args);
?>
<?php if ($avatar_newspaper_cpt_query->have_posts()) { ?>
	<div class="col-lg-12 backissue--list-title">
		<h2 class="bloc-title bloc-title">
			<?php switch ($site_id) {
			    case 4: ?>
					<span class="bloc-title__text--color">Archives du magazine</span>
				<?php
			    break;
			    case 5: ?>
					<span class="bloc-title__text--color">Latest magazine issues</span>
				<?php
			    break;
			    case 6: ?>
					<span class="bloc-title__text--color">Dernières</span>&nbsp;éditions du magazine
				<?php
			    break;
			    default:
			        ?>
					<span class="bloc-title__text--color"><?php echo _x('Latest', 'journal', 'avatar-tcm'); ?></span>&nbsp;<?php echo _e('Magazine issues', 'avatar-tcm'); ?>
				<?php
			        break;
			} ?>
			<i class="bloc-title__caret fa fa-caret-right" aria-hidden="true"></i>
		</h2>
	</div>
	<ul class="newspaper-type-listing">
		<?php while ($avatar_newspaper_cpt_query->have_posts()) {
		    $avatar_newspaper_cpt_query->the_post(); ?>
		<?php
		    $flipbook_url = get_field('flipbook_url');
		    ?>
		<li class="col-lg-4 col-md-4 col-sm-6">
            <?php if (has_post_thumbnail()) { ?>
                <figure>
                <?php if ($flipbook_url) { ?>
                    <a href="<?php echo $flipbook_url; ?>" target="_blank">
                        <?php the_post_thumbnail('thumbnail', ['class' => 'img-responsive']); ?>
                    </a>
                <?php } else { ?>
                    <?php the_post_thumbnail('thumbnail', ['class' => 'img-responsive']); ?>
                <?php } ?>
                        
                </figure>
            <?php } ?>
            <h3>
                <a href="<?php the_permalink(); ?>"> <?php the_title(); ?> </a>
            </h3>
            <p><?php echo wp_trim_words(get_the_excerpt(), 25); ?></p>
		</li>
		<?php } ?>
	</ul>
<?php } ?>