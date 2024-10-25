<?php
/**
* Template Name: User : CE Place Login
**/
/* -------------------------------------------------------------
 * Redirect to ceplace website
 * ============================================================*/
if (AVATAR_CE_PLACE_URL != '') {
    $ceplace_redirect_to = AVATAR_CE_PLACE_URL ? AVATAR_CE_PLACE_URL : home_url();
    wp_redirect($ceplace_redirect_to);
    exit;
}
