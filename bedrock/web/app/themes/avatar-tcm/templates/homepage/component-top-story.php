<div class="bloc-title bloc-title--margin-top-negative">
	<span class="bloc-title__text">
		<?php _e('Top stories', 'avatar-tcm'); ?>
	</span>
</div>
<?php
$fields = get_field('homepage_articles', 'option');
		$avatar_homepage_articles = avatar_get_news_homepage($fields);
		$j = 0;
		if (empty($avatar_homepage_articles) && is_super_admin()) {
		    _e('No articles selected for home page or the articles was deleted.', 'avatar-tcm');
		} else {
		    foreach ($avatar_homepage_articles as $key => $homepage_article) {
		        $article_type = get_field('acf_article_type', $homepage_article['article']['id']);
		        $acf_article_sponsor = get_field('acf_article_sponsor', $homepage_article['article']['id']);
		        if ($key == 0) {
		            //1 - 2 - 3 articles
		            ?>
			<div class="row">
				<?php //1 first article
		                            ?>
				<div class="col-sm-8 first-featured">
					<?php if (($article_type == 'brand') || (($acf_article_sponsor !== null) && ($acf_article_sponsor > 0))) {
					    echo '<div class="bg sponsor-bg">';
					} ?>
					<figure>
						<a href="<?php echo get_permalink($homepage_article['article']['id']); ?>">
							<?php
					        if (isset($homepage_article['article']['featured_image'])) { ?>
								<div class="top-image">
									<?php echo get_the_post_thumbnail($homepage_article['article']['id'], 'medium', ['class' => 'img-responsive']); ?>
								</div>
							<?php }
					        ?>
						</a>
					</figure>
					<div class="text-content top-featured">
						<h2 class="text-content__title text-content__title--xxbig">
							<a class="text-content__link" href="<?php echo get_permalink($homepage_article['article']['id']); ?>">
								<?php echo get_the_title($homepage_article['article']['id']); ?>
							</a>
						</h2>
						<p class="text-content__excerpt">
							<?php echo get_the_excerpt($homepage_article['article']['id']); ?>
						</p>
						<ul class="pub-details">
							<?php avatar_display_post_date($homepage_article['article']['id'], $single = false); ?>
						</ul>
						<?php
                        if ((($acf_article_sponsor !== null) && ($acf_article_sponsor > 0))) {
                            avatar_display_post_sponsor($homepage_article['article']['id'], false);
                        }
		            ?>
					</div>
					<?php if (($article_type == 'brand') || (($acf_article_sponsor !== null) && ($acf_article_sponsor > 0))) {
					    echo '</div>';
					} ?>
				</div>
			<?php }
		        if ($key == 1) {
		            //2 second article
		            ?>
				<div class="col-sm-4 secondary-featured">
					<div class="text-content text-content--border-bottom <?php if (($article_type == 'brand') || (($acf_article_sponsor !== null) && ($acf_article_sponsor > 0))) {
					    echo ' sponsor-bg';
					} ?>">
						<h2 class="text-content__title text-content__title--xbig icons <?php echo avatar_article_get_icon($homepage_article['article']['id']); ?>">
							<a class="text-content__link" href="<?php echo get_permalink($homepage_article['article']['id']); ?>">
								<?php echo get_the_title($homepage_article['article']['id']); ?>
							</a>
						</h2>
						<p class="text-content__excerpt">
							<?php echo get_the_excerpt($homepage_article['article']['id']); ?>
						</p>
						<ul class="pub-details">
							<?php avatar_display_post_date($homepage_article['article']['id'], $single = false); ?>
						</ul>
						<?php
					    if ((($acf_article_sponsor !== null) && ($acf_article_sponsor > 0))) {
					        avatar_display_post_sponsor($homepage_article['article']['id'], false);
					    }
		            ?>
						<?php
		            if (array_key_exists('homepage_r_linked_article', $homepage_article)) { ?>
							<ul class="related">
								<?php
		                    foreach ($homepage_article['homepage_r_linked_article'] as $key_r_linked_article => $homepage_r_linked_article) { ?>
									<li>
										<a href="<?php echo get_permalink($homepage_r_linked_article['id']); ?>">
											<?php echo get_the_title($homepage_r_linked_article['id']); ?>
										</a>
									</li>
								<?php } ?>
							</ul>
						<?php } ?>
					</div>
				<?php }
		        if ($key == 2) {
		            //3 third article
		            ?>
					<div class="text-content <?php if (($article_type == 'brand') || (($acf_article_sponsor !== null) && ($acf_article_sponsor > 0))) {
					    echo ' sponsor-bg';
					} ?>">
						<?php $article_icon = avatar_article_get_icon($homepage_article['article']['id']); ?>
						<h2 class="text-content__title text-content__title--xbig icons <?php echo avatar_article_get_icon($homepage_article['article']['id']); ?>">
							<a class="text-content__link" href="<?php echo get_permalink($homepage_article['article']['id']); ?>">
								<?php echo get_the_title($homepage_article['article']['id']); ?>
							</a>
						</h2>
						<p class="text-content__excerpt"><?php echo get_the_excerpt($homepage_article['article']['id']); ?></p>
						<ul class="pub-details">
							<?php avatar_display_post_date($homepage_article['article']['id'], $single = false); ?>
						</ul>
						<?php
					    if ((($acf_article_sponsor !== null) && ($acf_article_sponsor > 0))) {
					        avatar_display_post_sponsor($homepage_article['article']['id'], false);
					    }
		            ?>
						<?php
		            if (array_key_exists('homepage_r_linked_article', $homepage_article)) { ?>
							<ul class="related">
								<?php
		                    foreach ($homepage_article['homepage_r_linked_article'] as $key_r_linked_article => $homepage_r_linked_article) { ?>
									<li><a href="<?php echo get_permalink($homepage_r_linked_article['id']); ?>"><?php echo get_the_title($homepage_r_linked_article['id']); ?></a></li>
								<?php } ?>
							</ul>
						<?php } ?>
					</div>
				</div>
			</div>
			<?php //end 1 - 2 - 3 articles
            }
		        if ($key >= 3) {
		            if ($j % 2 == 0) { ?>
				<div class="row">
				<?php } ?>
				<?php if ($key == 3 && get_locale() == 'fr_CA') { ?>
					<div class="col-sm-6 split">
						<style>
							.native-box {
								background-color: #eee;
								padding: 12px 0 12px 8px;
								width: 100%;
								display: flex;
								justify-content: space-between;
								font-family: "Roboto", sans-serif, Helvetica, Arial, sans-serif;
							}

							.native-box a:hover {
								cursor: pointer;
							}

							.native-box .sponsored-label {
								color: #333;
								display: block;
								text-decoration: none;
								font-size: 11px;
							}

							.native-box .sponsored-label:hover {
								text-decoration: underline;
							}

							.native-box .article-title {
								display: block;
								margin: 8px 0;
								font-family: "Roboto", sans-serif, Helvetica, Arial, sans-serif;
								font-weight: 700;
								line-height: 20px;
								font-size: 16px;
							}

							.native-box .article-title {
								color: #000;
								text-decoration: none;
							}

							.native-box .article-title:hover {
								color: #ed1c24;
							}

							.native-box .native-img-container {
								margin-left: 8px;
								padding-right: 16px;
								display: flex;
								align-items: center;
							}
						</style>
						<div class="native-box">
							<div>
								<a class="sponsored-label" href="http://pubads.g.doubleclick.net/gampad/clk?id=6222876606&iu=/4916/tc.fr.eco.biz_avantages">COMMANDITÉ PAR ALEXION ASTRAZENECA RARE DISEASE ET TAKEDA</a>
								<a class="article-title" href="http://pubads.g.doubleclick.net/gampad/clk?id=6222876606&iu=/4916/tc.fr.eco.biz_avantages">Guide sur les maladies rares à l’intention des promoteurs de régime
								</a>
							</div>

							<div class="native-img-container">
								<a href="http://pubads.g.doubleclick.net/gampad/clk?id=6222876606&iu=/4916/tc.fr.eco.biz_avantages">
									<img width="90" src="https://www.avantages.ca/wp-content/uploads/sites/6/2023/02/PSGRD_francais_BigBox_300x250.jpg" />
								</a>
							</div>
						</div>
					</div>
				<?php
				} else {
				    ?>
					<div class="col-sm-6 split">
						<div class="text-content text-content--border-top <?php if (($article_type == 'brand') || (($acf_article_sponsor !== null) && ($acf_article_sponsor > 0))) {
						    echo ' sponsor-bg';
						} ?>">
							<?php $image_col = isset($homepage_article['article']['featured_image']) ? true : false; ?>
							<div class="after-clear">
								<?php if ($image_col) { ?>
									<figure class="text-content__figure-right">
										<a href="<?php echo get_permalink($homepage_article['article']['id']); ?>">
											<?php echo get_the_post_thumbnail($homepage_article['article']['id'], 'thumbnail', ['class' => 'img-responsive']); ?>
										</a>
									</figure>
								<?php } ?>
								<?php avatar_display_post_category($homepage_article['article']['id'], $single = false); ?>
								<h2 class="text-content__title  icons <?php echo avatar_article_get_icon($homepage_article['article']['id']); ?>">
									<a class="text-content__link" href="<?php echo get_permalink($homepage_article['article']['id']); ?>"><?php echo get_the_title($homepage_article['article']['id']); ?></a>
								</h2>
								<p class="text-content__excerpt"><?php echo get_the_excerpt($homepage_article['article']['id']); ?></p>
								<ul class="pub-details">
									<?php avatar_display_post_author($homepage_article['article']['id'], $single = false); ?>
									<?php avatar_display_post_source($homepage_article['article']['id'], $single = false); ?>
									<?php avatar_display_post_date($homepage_article['article']['id'], $single = false); ?>
								</ul>
								<?php
						        if ((($acf_article_sponsor !== null) && ($acf_article_sponsor > 0))) {
						            avatar_display_post_sponsor($homepage_article['article']['id'], false);
						        }
				    ?>
							</div>
						</div>
						<?php
				        if (array_key_exists('homepage_r_linked_article', $homepage_article)) { ?>
							<ul class="related">
								<?php
				    foreach ($homepage_article['homepage_r_linked_article'] as $key_r_linked_article => $homepage_r_linked_article) { ?>
									<li><a href="<?php echo get_permalink($homepage_r_linked_article['id']); ?>"><?php echo get_the_title($homepage_r_linked_article['id']); ?></a></li>
								<?php } ?>
							</ul>
						<?php }
				        ?>
					</div>
				<?php
				}
		            ?>


	<?php
		            if ($j % 2 == 1) {
		                // if odd
		                echo '</div>';
		            }
		            $j++;
		            if ((count($avatar_homepage_articles) == $key + 1) && ($key % 2 == 1)) {
		                //if even
		                echo '</div>';
		            }
		        }
		    }
		}
		?>
	<!-- end 2 column listing -->