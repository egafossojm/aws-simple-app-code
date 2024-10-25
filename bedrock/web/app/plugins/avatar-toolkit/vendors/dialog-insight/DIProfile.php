<?php
/**
 * Created by IntelliJ IDEA.
 * User: jutrasj
 * Date: 17-08-24
 * Time: 1:01 PM
 */
class DIProfile
{
    public $id_contact;

    public $first_name;

    public $last_name;

    public $f_Gender;

    public $f_Birthdate_Year;

    public $idtimezone;

    public $work_email;

    public $alternate_email;

    public $f_Title;

    public $f_JobTitle;

    public $f_Company;

    public $f_CompanyName;

    public $f_PrimaryOccupation;

    public $f_PrimaryOccupation_Other;

    public $f_Years_Experience;

    public $firm_description;

    public $what_you_sell;

    public $f_AssetUnderManagement;

    public $f_NumberOfFamiliesServed;

    public $f_BusinessAddress;

    public $f_Address1;

    public $f_Address2;

    public $f_UnitNumber;

    public $f_City;

    public $f_Country;

    public $f_Province;

    public $f_ProvinceState;

    public $f_PostalCode;

    public $f_Telephone;

    public $f_TelephoneNumber;

    public $timezone;

    public $f_CompletedCourses;

    public $f_CompletedCourses_Other;

    public $f_ProfOrganizations;

    public $f_ProfOrganizations_Other;

    public $product_you_sell;

    public $product_you_sell_other;

    public $newsLetter_am;

    public $newsLetter_pm;

    public $newsLetter_weekly;

    public $newsLetter_monthly;

    public $ie_offers;

    public $ie_ce_allerts;

    public $ie_partners;

    public $phone_number;

    public $phone_number_work;

    public $partner_ie;

    public $offers_ie;

    public $licensed_to_sell;

    public $f_product_sell;

    public $f_role_in_firm;

    public $f_PlanSponsor_Ben;

    public $f_PlanSponsor_BenDecision;

    public $f_PlanSponsor_Pen;

    public $f_PlanSponsor_PenDecision;

    public $f_BEN_JobTitleChoice;

    public $f_KR_EmployeesSize;

    public $f_BN_BusinessIndus2019;

