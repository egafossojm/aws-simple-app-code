<?php
/* -------------------------------------------------------------
 * MOD array for DI
 * ============================================================*/

function avatar_user_arr_for_di($registration_data_array)
{

    if (isset($registration_data_array)) {

        if (array_key_exists('licensed_to_sell', $registration_data_array)) {
            if ($registration_data_array['licensed_to_sell'] == 'yes') {
                $registration_data_array['f_role_in_firm'] = '';
            } else {
                $registration_data_array['f_product_sell'] = '';
            }
        }
        $di_data = [];

        foreach ($registration_data_array as $key => $value) {

            // opt-in
            while (have_rows('acf_newsletter', 'option')) {
                the_row();
                $id = get_sub_field('acf_newsletter_id');
                if ($key == $id) {
                    $di_data[$key] = $value;
                }
            }
            while (have_rows('acf_opt_in', 'option')) {
                the_row();
                $id = get_sub_field('acf_opt_in_id');
                if ($key == $id) {
                    $di_data[$key] = $value;
                }
            }
            if ($key == $avatar_optin_newspaper = get_field('acf_newspaper', 'option')) {
                $di_data[$key] = $value;
            }

            //
            switch ($key) {
                case 'f_EMail':
                    $di_data[$key] = sanitize_email(trim($value)); //keep these as is
                    break;
                case 'f_FirstName':
                case 'f_LastName':
                case 'f_Company':
                case 'f_Gender':
                case 'f_Birthdate_Year':
                case 'f_Title':
                case 'f_JobTitle':
                case 'f_Source':
                case 'f_Company':
                case 'f_CompanyName':
                case 'f_PrimaryOccupation':
                    // case 'f_PrimaryOccupation_Other':
                case 'f_Years_Experience':
                case 'f_AssetUnderManagement':
                case 'f_NumberOfFamiliesServed':
                case 'f_UnitNumber':
                case 'f_BusinessAddress':
                case 'f_Address1':
                case 'f_Address2':
                case 'f_PostalCode':
                case 'f_Country':
                case 'f_ProvinceState':
                case 'f_Province':
                case 'f_City':
                case 'f_Telephone':
                case 'f_TelephoneNumber':
                case 'f_lastQualificationdate':
                case 'f_PlanSponsor_Ben':
                case 'f_PlanSponsor_BenDecision':
                case 'f_PlanSponsor_Pen':
                case 'f_PlanSponsor_PenDecision':
                case 'f_BEN_JobTitleChoice':
                case 'f_KR_EmployeesSize':
                case 'f_BN_BusinessIndus2019':
                    // case 'f_CompletedCourses_Other':
                    // case 'f_ProfOrganizations_Other':
                    $di_data[$key] = sanitize_text_field(trim(stripslashes_deep($value))); //keep these as is
                    break;
                    // case 'optin_OptInPartnerIE':
                    // case 'optin_IE_Offers':
                    // case 'OptInTranscontinentalIE':
                    // case 'optin_NewspaperIE':
                    // case 'optin_NewsletterIE_AM':
                    // case 'optin_NewsletterIE_PM':
                    // case 'optin_NewsletterIE_Weekly':
                    // case 'optin_NewsletterIE_Monthly':
                    // // FI
                    // case 'optin_fi':
                    // case 'optin_cyberbulletin':
                    // case 'optin_FI_Releve':
                    // case 'optin_special':
                    // case 'optin_Optin_Transcontinental':

                case 'optin_optin_BECA_Newsletter':
                case 'optin_optin_BECA_3rd_Part_Spons':
                case 'optin_optin_BECA_Events':
                case 'optin_optin_BECA_Free_Content':
                case 'optin_optin_BECA_Research':
                case 'optin_optin_BECA_Special_Offers':
                case 'optin_optin_BECA_Conf_Hl':
                case 'dtOptin_dtOptin_BECA_Newsletter':
                case 'dtOptin_dtOptin_BECA_3rd_Pt_Spons':
                case 'dtOptin_dtOptin_BECA_Events':
                case 'dtOptin_dtOptin_BECA_Free_Content':
                case 'dtOptin_dtOptin_BECA_Research':
                case 'dtOptin_dtOptin_BECA_Spl_Offers':
                case 'dtOptin_dtOptin_BECA_Conf_Hl':
                case 'optin_optin_CIR_Newsletter':
                case 'dtOptin_dtOptin_CIR_Newsletter':
                case 'optin_optin_CIR_3rd_Party_Spon':
                case 'dtOptin_dtOptin_CIR_3rd_Party_Spon':
                case 'optin_optin_CIR_Events':
                case 'dtOptin_dtOptin_CIR_Events':
                case 'optin_optin_CIR_Free_Content':
                case 'dtOptin_dtOptin_CIR_Free_Content':
                case 'optin_optin_CIR_Research':
                case 'dtOptin_dtOptin_CIR_Research':
                case 'optin_optin_CIR_Special_Offers':
                case 'dtOptin_dtOptin_CIR_Special_Offers':
                case 'optin_optin_BECA_Conf_Hl':
                case 'dtOptin_dtOptin_BECE_Print':
                case 'optin_optin_BECA_Print':
                    $di_data[$key] = $value; //keep these as is
                    break;
                case 'f_product_sell':
                case 'f_role_in_firm':
                case 'f_CompletedCourses':
                case 'f_ProfOrganizations':

                    if (is_array($value)) {
                        $imploded_value = implode('|', $value);
                        $di_data[$key] = sanitize_text_field(trim($imploded_value));
                    } else {
                        $di_data[$key] = sanitize_text_field(trim($value));
                    }
                    break;
                default: // ignore any other fields

            }
        }

        //error_log('--------------------');
        //error_log(print_r($di_data,true));
        //error_log('--------------------');

        return $di_data;
    }
}

