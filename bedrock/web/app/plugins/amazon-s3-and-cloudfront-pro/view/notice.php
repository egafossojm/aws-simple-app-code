<?php
$type = (isset($type)) ? $type : 'notice-info';
$dismissible = (isset($dismissible)) ? $dismissible : false;
$inline = (isset($inline)) ? $inline : false;
$id = (isset($id)) ? 'id="'.$id.'"' : '';
$style = (isset($style)) ? $style : '';
$auto_p = (isset($auto_p)) ? $auto_p : 'true';
$class = (isset($class)) ? $class : '';
$show_callback = (isset($show_callback) && $show_callback !== false) ? [$GLOBALS[$show_callback[0]], $show_callback[1]] : false;
$callback_args = (isset($callback_args)) ? $callback_args : [];
?>
<div <?php echo $id; ?> class="notice <?php echo $type; ?><?php echo ($dismissible) ? ' is-dismissible' : ''; ?> as3cf-notice <?php echo ($inline) ? ' inline' : ''; ?> <?php echo ($class !== '') ? ' '.$class : ''; ?>" style="<?php echo $style; ?>">
<?php if ($auto_p) { ?>
	<p>
<?php } ?>
		<?php echo $message; // xss ok?>
		<?php if ($show_callback !== false && is_callable($show_callback)) { ?>
			<a href="#" class="as3cf-notice-toggle" data-hide="<?php _e('Hide', 'amazon-s3-and-cloudfront'); ?>"><?php _e('Show', 'amazon-s3-and-cloudfront'); ?></a>
		<?php } ?>
<?php if ($auto_p) { ?>
	</p>
<?php } ?>
<?php if ($show_callback !== false && is_callable($show_callback)) { ?>
	<div class="as3cf-notice-toggle-content" style="display: none;">
		<?php call_user_func_array($show_callback, $callback_args); ?>
	</div>
<?php } ?>
</div>