    public function __construct($di_json_profile)
    {

        $record = $di_json_profile->Records[0];
        // var_dump($record);

        if (isset($record->idContact)) {
            $this->id_contact = $record->idContact;
        }
        if (isset($record->f_FirstName)) {
            $this->f_FirstName = $record->f_FirstName;
            $this->first_name = $record->f_FirstName;
        }
        if (isset($record->f_LastName)) {
            $this->f_LastName = $record->f_LastName;
            $this->last_name = $record->f_LastName;
        }
        if (isset($record->f_Gender)) {
            $this->f_Gender = $record->f_Gender;
        }
        if (isset($record->f_Birthdate_Year)) {
            $this->f_Birthdate_Year = $record->f_Birthdate_Year;
        }
        // if (isset( $record->idTimeZone ) ) {
        // 	$this->idtimezone 	= $record->idTimeZone;
        // }
        if (isset($record->f_EMail)) {
            $this->work_email = $record->f_EMail;
            $this->f_EMail = $record->f_EMail;
        }
        // if (isset( $record->f_AlternateEmail ) ) {
        // 	$this->alternate_email = $record->f_AlternateEmail;
        // }
        if (isset($record->f_Title)) {
            $this->f_Title = $record->f_Title;
        }
        if (isset($record->f_JobTitle)) {
            $this->f_JobTitle = $record->f_JobTitle;
        }
        if (isset($record->f_Company)) {
            $this->f_Company = $record->f_Company;
        }
        if (isset($record->f_CompanyName)) {
            $this->f_CompanyName = $record->f_CompanyName;
        }
        // if (isset( $record->f_PrimaryOccupation ) ) {
        // 	$this->f_PrimaryOccupation = $record->f_PrimaryOccupation;
        // }
        // if (isset( $record->f_PrimaryOccupation_Other ) ) {
        // 	$this->f_PrimaryOccupation_Other = $record->f_PrimaryOccupation_Other;
        // }
        if (isset($record->f_Years_Experience)) {
            $this->f_Years_Experience = $record->f_Years_Experience;
        }
        // if (isset( $record->f_FirmDescription ) ) {
        // 	$this->firm_description = $record->f_FirmDescription;
        // }
        // if (isset( $record->f_WhatDoYouSell ) ) {
        // 	$this->what_you_sell = $record->f_WhatDoYouSell;
        // }
        if (isset($record->f_AssetUnderManagement)) {
            $this->f_AssetUnderManagement = $record->f_AssetUnderManagement;
        }
        if (isset($record->f_NumberOfFamiliesServed)) {
            $this->f_NumberOfFamiliesServed = $record->f_NumberOfFamiliesServed;
        }
        if (isset($record->f_BusinessAddress)) {
            $this->f_BusinessAddress = $record->f_BusinessAddress;
        }
        if (isset($record->f_Address1)) {
            $this->f_Address1 = $record->f_Address1;
        }
        if (isset($record->f_Address2)) {
            $this->f_Address2 = $record->f_Address2;
        }
        if (isset($record->f_UnitNumber)) {
            $this->f_UnitNumber = $record->f_UnitNumber;
        }
        if (isset($record->f_city)) {
            $this->f_City = $record->f_city;
            $this->f_city = $record->f_city;
        }
        // hack for same ID
        if (isset($record->f_City)) {
            $this->f_City = $record->f_City;
            $this->f_city = $record->f_City;
        }

        if (isset($record->f_country)) {
            $this->f_Country = $record->f_country;
            $this->f_country = $record->f_country;
        }
        // hack for same ID
        if (isset($record->f_Country)) {
            $this->f_Country = $record->f_Country;
            $this->f_country = $record->f_Country;
        }
        if (isset($record->f_Province)) {
            $this->f_Province = $record->f_Province;
        }

        if (isset($record->f_ProvinceState)) {
            $this->f_ProvinceState = $record->f_ProvinceState;
        }
        if (isset($record->f_PostalCode)) {
            $this->f_PostalCode = $record->f_PostalCode;
        }
        if (isset($record->f_Telephone)) {
            $this->f_Telephone = $record->f_Telephone;
        }
        if (isset($record->f_TelephoneNumber)) {
            $this->f_TelephoneNumber = $record->f_TelephoneNumber;
        }

        // if (isset( $record->f_TimeZone ) ) {
        // 	$this->timezone = $record->f_TimeZone;
        // }
        if (isset($record->f_CompletedCourses)) {
            $this->f_CompletedCourses = $record->f_CompletedCourses;
        }

        // if (isset( $record->f_CompletedCourses_Other ) ) {
        // 	$this->f_CompletedCourses_Other = $record->f_CompletedCourses_Other;
        // }
        if (isset($record->f_ProfOrganizations)) {
            $this->f_ProfOrganizations = $record->f_ProfOrganizations;
        }
        // if (isset( $record->f_ProfOrganizations_Other ) ) {
        // 	$this->f_ProfOrganizations_Other = $record->f_ProfOrganizations_Other;
        // }
        // if (isset( $record->f_ProductYouSell ) ) {
        // 	$this->product_you_sell = $record->f_ProductYouSell;
        // }
        // if (isset( $record->f_ProductYouSell_Other ) ) {
        // 	$this->product_you_sell_other = $record->f_ProductYouSell_Other;
        // }
        if (isset($record->f_Telephone)) {
            $this->phone_number = $record->f_Telephone;
        }
        // if (isset( $record->f_Telephone_Work ) ) {
        // 	$this->phone_number_work = $record->f_Telephone_Work;
        // }
        if (isset($record->f_product_sell)) {
            $this->f_product_sell = $record->f_product_sell;
        }
        if (isset($record->f_role_in_firm)) {
            $this->f_role_in_firm = $record->f_role_in_firm;
        }

        // if (isset( $record->optin_CE_Alerts ) ) {
        // 	$this->ie_ce_allerts = $record->optin_CE_Alerts;
        // }

        // IE Optins

        if (isset($record->optin_NewsletterIE_AM)) {
            $this->optin_NewsletterIE_AM = $record->optin_NewsletterIE_AM;
        }
        if (isset($record->optin_NewsletterIE_PM)) {
            $this->optin_NewsletterIE_PM = $record->optin_NewsletterIE_PM;
        }
        if (isset($record->optin_NewsletterIE_Weekly)) {
            $this->optin_NewsletterIE_Weekly = $record->optin_NewsletterIE_Weekly;
        }
        if (isset($record->optin_NewsletterIE_Monthly)) {
            $this->optin_NewsletterIE_Monthly = $record->optin_NewsletterIE_Monthly;
        }
        if (isset($record->optin_NewsletterETF)) {
            $this->optin_NewsletterETF = $record->optin_NewsletterETF;
        }
        if (isset($record->optin_OptInPartnerIE)) {
            $this->optin_OptInPartnerIE = $record->optin_OptInPartnerIE;
        }
        if (isset($record->optin_IE_Offers)) {
            $this->optin_IE_Offers = $record->optin_IE_Offers;
        }
        if (isset($record->optin_NewspaperIE)) {
            $this->optin_NewspaperIE = $record->optin_NewspaperIE;
            if (! avatar_user_have_access()) {
                avatar_user_give_access_to_newspaper();
            }
        }

        // FI Optins

        if (isset($record->optin_fi)) {
            $this->optin_fi = $record->optin_fi;
        }
        if (isset($record->optin_cyberbulletin)) {
            $this->optin_cyberbulletin = $record->optin_cyberbulletin;
        }
        if (isset($record->optin_FI_Releve)) {
            $this->optin_FI_Releve = $record->optin_FI_Releve;
        }
        if (isset($record->optin_Optin_Transcontinental)) {
            $this->optin_Optin_Transcontinental = $record->optin_Optin_Transcontinental;
        }
        if (isset($record->optin_special)) {
            $this->optin_special = $record->optin_special;
        }
        if (isset($record->optin_FNB)) {
            $this->optin_FNB = $record->optin_FNB;
        }
        if (isset($record->optin_JournalFI)) {
            $this->optin_JournalFI = $record->optin_JournalFI;
            if (! avatar_user_have_access()) {
                avatar_user_give_access_to_newspaper();
            }
        }

        // BE Optins

        if (isset($record->optin_optin_BECA_Newsletter)) {
            $this->optin_optin_BECA_Newsletter = $record->optin_optin_BECA_Newsletter;
        }
        if (isset($record->optin_optin_BECA_Events)) {
            $this->optin_optin_BECA_Events = $record->optin_optin_BECA_Events;
        }
        if (isset($record->optin_optin_BECA_3rd_Part_Spons)) {
            $this->optin_optin_BECA_3rd_Part_Spons = $record->optin_optin_BECA_3rd_Part_Spons;
        }
        if (isset($record->optin_optin_BECA_Special_Offers)) {
            $this->optin_optin_BECA_Special_Offers = $record->optin_optin_BECA_Special_Offers;
        }
        if (isset($record->optin_optin_BECA_Print)) {
            $this->optin_optin_BECA_Print = $record->optin_optin_BECA_Print;
        }
        if (isset($record->optin_optin_CIR_Newsletter)) {
            $this->optin_optin_CIR_Newsletter = $record->optin_optin_CIR_Newsletter;
        }
        if (isset($record->optin_optin_CIR_Events)) {
            $this->optin_optin_CIR_Events = $record->optin_optin_CIR_Events;
        }
        if (isset($record->optin_optin_CIR_3rd_Party_Spon)) {
            $this->optin_optin_CIR_3rd_Party_Spon = $record->optin_optin_CIR_3rd_Party_Spon;
        }
        if (isset($record->optin_optin_CIR_Special_Offers)) {
            $this->optin_optin_CIR_Special_Offers = $record->optin_optin_CIR_Special_Offers;
        }

        // More information : BE
        if (isset($record->f_PlanSponsor_Ben)) {
            $this->f_PlanSponsor_Ben = $record->f_PlanSponsor_Ben;
        }

        if (isset($record->f_PlanSponsor_BenDecision)) {
            $this->f_PlanSponsor_BenDecision = $record->f_PlanSponsor_BenDecision;
        }

        if (isset($record->f_PlanSponsor_Pen)) {
            $this->f_PlanSponsor_Pen = $record->f_PlanSponsor_Pen;
        }

        if (isset($record->f_PlanSponsor_PenDecision)) {
            $this->f_PlanSponsor_PenDecision = $record->f_PlanSponsor_PenDecision;
        }

        if (isset($record->f_BEN_JobTitleChoice)) {
            $this->f_BEN_JobTitleChoice = $record->f_BEN_JobTitleChoice;
        }

        if (isset($record->f_KR_EmployeesSize)) {
            $this->f_KR_EmployeesSize = $record->f_KR_EmployeesSize;
        }

        if (isset($record->f_BN_BusinessIndus2019)) {
            $this->f_BN_BusinessIndus2019 = $record->f_BN_BusinessIndus2019;
        }

    }
}
