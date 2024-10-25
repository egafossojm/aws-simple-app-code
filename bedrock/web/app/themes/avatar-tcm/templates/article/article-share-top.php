<?php $mesage_subject = _x('I found this interesting for you!', 'Spaces has to be like this : %20 ', 'avatar-tcm'); ?>
<?php $mesage_body = _x('Hello,', '', 'avatar-tcm').'%0A %0A '._x('I invite you to consult: ', '', 'avatar-tcm').'%0A%0A'.get_the_title().'%0A '.get_the_permalink().' %0A%0A'.
_x(' on the site ', '', 'avatar-tcm').get_bloginfo('name').'. %0A%0A'._x('Have a good day!', '', 'avatar-tcm'); ?>
<dl class="social-icons social-icons--article-header text-right">
	<dt class="social-icons__label">
		<?php _e('Share', 'avatar-tcm'); ?>
	</dt>
	<dd>
		<a class="share-post fb" data-share-url="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>">
			<span><?php _e('Facebook', 'avatar-tcm'); ?></span>
		</a>
	</dd>
	<dd>
		<a class="share-post lkin" data-share-url="https://www.linkedin.com/shareArticle?mini=true&url=<?php the_permalink(); ?>&title=<?php the_title(); ?>&source=<?php bloginfo('name'); ?>">
			<span><?php _e('LinkedIn', 'avatar-tcm'); ?></span>
		</a>
	</dd>
	<dd>
		<a class="share-post twt" data-share-url="http://twitter.com/intent/tweet?text=<?php the_title(); ?>&url=<?php the_permalink(); ?>">
			<span><?php _e('Twitter', 'avatar-tcm'); ?></span>
		</a>
	</dd>
	<dd>
		<a href="mailto:?subject=<?php echo esc_attr($mesage_subject); ?>&amp;body=<?php echo esc_attr($mesage_body); ?>" class="mailto" title="<?php _e('Share by Email', 'avatar-tcm'); ?>" target="_self">
   			<span><?php _e('Mail to a fried', 'avatar-tcm'); ?></span>
   		</a>
   	</dd>
<?php if (is_singular('post')) { ?>
	<dd>
		<a href="javascript:window.print()" class="print">
			<span><?php _e('Print', 'avatar-tcm'); ?></span>
		</a>
	</dd>
<?php } ?>
</dl>