/* -------------------------------------------------------------
 * Create DI user
 * ============================================================*/

if (! function_exists('avatar_create_user_di')) {

    function avatar_create_user_di($registration_data_array, $method = 'Insert')
    {

        $di_data = avatar_user_arr_for_di($registration_data_array);

        //error_log(print_r($di_data, true));
        //Build the record
        $aRecord['Records'][] = [
            'ID' => ['key_f_EMail' => $di_data['f_EMail']],
            'Data' => $di_data,
        ];

        try {
            //Call the service DI
            $diObject = new DialogInsight;
            $status = $diObject->callWebService($diObject->getContact_Merge_Json($aRecord, $method));
            $records = $status->Records;
            $id_object = $records[0];
            $id_di = $id_object->IdRecord;

            return $id_di;
        } catch (Exception $e) {
            error_log($e->getMessage());

            return 0;
        }

    }

}

/* -------------------------------------------------------------
 * Update user DI profile
 * ============================================================*/

if (! function_exists('avatar_update_user_di')) {

    function avatar_update_user_di($registration_data_array, $email)
    {

        //Build the record
        $aRecord['Records'][] = [
            'ID' => ['key_f_EMail' => $email],
            'Data' => $registration_data_array,
        ];

        try {
            //Call the service DI
            $diObject = new DialogInsight;
            $status = $diObject->callWebService($diObject->getContact_Merge_Json($aRecord, 'Insert'));
            $records = $status->Records;
            $id_object = $records[0];
            $id_di = $id_object->IdRecord;

            return $id_di;
        } catch (Exception $e) {
            error_log($e->getMessage());

            return 0;
        }
    }

}

/* -------------------------------------------------------------
 * Update Profile
 * ============================================================*/

if (! function_exists('avatar_update_user_profile')) {

    function avatar_update_user_profile($registration_data_array, $email)
    {

        $di_data = avatar_user_arr_for_di($registration_data_array);
        //Build the record
        $aRecord['Records'][] = [
            'ID' => ['key_f_EMail' => $email],
            'Data' => $di_data,
        ];
        // print_r($aRecord);

        try {
            //Call the service DI
            $diObject = new DialogInsight;
            $status = $diObject->callWebService($diObject->getContact_Merge_Json($aRecord, 'Insert'));
            $records = $status->Records;
            $id_object = $records[0];
            $id_di = $id_object->IdRecord;

            return $id_di;
        } catch (Exception $e) {
            error_log($e->getMessage());

            return 0;
        }

    }

}

/* -------------------------------------------------------------
 * Get user info from DI by Email
 * ============================================================*/

function avatar_get_user_info_di($email)
{

    try {
        //Call the service DI
        $diObject = new DialogInsight;
        $status = $diObject->getContact_Data_Json($email);

        return $status;
    } catch (Exception $e) {
        error_log($e->getMessage());

        return 0;
    }
}

/* -------------------------------------------------------------
 * Create and send DI message
 * ============================================================*/

function avatar_send_message_di($subject, $url, $params, $method = 'insert')
{

    $diObject = new DialogInsight;

    $response = wp_remote_get($url);

    $idMessage = avatar_create_message_di($subject, $response['body'], $params, $method, $diObject);

    $idFilter = $params['id_filter'];

    if (isset($idFilter)) {
        $result = $diObject->getSendMessage_Json($idMessage, $params['sending_date'], $idFilter);
    } else {
        $result = $diObject->getSendMessage_Json($idMessage, $params['sending_date']);
    }

}

function avatar_create_message_di($subject, $message, $params, $method, $diObject)
{
    $message = avatar_removeMetaCharset($message); // Cette méthode interprète les paramètres entre guillemets des URL comme «href»
    $senderMail = getCorrectSenderMail($params);

    $aMessage['Message'] = [
        'Name' => AVATAR_DIALOG_INSIGHT_SENDER_NAME[get_field('acf_newsletter_template')['value']].' '.$params['sending_date'],
        'isHostingImages' => false,
        'isTrackingLinks' => true,
        'idCategory' => $params['communication_type'],
        'MessageVersions' => [0 => [
            'Name' => 'Version1',
            'Culture' => get_bloginfo('language'),
            'SenderName' => $params['sender_name'],
            'SenderEMail' => $senderMail,
            'Subject' => $subject,
            'Subject_TellAFriend' => null,
            'ReplyToEMail' => AVATAR_DIALOG_INSIGHT_REPLY_TO_EMAIL,
            'PredicateExpression' => '',
            'MustMatchPredicateExpression' => false,
            'MessageBodies' => [0 => [
                'MIMEType' => 'text/html',
                'Content' => $message],
            ],
        ],
        ],
        'QuerySources' => null,

    ];

    return $diObject->getCreateMessage_Json($aMessage);
}

