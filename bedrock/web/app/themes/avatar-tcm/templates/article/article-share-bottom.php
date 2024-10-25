<footer class="article-footer">
	<i class="fa fa-share" aria-hidden="true"></i>
	<span><?php _e('Share this article and your comments with peers on social media', 'avatar-tcm'); ?></span>
	<ul class="social-icons">
		<li><a class="share-post fb" data-share-url="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>"><span><?php _e('Facebook', 'avatar-tcm'); ?></span></a></li>
		<li><a class="share-post lkin" data-share-url="https://www.linkedin.com/shareArticle?mini=true&url=<?php the_permalink(); ?>&title=<?php the_title(); ?>&source=<?php bloginfo('name'); ?>"><span><?php _e('LinkedIn', 'avatar-tcm'); ?></span></a></li>
		<li><a class="share-post twt" data-share-url="http://twitter.com/intent/tweet?text=<?php the_title(); ?>&url=<?php the_permalink(); ?>"><span><?php _e('Twitter', 'avatar-tcm'); ?></span></a></li>
	</ul>
</footer>