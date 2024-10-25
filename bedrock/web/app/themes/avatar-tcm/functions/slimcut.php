<?php
if (! function_exists('avatar_add_slimcut_script')) {
    function avatar_add_slimcut_script()
    {
        ?>
        <script src="https://s3.us-west-2.amazonaws.com/application-mia-player-prod.rubiconproject.com/pub.js" data-publisher-id="66130"></script>
<?php
    }
    add_action('wp_head', 'avatar_add_slimcut_script');
}

?>