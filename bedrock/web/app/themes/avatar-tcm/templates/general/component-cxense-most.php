<?php
/*
* Location : General (see design)
* Cxense most popular/shared Component
* Displays a list from Cxense of most popular and most shared posts.
*/
//
//
//
//
// hide this module hide this module temporary
//
//
//
//
return;
//
//
//
//
//
?>
<?php if (get_field('acf_cxense_site_id', 'option')) { ?>
	<div class="component component-cxense-most text-center col-sm-6 col-md-12">
		<div class="component-cxense-most__header">
			<ul class="nav nav-tabs">
				<li class="active component-cxense-most__item">
					<a class="component-cxense-most__link" href="#most-popular" data-toggle="tab"><span class="component-cxense-most__title"><?php _e('Most popular', 'avatar-tcm'); ?></span></a>
				</li>
				<li class="component-cxense-most__item">
					<a class="component-cxense-most__link" href="#most-shared" data-toggle="tab"><span class="component-cxense-most__title"><?php _e('Most shared', 'avatar-tcm'); ?></span></a>
				</li>
			</ul>
		</div>
		<div class="tab-content">
			<div id="most-popular" class="tab-pane active ">
				<?php at_the_most_popular_articles_lists(); ?>
			</div>
			<div id="most-shared" class="tab-pane fade">
	            <?php at_the_most_shared_article_list(); ?>
			</div>
		</div>
	</div>
<?php } ?>