<?php $mesage_subject = _x('I found this interesting for you!', 'Spaces has to be like this : %20 ', 'avatar-tcm'); ?>
<?php $mesage_body = _x('Hello,%0A %0A %0A
I invite you to consult: '.get_the_title().' - '.get_the_permalink().' on the site Investment Executive%0A%0A
Have a good day!', 'Article title - get_the_title, article URL - get_the_permalink', 'avatar-tcm'); ?>
<dl class="social-icons social-icons--entity-header text-right">
	<dt class="social-icons__label social-icons__label--entity-header">
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
		<a href="mailto:?subject=<?php echo esc_attr($mesage_subject); ?>&amp;body=<?php echo esc_attr($mesage_body); ?>" class="mailto" title="Share by Email" target="_self">
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