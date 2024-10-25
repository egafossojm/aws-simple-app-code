<?php get_header(); ?>
<style>
body {
	font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen-Sans,Ubuntu,Cantarell,"Helvetica Neue",sans-serif;
}
.main {
	margin: auto auto;
	width: 40%;
	padding: 10rem 0;
}
ol {
	counter-reset: li;
	list-style: none;
	*list-style: decimal;
	font: 15px;
	padding: 0;
	margin-bottom: 4em;
	text-shadow: 0 1px 0 rgba(255,255,255,.5);
}

ol ol {
	margin: 0 0 0 2em;
}
.rounded-list a{
	position: relative;
	display: block;
	padding: 1rem 1rem 1rem 2rem;
	*padding: .4rem;
	margin: .5rem 0;
	background: #ddd;
	color: #444;
	text-decoration: none;
	border-radius: .3rem;
	transition: all .3s ease-out;
}

.rounded-list a:hover{
	background: #eee;
}

.rounded-list a:hover:before{
	transform: rotate(360deg);
}

.rounded-list a:before{
	content: counter(li);
	counter-increment: li;
	position: absolute;
	left: -1.3rem;
	top: 50%;
	margin-top: -1.5rem;
	background: #fff;
	height: 2.4rem;
	width: 2.4rem;
	line-height: 2rem;
	border: .3rem solid #fff;
	text-align: center;
	font-weight: bold;
	border-radius: 3rem;
	transition: all .3s ease-out;
}
</style>

<div class="main">
	<?php if (is_multisite()) { ?>
		<h1><?php _e('Avatar multisite is enabled', '_avatar'); ?></h1>
		<ol class="rounded-list">
			<?php
                $avatar_sites = get_sites();
	    foreach ($avatar_sites as $site) {
	        $site_id = $site->blog_id;
	        $site_name = get_blog_details($site_id)->blogname;
	        $site_url = get_blog_details($site_id)->siteurl;
	        $site_post = get_blog_details($site_id)->post_count ? '('.get_blog_details($site_id)->post_count.' posts)' : '';
	        echo '<li><a href="'.$site_url.'">Site ID: '.$site_id.' - <b>'.$site_name.'</b> '.$site_post.' </a></li>';
	    }
	    ?>
		</ol>
	<?php } else { ?>
		<?php _e('Multisite is not enabled', '_avatar'); ?>
	<?php } ?>
</div>



<?php get_footer(); ?>