function getCorrectSenderMail($params)
{
    $senderName = AVATAR_DIALOG_INSIGHT_SENDER_NAME[get_field('acf_newsletter_template')['value']].' '.$params['sending_date'];

    if (strpos($senderName, 'Canadian Investment Review') !== false) {
        return CIR_AVATAR_DIALOG_INSIGHT_SENDER_EMAIL;
    }

    return AVATAR_DIALOG_INSIGHT_SENDER_EMAIL;
}

function avatar_removeMetaCharset($html)
{
    $doc = new \DOMDocument('1.0', 'utf-8');
    libxml_use_internal_errors(true);
    error_log('encoding: '.$doc->encoding);
    $doc->loadHTML($html);
    $xpath = new \DOMXPath($doc);
    $nlist = $xpath->query("//meta[@content='text/html; charset=UTF-8']");
    $node = $nlist->item(0);
    if (isset($node)) {
        $node->parentNode->removeChild($node);

        return $doc->saveHTML();
    } else {
        return $html;
    }
}

/* -------------------------------------------------------------
 * Add user ID from DI if dosent exist
 * ============================================================*/
if (! function_exists('avatar_add_diid')) {
    function avatar_add_diid($user_id)
    {

        $diid = get_user_meta($user_id->ID, AVATAR_DIALOG_INSIGHT_BD_ID, true);
        if (empty($diid)) {

            $di_data['f_EMail'] = $user_id->user_email;
            $di_data['f_FirstName'] = $user_id->first_name;
            $di_data['f_LastName'] = $user_id->last_name;

            if (! empty($di_data)) {
                $send_to_di = avatar_create_user_di($di_data, 'Insert');

                if ($send_to_di) {
                    update_user_meta($user_id->ID, AVATAR_DIALOG_INSIGHT_BD_ID, $send_to_di);
                }
            }
        }
    }
}

if (! function_exists('bool_as_string')) {
    function bool_as_string($raw_bool)
    {
        settype($raw_bool, 'bool');
        if ($raw_bool) {
            return 'true';
        } else {
            return 'false';
        }
    }

}

if (! function_exists('avatarie_update_profile_ie_email_body')) {

    function avatarie_update_profile_ie_email_body($contact_data)
    {

        $diid = $contact_data['id_contact'];
        $fEmail = $contact_data['f_EMail'];
        $first_name = $contact_data['f_FirstName'];
        $last_name = $contact_data['f_LastName'];
        $gender = $contact_data['f_Gender'];
        $year_birth = $contact_data['f_Birthdate_Year'];

        $job_title = $contact_data['f_Title'];
        $company_name = $contact_data['f_Company'];
        $experience = $contact_data['f_Years_Experience'];
        $sell = $contact_data['f_product_sell'];
        $role_firm = $contact_data['f_role_in_firm'];
        $asset = $contact_data['f_AssetUnderManagement'];
        $families = $contact_data['f_NumberOfFamiliesServed'];

        $address = $contact_data['f_BusinessAddress'];
        $unit_number = $contact_data['f_UnitNumber'];
        $city = $contact_data['f_City'];
        $country = $contact_data['f_Country'];
        $prov = $contact_data['f_ProvinceState'];
        $postal = $contact_data['f_PostalCode'];
        $phone = $contact_data['f_Telephone'];
        $locale = get_locale();

        $courses = $contact_data['f_CompletedCourses'];
        $organization = $contact_data['f_ProfOrganizations'];

        $email_profile = <<<EOD
<html><head>
<meta http-equiv=3D"Content-Type" content=3D"text/html; charset=3D"utf-8">
</head>
<body>
<p>Hi, </p>
<p>The following user (DI id = $diid) has update his profile<br>
<br>
</p>
<p>Please make sure that his profile information is updated. </p>
<p>
Email: $fEmail <br>
First name: $first_name <br>
Last name: $last_name <br>
Gender: $gender <br>
Year of birth: $year_birth <br>
</p>
<p>
Job title: $job_title <br>
Company name: $company_name <br>
Years of Experience: $experience <br>
Role in firm?: $role_firm <br>
What do you sell?: $sell <br>
Asset under management: $asset <br>
Number of families served: $families <br>
</p>
<p>
Business address: $address <br>
Unit number: $unit_number <br>
City: $city <br>
Country: $country <br>
Province / state: $prov <br>
Postal code / zip code: $postal <br>
Telephone: $phone <br>
Locale: $locale <br>
</p>
<p>
Designations / Completed Courses: $courses <br>
Professionnal Organizations: $organization <br>
</p>
</body>
</html>
EOD;

        return $email_profile;
    }
}
