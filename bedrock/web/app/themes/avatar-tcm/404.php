<?php
/**
 * Error 404
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 * @since 1.0.0
 *
 * @version 1.0.0
 */
get_header(); ?>
		<article class="base-article">
			<header>
				<h1><?php the_title(); ?> </h1>
			</header>
			<div class="row">
				<section class="col-md-12 error-404 not-found">
					<div class="text-center">
						<header>
							<h1 class=""><?php echo _e('Error 404', 'avatar-tcm') ?></h1>
						</header>
						<p><?php echo _e('It looks like nothing was found at this location. Maybe try a search?', 'avatar-tcm'); ?></p>

						<form class="text-center search-box__form form-inline" action="<?php echo home_url(); ?>">
							<input type="search" name="s" id="search" value="" placeholder="<?php esc_attr_e('Search', 'avatar-tcm'); ?>" class="search-box__input form-control form-control--small-width form-control--sticky no-border-radius"  />
							<input type="hidden" name="post_type" value="post">
							<button type="submit" class="search-box__button btn btn-lg user-form__btn-submit user-form__btn-submit--search no-border-radius component-quick-subscribe-newsletters__button" title="<?php esc_attr_e('Search', 'avatar-tcm'); ?>"><?php esc_attr_e('Search', 'avatar-tcm'); ?></button>
						</form>

					</div>

				</section>
			</div>
		</article>
<?php get_footer(); ?>
