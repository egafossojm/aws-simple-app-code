<?php
if (! function_exists('avatar_add_google_recaptcha_script')) {
    function avatar_add_google_recaptcha_script()
    {
        ?>
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <?php
    }
    add_action('wp_head', 'avatar_add_google_recaptcha_script');
}

?>