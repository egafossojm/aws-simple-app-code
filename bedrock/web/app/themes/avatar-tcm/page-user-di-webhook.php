<?php
/**
*Template Name: User : DI Webhook
**/
?>
<?php
//if ( isset( $_REQUEST ) ) {
//error_log('CALLED: Template Name: User : DI Webhook');

$di_content = file_get_contents('php://input');
$bom = pack('H*', 'EFBBBF');
$di_content = preg_replace("/^$bom/", '', $di_content);

$json_profile = json_decode($di_content, true);

if ($json_profile[0]['type'] == 'contact_modified') {

    $user_diid = $json_profile[0]['ContactID']['idContact'];
    $user_email = $json_profile[0]['ContactID']['f_EMail'];
    $user_last = $json_profile[0]['ContactData']['f_LastName'];
    $user_first = $json_profile[0]['ContactData']['f_FirstName'];

    $user_fields = [
        'ID',
        'user_email',
    ];
    $args = [
        'meta_key' => AVATAR_DIALOG_INSIGHT_BD_ID,
        'meta_value' => $user_diid,
        'meta_compare' => '=',
        'number' => 1,
        'fields' => $user_fields,
    ];
    $user_query = new WP_User_Query($args);
    $user = $user_query->get_results();
    //error_log( 'USER: ' . print_r( $user, true ) );
    if (! empty($user)) {

        $user_id = $user[0]->ID;
        //error_log( 'ID: ' . $user_id );
        wp_update_user([
            'ID' => sanitize_text_field($user_id),
            'user_email' => sanitize_email($user_email),
            'first_name' => sanitize_text_field($user_first),
            'last_name' => sanitize_text_field($user_last),
        ]
        );

    }
    status_header(200);
    exit();
}
//}
?>