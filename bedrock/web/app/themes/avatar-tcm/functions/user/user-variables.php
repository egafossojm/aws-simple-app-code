<?php
/* -------------------------------------------------------------
 * Variables for User Profile and User Register
 * ============================================================*/
// Important
// 2 -> FI website ID
// 3 -> IE website ID

/* -------------------------------------------------------------
 * All user ID from Dialog Insight
 * ============================================================*/

if (! function_exists('avatar_user_di_ids')) {

    // 2 -> FI website ID
    // 3 -> IE website ID

    function avatar_user_di_ids()
    {
        return [
            'email' => [
                // Email
                2 => 'f_EMail',
                3 => 'f_EMail',
            ],
            'fname' => [
                // First Name
                2 => 'f_FirstName',
                3 => 'f_FirstName',
            ],
            'lname' => [
                2 => 'f_LastName',
                3 => 'f_LastName',
            ],
            'gender' => [
                // Gender
                2 => 'f_Gender',
                3 => 'f_Gender',
            ],
            'birth_year' => [
                // Birthdate Year
                2 => 'f_birth_year',
                3 => 'f_Birthdate_Year',
            ],
            'company' => [
                // Company
                2 => 'f_enterprise',
                3 => 'f_Company',
            ],
            'b_address' => [
                // Business Address
                2 => 'f_address',
                3 => 'f_BusinessAddress',
            ],
            'unit_number' => [
                // Unit Number
                2 => 'f_office_number',
                3 => 'f_UnitNumber',
            ],
            'zipcode' => [
                // Postal Code
                2 => 'f_postal_code',
                3 => 'f_PostalCode',
            ],
            'city' => [
                // City
                2 => 'f_city',
                3 => 'f_City',
            ],
            'state' => [
                // ProvinceState
                2 => 'f_state',
                3 => 'f_ProvinceState',
            ],
            'country' => [
                // Country
                2 => 'f_country',
                3 => 'f_Country',
            ],
            'asset_management' => [
                //
                2 => 'f_renumeration',
                3 => 'f_AssetUnderManagement',
            ],
            'families_served' => [
                // Number of families served
                2 => 'f_NumberOfFamiliesServed',
                3 => 'f_NumberOfFamiliesServed',
            ],
            'phone' => [
                // Telephone
                2 => 'f_phone',
                3 => 'f_Telephone',
            ],
            'job_title' => [
                // Job Title
                2 => 'f_occupation',
                3 => 'f_Title',
            ],
            'product_sell' => [
                // Product Sell
                2 => 'f_ProductYouSell',
                3 => 'f_product_sell',
            ],
            'role_firm' => [
                // Role in firm
                2 => 'f_role_in_firm',
                3 => 'f_role_in_firm',
            ],
            'years_experience' => [
                // Years of Experience
                2 => 'f_annees_experience',
                3 => 'f_Years_Experience',
            ],
            'source' => [
                // Source
                2 => 'f_Source',
                3 => 'f_Source',
            ],
            'completed_courses' => [
                // Your designations / Completed courses
                2 => 'f_CompletedCourses',
                3 => 'f_CompletedCourses',
            ],
            'professional_org' => [
                // Your professional organizations
                2 => 'f_ProfOrganizations',
                3 => 'f_ProfOrganizations',
            ],
        ];
    }
}

/* -------------------------------------------------------------
 * Product Sell Array
 * ============================================================*/

if (! function_exists('avatar_get_product_sell_arr')) {
    /**
     * @return array
     */
    function avatar_get_product_sell_arr()
    {
        $site_id = get_current_blog_id();

        switch ($site_id) {
            case 2:
                $avatar_arr = [
                    0 => [
                        'name' => 'Publicly traded stocks and bonds',
                        'value' => 'Publicly traded stocks and bonds',
                    ],
                    1 => [
                        'name' => 'Mutual funds',
                        'value' => 'Mutual funds',
                    ],
                    2 => [
                        'name' => 'ETFs',
                        'value' => 'ETFs',
                    ],
                    3 => [
                        'name' => 'Insurance products (segregated funds, life insurance, disability insurance, etc.)',
                        'value' => 'Insurance products',
                    ],
                    4 => [
                        'name' => 'Exempt market products',
                        'value' => 'Exempt market products',
                    ],
                    5 => [
                        'name' => 'Banking products (GICs, banking notes, etc.)',
                        'value' => 'Banking products',
                    ],
                    6 => [
                        'name' => 'Options',
                        'value' => 'Options',
                    ],
                    7 => [
                        'name' => 'Futures',
                        'value' => 'Futures',
                    ],
                    8 => [
                        'name' => 'Other',
                        'value' => 'Other',
                    ],
                ];
                break;
            case 3:
            default:
                $avatar_arr = [
                    0 => [
                        'name' => 'Publicly traded stocks and bonds',
                        'value' => 'Publicly traded stocks and bonds',
                    ],
                    1 => [
                        'name' => 'Mutual funds',
                        'value' => 'Mutual funds',
                    ],
                    2 => [
                        'name' => 'ETFs',
                        'value' => 'ETFs',
                    ],
                    3 => [
                        'name' => 'Insurance products (segregated funds, life insurance, disability insurance, etc.)',
                        'value' => 'Insurance products',
                    ],
                    4 => [
                        'name' => 'Exempt market products',
                        'value' => 'Exempt market products',
                    ],
                    5 => [
                        'name' => 'Banking products (GICs, banking notes, etc.)',
                        'value' => 'Banking products',
                    ],
                    6 => [
                        'name' => 'Options',
                        'value' => 'Options',
                    ],
                    7 => [
                        'name' => 'Futures',
                        'value' => 'Futures',
                    ],
                    8 => [
                        'name' => 'Other',
                        'value' => 'Other',
                    ],
                ];
                break;
        }

        return $avatar_arr;
    }
}

/* -------------------------------------------------------------
 * Main responsibility/role within your firm
 * ============================================================*/

if (! function_exists('avatar_get_role_in_firm_arr')) {
    /**
     * @return array
     */
    function avatar_get_role_in_firm_arr()
    {

        $site_id = get_current_blog_id();

        switch ($site_id) {
            case 2:
                $avatar_arr = [
                    0 => [
                        'name' => 'Executive or senior manager',
                        'value' => 'Executive or senior manager',
                    ],
                    1 => [
                        'name' => 'Wholesaler from a product distributor firm',
                        'value' => 'Wholesaler from a product distributor firm',
                    ],
                    2 => [
                        'name' => 'Compliance officer',
                        'value' => 'Compliance officer',
                    ],
                    3 => [
                        'name' => 'Financial planner',
                        'value' => 'Financial planner',
                    ],
                    4 => [
                        'name' => 'Accountant',
                        'value' => 'Accountant',
                    ],
                    5 => [
                        'name' => 'Lawyer',
                        'value' => 'Lawyer',
                    ],
                    6 => [
                        'name' => 'Assistant or support staff',
                        'value' => 'Assistant or support staff',
                    ],
                    7 => [
                        'name' => 'Tax planner',
                        'value' => 'Tax planner',
                    ],
                    8 => [
                        'name' => 'Other',
                        'value' => 'Other',
                    ],
                ];
                break;
            case 3:
            default:
                $avatar_arr = [
                    0 => [
                        'name' => 'Executive or senior manager',
                        'value' => 'Executive or senior manager',
                    ],
                    1 => [
                        'name' => 'Wholesaler from a product distributor firm',
                        'value' => 'Wholesaler from a product distributor firm',
                    ],
                    2 => [
                        'name' => 'Compliance officer',
                        'value' => 'Compliance officer',
                    ],
                    3 => [
                        'name' => 'Financial planner',
                        'value' => 'Financial planner',
                    ],
                    4 => [
                        'name' => 'Accountant',
                        'value' => 'Accountant',
                    ],
                    5 => [
                        'name' => 'Lawyer',
                        'value' => 'Lawyer',
                    ],
                    6 => [
                        'name' => 'Assistant or support staff',
                        'value' => 'Assistant or support staff',
                    ],
                    7 => [
                        'name' => 'Tax planner',
                        'value' => 'Tax planner',
                    ],
                    8 => [
                        'name' => 'Other',
                        'value' => 'Other',
                    ],
                ];
                break;
        }

        return $avatar_arr;
    }
}

/* -------------------------------------------------------------
 *  Primary occupation
 *  @todo delete, not used
 * ============================================================*/

if (! function_exists('avatar_get_primary_occupation_arr')) {
    /**
     * @return array
     */
    function avatar_get_primary_occupation_arr()
    {
        $site_id = get_current_blog_id();

        switch ($site_id) {
            case 2:
                $avatar_arr = [
                    0 => [
                        'name' => 'None',
                        'value' => 'None',
                    ],
                    1 => [
                        'name' => 'Accountant',
                        'value' => 'Accountant',
                    ],
                    2 => [
                        'name' => 'Assistant/Support',
                        'value' => 'Assistant / Support',
                    ],
                    3 => [
                        'name' => 'Bank Investment Sales',
                        'value' => 'Bank Investment Sales',
                    ],
                    4 => [
                        'name' => 'Branch Manager',
                        'value' => 'Branch Manager',
                    ],
                    5 => [
                        'name' => 'Compliance Officer',
                        'value' => 'Compliance Officer',
                    ],
                    6 => [
                        'name' => 'Financial Analyst',
                        'value' => 'Financial Analyst',
                    ],
                    7 => [
                        'name' => 'Financial Planner',
                        'value' => 'Financial Planner',
                    ],
                    8 => [
                        'name' => 'Investment Advisor',
                        'value' => 'Investment Advisor',
                    ],
                    9 => [
                        'name' => 'Insurance Rep',
                        'value' => 'Insurance Rep',
                    ],
                    10 => [
                        'name' => 'Lawyer',
                        'value' => 'Lawyer',
                    ],
                    11 => [
                        'name' => 'Mutual Funds Sales Rep',
                        'value' => 'Mutual Funds Sales Rep',
                    ],
                    12 => [
                        'name' => 'Personal Banker',
                        'value' => 'Personal Banker',
                    ],
                    13 => [
                        'name' => 'Portfolio Manager',
                        'value' => 'Portfolio Manager',
                    ],
                    14 => [
                        'name' => 'Securities Broker',
                        'value' => 'Securities Broker',
                    ],
                    15 => [
                        'name' => 'Wholesaler',
                        'value' => 'Wholesaler',
                    ],
                    16 => [
                        'name' => 'Other',
                        'value' => 'Other',
                    ],
                ];
                break;
            case 3:
            default:
                $avatar_arr = [
                    0 => [
                        'name' => 'None',
                        'value' => 'None',
                    ],
                    1 => [
                        'name' => 'Accountant',
                        'value' => 'Accountant',
                    ],
                    2 => [
                        'name' => 'Assistant/Support',
                        'value' => 'Assistant/ Support',
                    ],
                    3 => [
                        'name' => 'Bank Investment Sales',
                        'value' => 'Bank Investment Sales',
                    ],
                    4 => [
                        'name' => 'Branch Manager',
                        'value' => 'Branch Manager',
                    ],
                    5 => [
                        'name' => 'Compliance Officer',
                        'value' => 'Compliance Officer',
                    ],
                    6 => [
                        'name' => 'Financial Analyst',
                        'value' => 'Financial Analyst',
                    ],
                    7 => [
                        'name' => 'Financial Planner',
                        'value' => 'Financial Planner',
                    ],
                    8 => [
                        'name' => 'Investment Advisor',
                        'value' => 'Investment Advisor',
                    ],
                    9 => [
                        'name' => 'Insurance Rep',
                        'value' => 'Insurance Rep',
                    ],
                    10 => [
                        'name' => 'Lawyer',
                        'value' => 'Lawyer',
                    ],
                    11 => [
                        'name' => 'Mutual Funds Sales Rep',
                        'value' => 'Mutual Funds Sales Rep',
                    ],
                    12 => [
                        'name' => 'Personal Banker',
                        'value' => 'Personal Banker',
                    ],
                    13 => [
                        'name' => 'Portfolio Manager',
                        'value' => 'Portfolio Manager',
                    ],
                    14 => [
                        'name' => 'Securities Broker',
                        'value' => 'Securities Broker',
                    ],
                    15 => [
                        'name' => 'Wholesaler',
                        'value' => 'Wholesaler',
                    ],
                    16 => [
                        'name' => 'Other',
                        'value' => 'Other',
                    ],
                ];
                break;
        }

        return $avatar_arr;
    }
}

/* -------------------------------------------------------------
 * Asset under management
 * ============================================================*/

if (! function_exists('avatar_get_asset_under_management_arr')) {

    function avatar_get_asset_under_management_arr()
    {
        $site_id = get_current_blog_id();

        switch ($site_id) {
            case 2:
                $avatar_arr = [
                    0 => [
                        'name' => 'None',
                        'value' => 'None',
                    ],
                    1 => [
                        'name' => 'Less than $10 million',
                        'value' => 'Under $10 million',
                    ],
                    2 => [
                        'name' => '$10 million to $50 million',
                        'value' => '$10 million to $50 million',
                    ],
                    3 => [
                        'name' => '$50 million to $100 million',
                        'value' => '$50 million to $100 million',
                    ],
                    4 => [
                        'name' => '$100 million to $250 million',
                        'value' => '$100 million to $250 million',
                    ],
                    5 => [
                        'name' => '$250 million or more',
                        'value' => '$250 million or more',
                    ],
                ];
                break;
            case 3:
            default:
                $avatar_arr = [
                    0 => [
                        'name' => 'None',
                        'value' => 'None',
                    ],
                    1 => [
                        'name' => 'Less than $10 million',
                        'value' => 'Under $10 million',
                    ],
                    2 => [
                        'name' => '$10 million to $50 million',
                        'value' => '$10 million to $50 million',
                    ],
                    3 => [
                        'name' => '$50 million to $100 million',
                        'value' => '$50 million to $100 million',
                    ],
                    4 => [
                        'name' => '$100 million to $250 million',
                        'value' => '$100 million to $250 million',
                    ],
                    5 => [
                        'name' => '$250 million or more',
                        'value' => '$250 million or more',
                    ],
                ];
                break;
        }

        return $avatar_arr;
    }
}

/* -------------------------------------------------------------
 * Number of families served
 * ============================================================*/

if (! function_exists('avatar_get_number_families_served_arr')) {

    function avatar_get_number_families_served_arr()
    {
        $site_id = get_current_blog_id();

        switch ($site_id) {
            case 2:
                $avatar_arr = [
                    0 => [
                        'name' => 'None',
                        'value' => 'None',
                    ],
                    1 => [
                        'name' => 'Less than 50',
                        'value' => 'Less 50',
                    ],
                    2 => [
                        'name' => '50 to 99',
                        'value' => '50 to 99',
                    ],
                    3 => [
                        'name' => '100 to 249',
                        'value' => '100 to 249',
                    ],
                    4 => [
                        'name' => '250 to 499',
                        'value' => '250 to 499',
                    ],
                    5 => [
                        'name' => '500 to 999',
                        'value' => '500 to 999',
                    ],
                    6 => [
                        'name' => '1000 or more',
                        'value' => '1000 or more',
                    ],
                ];
                break;
            case 3:
            default:
                $avatar_arr = [
                    0 => [
                        'name' => 'None',
                        'value' => 'None',
                    ],
                    1 => [
                        'name' => 'Less than 50',
                        'value' => 'Less 50',
                    ],
                    2 => [
                        'name' => '50 to 99',
                        'value' => '50 to 99',
                    ],
                    3 => [
                        'name' => '100 to 249',
                        'value' => '100 to 249',
                    ],
                    4 => [
                        'name' => '250 to 499',
                        'value' => '250 to 499',
                    ],
                    5 => [
                        'name' => '500 to 999',
                        'value' => '500 to 999',
                    ],
                    6 => [
                        'name' => '1000 or more',
                        'value' => '1000 or more',
                    ],
                ];
                break;
        }

        return $avatar_arr;
    }
}

/* -------------------------------------------------------------
 * Your designations / Completed courses
 * ============================================================*/

if (! function_exists('avatar_get_prof_designations_arr')) {

    function avatar_get_prof_designations_arr()
    {
        $site_id = get_current_blog_id();

        switch ($site_id) {
            case 2:
                $avatar_arr = [
                    1 => [
                        'name' => 'CFA (Chartered Fin Analyst)',
                        'value' => 'CFA',
                    ],
                    2 => [
                        'name' => 'CFP (Certified Financial Planner)',
                        'value' => 'CFP',
                    ],
                    3 => [
                        'name' => 'CIC (Canadian Insurance Course) Prerequisite to LLQP',
                        'value' => 'CIC LLQP',
                    ],
                    4 => [
                        'name' => 'CIM (Canadian Investment Manager)',
                        'value' => 'CIM',
                    ],
                    5 => [
                        'name' => 'CLU (Chartered Life Underwriter)',
                        'value' => 'CLU',
                    ],
                    6 => [
                        'name' => 'CPH (Conduct & Practices Handbook)',
                        'value' => 'CPH',
                    ],
                    7 => [
                        'name' => 'CSC (Canadian Securities Course)',
                        'value' => 'CSC',
                    ],
                    8 => [
                        'name' => 'CSWP (Chartered Strategic Wealth Professional)',
                        'value' => 'CSWP',
                    ],
                    9 => [
                        'name' => 'IFC (Investment Funds in Canada)',
                        'value' => 'IFC',
                    ],
                    10 => [
                        'name' => 'LLQP (Life License Qualification Program)',
                        'value' => 'LLQP',
                    ],
                    11 => [
                        'name' => 'MFDC (Mutual Fund Dealer Compliance Course)',
                        'value' => 'MFDC',
                    ],
                    12 => [
                        'name' => 'PFP (Personal Financial Planner)',
                        'value' => 'PFP',
                    ],
                    13 => [
                        'name' => 'RFP (Registered Fin Planner)',
                        'value' => 'RFP',
                    ],
                    14 => [
                        'name' => 'WME (Wealth Management Essentials)',
                        'value' => 'WME',
                    ],
                    15 => [
                        'name' => 'Other',
                        'value' => 'Other',
                    ],
                ];
                break;
            case 3:
            default:
                $avatar_arr = [
                    1 => [
                        'name' => 'CFA (Chartered Fin Analyst)',
                        'value' => 'CFA',
                    ],
                    2 => [
                        'name' => 'CFP (Certified Financial Planner)',
                        'value' => 'CFP',
                    ],
                    3 => [
                        'name' => 'CIC (Canadian Insurance Course) Prerequisite to LLQP',
                        'value' => 'CIC LLQP',
                    ],
                    4 => [
                        'name' => 'CIM (Canadian Investment Manager)',
                        'value' => 'CIM',
                    ],
                    5 => [
                        'name' => 'CLU (Chartered Life Underwriter)',
                        'value' => 'CLU',
                    ],
                    6 => [
                        'name' => 'CPH (Conduct & Practices Handbook)',
                        'value' => 'CPH',
                    ],
                    7 => [
                        'name' => 'CSC (Canadian Securities Course)',
                        'value' => 'CSC',
                    ],
                    8 => [
                        'name' => 'CSWP (Chartered Strategic Wealth Professional)',
                        'value' => 'CSWP',
                    ],
                    9 => [
                        'name' => 'IFC (Investment Funds in Canada)',
                        'value' => 'IFC',
                    ],
                    10 => [
                        'name' => 'LLQP (Life License Qualification Program)',
                        'value' => 'LLQP',
                    ],
                    11 => [
                        'name' => 'MFDC (Mutual Fund Dealer Compliance Course)',
                        'value' => 'MFDC',
                    ],
                    12 => [
                        'name' => 'PFP (Personal Financial Planner)',
                        'value' => 'PFP',
                    ],
                    13 => [
                        'name' => 'RFP (Registered Fin Planner)',
                        'value' => 'RFP',
                    ],
                    14 => [
                        'name' => 'WME (Wealth Management Essentials)',
                        'value' => 'WME',
                    ],
                    15 => [
                        'name' => 'Other',
                        'value' => 'Other',
                    ],
                ];
                break;
        }

        return $avatar_arr;
    }
}

/* -------------------------------------------------------------
 * Professional organizations
 * ============================================================*/

if (! function_exists('avatar_get_prof_organizations_arr')) {

    function avatar_get_prof_organizations_arr()
    {
        $site_id = get_current_blog_id();

        switch ($site_id) {
            case 2:
                $avatar_arr = [
                    1 => [
                        'name' => 'AMF Autorité des marchés financiers',
                        'value' => 'AMF',
                    ],
                    2 => [
                        'name' => 'CSF Chambre de la sécurité financière',
                        'value' => 'CSF',
                    ],
                    3 => [
                        'name' => 'CFA ( Institut CFA )',
                        'value' => 'CFA',
                    ],
                    4 => [
                        'name' => 'OCRCVM Organisme canadien de réglementation du commerce des valeurs mobilières',
                        'value' => 'OCRCVM',
                    ],
                    5 => [
                        'name' => 'IQPF institut québécois de planification financière',
                        'value' => 'IQPF',
                    ],
                    6 => [
                        'name' => 'ACCFM Association canadienne ds couritiers de fonds mutuels',
                        'value' => 'ACCFM',
                    ],
                    7 => [
                        'name' => "IFIC ( CFIC ) Conseil des fonds d'investissement du Québec",
                        'value' => 'CSI',
                    ],
                    8 => [
                        'name' => "ACCAP Association canadienne des compagnies d'assurance de personnes",
                        'value' => 'ACCAP',
                    ],

                ];
                break;
            case 3:
            default:
                $avatar_arr = [
                    1 => [
                        'name' => 'Advocis - Financial Advisors Association of Canada',
                        'value' => 'Advocis',
                    ],
                    2 => [
                        'name' => 'AMF - Autorite des Marches Financiers',
                        'value' => 'AMF',
                    ],
                    3 => [
                        'name' => 'British Colombia Securities Commission',
                        'value' => 'British Colombia Securities Commission',
                    ],
                    4 => [
                        'name' => 'CAFC - Canadian Association of Financial Consultants',
                        'value' => 'CAFC',
                    ],
                    5 => [
                        'name' => 'CFA Institute - AIMR (Assoc of Fin Management & Research) CFA',
                        'value' => 'CFA-AIMR-CFA',
                    ],
                    6 => [
                        'name' => 'CSF - Chambre de la securite financiere',
                        'value' => 'CSF',
                    ],
                    7 => [
                        'name' => 'CSI Global Education',
                        'value' => 'CSI',
                    ],
                    8 => [
                        'name' => 'FICO - Financial Insurance Commission of Ontario',
                        'value' => 'FICO',
                    ],
                    9 => [
                        'name' => 'FPSC - Financial Planning Standards Council',
                        'value' => 'FPSC',
                    ],
                    10 => [
                        'name' => 'IAFP - Institute of Advanced Financial Planners',
                        'value' => 'IAFP',
                    ],
                    11 => [
                        'name' => 'IFIC - Investment Funds Institute of Canada',
                        'value' => 'IFIC',
                    ],
                    12 => [
                        'name' => 'IMCA - Investment Management Consultants Association',
                        'value' => 'IMCA',
                    ],
                    13 => [
                        'name' => 'IIROC - Investment Industry Regulatory Organization of Canada',
                        'value' => 'IIROC',
                    ],
                    14 => [
                        'name' => 'Insurance Council of Alberta',
                        'value' => 'Insurance Council of Alberta',
                    ],
                    15 => [
                        'name' => 'Insurance Council of British Colombia',
                        'value' => 'Insurance Council of British Colombia',
                    ],
                    16 => [
                        'name' => 'Insurance Council of Manitoba',
                        'value' => 'Insurance Council of Manitoba',
                    ],
                    17 => [
                        'name' => 'Insurance Council of Saskatchewan',
                        'value' => 'Insurance Council of Saskatchewan',
                    ],
                    18 => [
                        'name' => 'IQPF - Institut quebecois de planification financiere',
                        'value' => 'IQPF',
                    ],
                    19 => [
                        'name' => 'GRMI - Global Risk Management Institute',
                        'value' => 'GRMI',
                    ],
                    20 => [
                        'name' => 'MFDA - Mutual Funds Dealers Association',
                        'value' => 'MFDA',
                    ],
                    21 => [
                        'name' => 'OSC - Ontario Securities Commission',
                        'value' => 'OSC',
                    ],
                    22 => [
                        'name' => 'RIBO (Reg Insurance Brokers of Ontario)',
                        'value' => 'RIBO',
                    ],
                    23 => [
                        'name' => 'Saskatchewan General Insurance Council',
                        'value' => 'Saskatchewan General Insurance Council',
                    ],
                    24 => [
                        'name' => 'Superintendent of Insurance',
                        'value' => 'Superintendent of Insurance',
                    ],
                    25 => [
                        'name' => 'STEP Canada - Society of Trust and Estate Practitioners',
                        'value' => 'STEP',
                    ],
                    26 => [
                        'name' => 'Other',
                        'value' => 'Other',
                    ],
                ];
                break;
        }

        return $avatar_arr;
    }
}

/* -------------------------------------------------------------
 * Years of Experience
 * ============================================================*/

if (! function_exists('avatar_get_years_experience_arr')) {

    function avatar_get_years_experience_arr()
    {
        $site_id = get_current_blog_id();

        switch ($site_id) {
            case 2:
                $avatar_arr = [
                    0 => [
                        'name' => 'None',
                        'value' => 'None',
                    ],
                    1 => [
                        'name' => 'Less than 5 years',
                        'value' => 'Less than 5 years',
                    ],
                    2 => [
                        'name' => '5 to 9 years',
                        'value' => '5 to 9 years',
                    ],
                    3 => [
                        'name' => '10 to 14 years',
                        'value' => '10 to 14 years',
                    ],
                    4 => [
                        'name' => '15 to 19 years',
                        'value' => '15 to 19 years',
                    ],
                    5 => [
                        'name' => '20 years of more',
                        'value' => '20 years of more',
                    ],
                ];
                break;
            case 3:
            default:
                $avatar_arr = [
                    0 => [
                        'name' => 'None',
                        'value' => 'None',
                    ],
                    1 => [
                        'name' => 'Less than 5 years',
                        'value' => 'Less than 5 years',
                    ],
                    2 => [
                        'name' => '5 to 9 years',
                        'value' => '5 to 9 years',
                    ],
                    3 => [
                        'name' => '10 to 14 years',
                        'value' => '10 to 14 years',
                    ],
                    4 => [
                        'name' => '15 to 19 years',
                        'value' => '15 to 19 years',
                    ],
                    5 => [
                        'name' => '20 years of more',
                        'value' => '20 years of more',
                    ],
                ];
                break;
        }

        return $avatar_arr;
    }
}

/* -------------------------------------------------------------
 * Country and State
 * ============================================================*/
/* -------------------------------------------------------------
 * Get states by country
 * ============================================================*/
if (! function_exists('avatar_get_country_states')) {

    function avatar_get_country_states($country = 'CA')
    {
        switch ($country) {
            case 'CA':
                $states = avatar_get_ca_list();
                break;
            case 'US':
                $states = avatar_get_us_list();
                break;
            default:
                $states = [];
                break;
        }

        return $states;
    }
}

/* -------------------------------------------------------------
 * A-Z list of countries
 * ============================================================*/
if (! function_exists('avatar_get_country_list_arr')) {
    function avatar_get_country_list_arr($lang = null)
    {
        if ($lang == 'fr-CA') {
            $countries = [
                '' => '',
                'CA' => 'Canada',
                'US' => 'États-Unis',
                'AF' => 'Afghanistan',
                'ZA' => 'Afrique du Sud',
                'AL' => 'Albanie',
                'DZ' => 'Algérie',
                'DE' => 'Allemagne',
                'AD' => 'Andorre',
                'AO' => 'Angola',
                'AI' => 'Anguilla',
                'AQ' => 'Antarctique',
                'AG' => 'Antigua-et-Barbuda',
                'AN' => 'Antilles néerlandaises',
                'SA' => 'Arabie saoudite',
                'AR' => 'Argentine',
                'AM' => 'Arménie',
                'AW' => 'Aruba',
                'AU' => 'Australie',
                'AT' => 'Autriche',
                'AZ' => 'Azerbaïdjan',
                'BS' => 'Bahamas',
                'BH' => 'Bahreïn',
                'BD' => 'Bangladesh',
                'BB' => 'Barbade',
                'BE' => 'Belgique',
                'BZ' => 'Belize',
                'BM' => 'Bermudes',
                'BT' => 'Bhoutan',
                'BO' => 'Bolivie',
                'BA' => 'Bosnie-Herzégovine',
                'BW' => 'Botswana',
                'BN' => 'Brunéi Darussalam',
                'BR' => 'Brésil',
                'BG' => 'Bulgarie',
                'BF' => 'Burkina Faso',
                'BI' => 'Burundi',
                'BY' => 'Bélarus',
                'BJ' => 'Bénin',
                'KH' => 'Cambodge',
                'CM' => 'Cameroun',
                'CV' => 'Cap-Vert',
                'CL' => 'Chili',
                'CN' => 'Chine',
                'CY' => 'Chypre',
                'CO' => 'Colombie',
                'KM' => 'Comores',
                'CG' => 'Congo',
                'KP' => 'Corée du Nord',
                'KR' => 'Corée du Sud',
                'CR' => 'Costa Rica',
                'HR' => 'Croatie',
                'CU' => 'Cuba',
                'CI' => 'Côte d’Ivoire',
                'DK' => 'Danemark',
                'DJ' => 'Djibouti',
                'DM' => 'Dominique',
                'SV' => 'El Salvador',
                'ES' => 'Espagne',
                'EE' => 'Estonie',
                'FJ' => 'Fidji',
                'FI' => 'Finlande',
                'FR' => 'France',
                'GA' => 'Gabon',
                'GM' => 'Gambie',
                'GH' => 'Ghana',
                'GI' => 'Gibraltar',
                'GD' => 'Grenade',
                'GL' => 'Groenland',
                'GR' => 'Grèce',
                'GP' => 'Guadeloupe',
                'GU' => 'Guam',
                'GT' => 'Guatemala',
                'GG' => 'Guernesey',
                'GN' => 'Guinée',
                'GQ' => 'Guinée équatoriale',
                'GW' => 'Guinée-Bissau',
                'GY' => 'Guyana',
                'GF' => 'Guyane française',
                'GE' => 'Géorgie',
                'GS' => 'Géorgie du Sud et les îles Sandwich du Sud',
                'HT' => 'Haïti',
                'HN' => 'Honduras',
                'HU' => 'Hongrie',
                'IN' => 'Inde',
                'ID' => 'Indonésie',
                'IQ' => 'Irak',
                'IR' => 'Iran',
                'IE' => 'Irlande',
                'IS' => 'Islande',
                'IL' => 'Israël',
                'IT' => 'Italie',
                'JM' => 'Jamaïque',
                'JP' => 'Japon',
                'JE' => 'Jersey',
                'JO' => 'Jordanie',
                'KZ' => 'Kazakhstan',
                'KE' => 'Kenya',
                'KG' => 'Kirghizistan',
                'KI' => 'Kiribati',
                'KW' => 'Koweït',
                'LA' => 'Laos',
                'LS' => 'Lesotho',
                'LV' => 'Lettonie',
                'LB' => 'Liban',
                'LY' => 'Libye',
                'LR' => 'Libéria',
                'LI' => 'Liechtenstein',
                'LT' => 'Lituanie',
                'LU' => 'Luxembourg',
                'MK' => 'Macédoine',
                'MG' => 'Madagascar',
                'MY' => 'Malaisie',
                'MW' => 'Malawi',
                'MV' => 'Maldives',
                'ML' => 'Mali',
                'MT' => 'Malte',
                'MA' => 'Maroc',
                'MQ' => 'Martinique',
                'MU' => 'Maurice',
                'MR' => 'Mauritanie',
                'YT' => 'Mayotte',
                'MX' => 'Mexique',
                'MD' => 'Moldavie',
                'MC' => 'Monaco',
                'MN' => 'Mongolie',
                'MS' => 'Montserrat',
                'ME' => 'Monténégro',
                'MZ' => 'Mozambique',
                'MM' => 'Myanmar',
                'NA' => 'Namibie',
                'NR' => 'Nauru',
                'NI' => 'Nicaragua',
                'NE' => 'Niger',
                'NG' => 'Nigéria',
                'NU' => 'Niue',
                'NO' => 'Norvège',
                'NC' => 'Nouvelle-Calédonie',
                'NZ' => 'Nouvelle-Zélande',
                'NP' => 'Népal',
                'OM' => 'Oman',
                'UG' => 'Ouganda',
                'UZ' => 'Ouzbékistan',
                'PK' => 'Pakistan',
                'PW' => 'Palaos',
                'PA' => 'Panama',
                'PG' => 'Papouasie-Nouvelle-Guinée',
                'PY' => 'Paraguay',
                'NL' => 'Pays-Bas',
                'PH' => 'Philippines',
                'PN' => 'Pitcairn',
                'PL' => 'Pologne',
                'PF' => 'Polynésie française',
                'PR' => 'Porto Rico',
                'PT' => 'Portugal',
                'PE' => 'Pérou',
                'QA' => 'Qatar',
                'HK' => 'R.A.S. chinoise de Hong Kong',
                'MO' => 'R.A.S. chinoise de Macao',
                'RO' => 'Roumanie',
                'GB' => 'Royaume-Uni',
                'RU' => 'Russie',
                'RW' => 'Rwanda',
                'CF' => 'République centrafricaine',
                'DO' => 'République dominicaine',
                'CD' => 'République démocratique du Congo',
                'CZ' => 'République tchèque',
                'RE' => 'Réunion',
                'EH' => 'Sahara occidental',
                'BL' => 'Saint-Barthélémy',
                'KN' => 'Saint-Kitts-et-Nevis',
                'SM' => 'Saint-Marin',
                'MF' => 'Saint-Martin',
                'PM' => 'Saint-Pierre-et-Miquelon',
                'VC' => 'Saint-Vincent-et-les Grenadines',
                'SH' => 'Sainte-Hélène',
                'LC' => 'Sainte-Lucie',
                'WS' => 'Samoa',
                'AS' => 'Samoa américaines',
                'ST' => 'Sao Tomé-et-Principe',
                'RS' => 'Serbie',
                'CS' => 'Serbie-et-Monténégro',
                'SC' => 'Seychelles',
                'SL' => 'Sierra Leone',
                'SG' => 'Singapour',
                'SK' => 'Slovaquie',
                'SI' => 'Slovénie',
                'SO' => 'Somalie',
                'SD' => 'Soudan',
                'LK' => 'Sri Lanka',
                'CH' => 'Suisse',
                'SR' => 'Suriname',
                'SE' => 'Suède',
                'SJ' => 'Svalbard et Île Jan Mayen',
                'SZ' => 'Swaziland',
                'SY' => 'Syrie',
                'SN' => 'Sénégal',
                'TJ' => 'Tadjikistan',
                'TZ' => 'Tanzanie',
                'TW' => 'Taïwan',
                'TD' => 'Tchad',
                'TF' => 'Terres australes françaises',
                'IO' => "Territoire britannique de l'océan Indien",
                'PS' => 'Territoire palestinien',
                'TH' => 'Thaïlande',
                'TL' => 'Timor oriental',
                'TG' => 'Togo',
                'TK' => 'Tokelau',
                'TO' => 'Tonga',
                'TT' => 'Trinité-et-Tobago',
                'TN' => 'Tunisie',
                'TM' => 'Turkménistan',
                'TR' => 'Turquie',
                'TV' => 'Tuvalu',
                'UA' => 'Ukraine',
                'UY' => 'Uruguay',
                'VU' => 'Vanuatu',
                'VE' => 'Venezuela',
                'VN' => 'Viêt Nam',
                'WF' => 'Wallis-et-Futuna',
                'YE' => 'Yémen',
                'ZM' => 'Zambie',
                'ZW' => 'Zimbabwe',
                'ZZ' => 'région indéterminée',
                'EG' => 'Égypte',
                'AE' => 'Émirats arabes unis',
                'EC' => 'Équateur',
                'ER' => 'Érythrée',
                'VA' => 'État de la Cité du Vatican',
                'FM' => 'États fédérés de Micronésie',
                'ET' => 'Éthiopie',
                'BV' => 'Île Bouvet',
                'CX' => 'Île Christmas',
                'NF' => 'Île Norfolk',
                'IM' => 'Île de Man',
                'KY' => 'Îles Caïmans',
                'CC' => 'Îles Cocos - Keeling',
                'CK' => 'Îles Cook',
                'FO' => 'Îles Féroé',
                'HM' => 'Îles Heard et MacDonald',
                'FK' => 'Îles Malouines',
                'MP' => 'Îles Mariannes du Nord',
                'MH' => 'Îles Marshall',
                'UM' => 'Îles Mineures Éloignées des États-Unis',
                'SB' => 'Îles Salomon',
                'TC' => 'Îles Turks et Caïques',
                'VG' => 'Îles Vierges britanniques',
                'VI' => 'Îles Vierges des États-Unis',
                'AX' => 'Îles Åland',
            ];
        } else {
            $countries = [
                '' => '',
                'CA' => 'Canada',
                'US' => 'United States',
                'GB' => 'United Kingdom',
                'AF' => 'Afghanistan',
                'AX' => '&#197;land Islands',
                'AL' => 'Albania',
                'DZ' => 'Algeria',
                'AS' => 'American Samoa',
                'AD' => 'Andorra',
                'AO' => 'Angola',
                'AI' => 'Anguilla',
                'AQ' => 'Antarctica',
                'AG' => 'Antigua and Barbuda',
                'AR' => 'Argentina',
                'AM' => 'Armenia',
                'AW' => 'Aruba',
                'AU' => 'Australia',
                'AT' => 'Austria',
                'AZ' => 'Azerbaijan',
                'BS' => 'Bahamas',
                'BH' => 'Bahrain',
                'BD' => 'Bangladesh',
                'BB' => 'Barbados',
                'BY' => 'Belarus',
                'BE' => 'Belgium',
                'BZ' => 'Belize',
                'BJ' => 'Benin',
                'BM' => 'Bermuda',
                'BT' => 'Bhutan',
                'BO' => 'Bolivia',
                'BQ' => 'Bonaire, Saint Eustatius and Saba',
                'BA' => 'Bosnia and Herzegovina',
                'BW' => 'Botswana',
                'BV' => 'Bouvet Island',
                'BR' => 'Brazil',
                'IO' => 'British Indian Ocean Territory',
                'BN' => 'Brunei Darrussalam',
                'BG' => 'Bulgaria',
                'BF' => 'Burkina Faso',
                'BI' => 'Burundi',
                'KH' => 'Cambodia',
                'CM' => 'Cameroon',
                'CV' => 'Cape Verde',
                'KY' => 'Cayman Islands',
                'CF' => 'Central African Republic',
                'TD' => 'Chad',
                'CL' => 'Chile',
                'CN' => 'China',
                'CX' => 'Christmas Island',
                'CC' => 'Cocos Islands',
                'CO' => 'Colombia',
                'KM' => 'Comoros',
                'CD' => 'Congo, Democratic People\'s Republic',
                'CG' => 'Congo, Republic of',
                'CK' => 'Cook Islands',
                'CR' => 'Costa Rica',
                'CI' => 'Cote d\'Ivoire',
                'HR' => 'Croatia/Hrvatska',
                'CU' => 'Cuba',
                'CW' => 'Cura&Ccedil;ao',
                'CY' => 'Cyprus',
                'CZ' => 'Czechia',
                'DK' => 'Denmark',
                'DJ' => 'Djibouti',
                'DM' => 'Dominica',
                'DO' => 'Dominican Republic',
                'TP' => 'East Timor',
                'EC' => 'Ecuador',
                'EG' => 'Egypt',
                'GQ' => 'Equatorial Guinea',
                'SV' => 'El Salvador',
                'ER' => 'Eritrea',
                'EE' => 'Estonia',
                'ET' => 'Ethiopia',
                'FK' => 'Falkland Islands',
                'FO' => 'Faroe Islands',
                'FJ' => 'Fiji',
                'FI' => 'Finland',
                'FR' => 'France',
                'GF' => 'French Guiana',
                'PF' => 'French Polynesia',
                'TF' => 'French Southern Territories',
                'GA' => 'Gabon',
                'GM' => 'Gambia',
                'GE' => 'Georgia',
                'DE' => 'Germany',
                'GR' => 'Greece',
                'GH' => 'Ghana',
                'GI' => 'Gibraltar',
                'GL' => 'Greenland',
                'GD' => 'Grenada',
                'GP' => 'Guadeloupe',
                'GU' => 'Guam',
                'GT' => 'Guatemala',
                'GG' => 'Guernsey',
                'GN' => 'Guinea',
                'GW' => 'Guinea-Bissau',
                'GY' => 'Guyana',
                'HT' => 'Haiti',
                'HM' => 'Heard and McDonald Islands',
                'VA' => 'Holy See (City Vatican State)',
                'HN' => 'Honduras',
                'HK' => 'Hong Kong',
                'HU' => 'Hungary',
                'IS' => 'Iceland',
                'IN' => 'India',
                'ID' => 'Indonesia',
                'IR' => 'Iran',
                'IQ' => 'Iraq',
                'IE' => 'Ireland',
                'IM' => 'Isle of Man',
                'IL' => 'Israel',
                'IT' => 'Italy',
                'JM' => 'Jamaica',
                'JP' => 'Japan',
                'JE' => 'Jersey',
                'JO' => 'Jordan',
                'KZ' => 'Kazakhstan',
                'KE' => 'Kenya',
                'KI' => 'Kiribati',
                'KW' => 'Kuwait',
                'KG' => 'Kyrgyzstan',
                'LA' => 'Lao People\'s Democratic Republic',
                'LV' => 'Latvia',
                'LB' => 'Lebanon',
                'LS' => 'Lesotho',
                'LR' => 'Liberia',
                'LY' => 'Libyan Arab Jamahiriya',
                'LI' => 'Liechtenstein',
                'LT' => 'Lithuania',
                'LU' => 'Luxembourg',
                'MO' => 'Macau',
                'MK' => 'Macedonia',
                'MG' => 'Madagascar',
                'MW' => 'Malawi',
                'MY' => 'Malaysia',
                'MV' => 'Maldives',
                'ML' => 'Mali',
                'MT' => 'Malta',
                'MH' => 'Marshall Islands',
                'MQ' => 'Martinique',
                'MR' => 'Mauritania',
                'MU' => 'Mauritius',
                'YT' => 'Mayotte',
                'MX' => 'Mexico',
                'FM' => 'Micronesia',
                'MD' => 'Moldova',
                'MC' => 'Monaco',
                'MN' => 'Mongolia',
                'ME' => 'Montenegro',
                'MS' => 'Montserrat',
                'MA' => 'Morocco',
                'MZ' => 'Mozambique',
                'MM' => 'Myanmar',
                'NA' => 'Namibia',
                'NR' => 'Nauru',
                'NP' => 'Nepal',
                'NL' => 'Netherlands',
                'AN' => 'Netherlands Antilles',
                'NC' => 'New Caledonia',
                'NZ' => 'New Zealand',
                'NI' => 'Nicaragua',
                'NE' => 'Niger',
                'NG' => 'Nigeria',
                'NU' => 'Niue',
                'NF' => 'Norfolk Island',
                'KP' => 'North Korea',
                'MP' => 'Northern Mariana Islands',
                'NO' => 'Norway',
                'OM' => 'Oman',
                'PK' => 'Pakistan',
                'PW' => 'Palau',
                'PS' => 'Palestinian Territories',
                'PA' => 'Panama',
                'PG' => 'Papua New Guinea',
                'PY' => 'Paraguay',
                'PE' => 'Peru',
                'PH' => 'Philippines',
                'PN' => 'Pitcairn Island',
                'PL' => 'Poland',
                'PT' => 'Portugal',
                'PR' => 'Puerto Rico',
                'QA' => 'Qatar',
                'XK' => 'Republic of Kosovo',
                'RE' => 'Reunion Island',
                'RO' => 'Romania',
                'RU' => 'Russian Federation',
                'RW' => 'Rwanda',
                'BL' => 'Saint Barth&eacute;lemy',
                'SH' => 'Saint Helena',
                'KN' => 'Saint Kitts and Nevis',
                'LC' => 'Saint Lucia',
                'MF' => 'Saint Martin (French)',
                'SX' => 'Saint Martin (Dutch)',
                'PM' => 'Saint Pierre and Miquelon',
                'VC' => 'Saint Vincent and the Grenadines',
                'SM' => 'San Marino',
                'ST' => 'S&atilde;o Tom&eacute; and Pr&iacute;ncipe',
                'SA' => 'Saudi Arabia',
                'SN' => 'Senegal',
                'RS' => 'Serbia',
                'SC' => 'Seychelles',
                'SL' => 'Sierra Leone',
                'SG' => 'Singapore',
                'SK' => 'Slovak Republic',
                'SI' => 'Slovenia',
                'SB' => 'Solomon Islands',
                'SO' => 'Somalia',
                'ZA' => 'South Africa',
                'GS' => 'South Georgia',
                'KR' => 'South Korea',
                'SS' => 'South Sudan',
                'ES' => 'Spain',
                'LK' => 'Sri Lanka',
                'SD' => 'Sudan',
                'SR' => 'Suriname',
                'SJ' => 'Svalbard and Jan Mayen Islands',
                'SZ' => 'Swaziland',
                'SE' => 'Sweden',
                'CH' => 'Switzerland',
                'SY' => 'Syrian Arab Republic',
                'TW' => 'Taiwan',
                'TJ' => 'Tajikistan',
                'TZ' => 'Tanzania',
                'TH' => 'Thailand',
                'TL' => 'Timor-Leste',
                'TG' => 'Togo',
                'TK' => 'Tokelau',
                'TO' => 'Tonga',
                'TT' => 'Trinidad and Tobago',
                'TN' => 'Tunisia',
                'TR' => 'Turkey',
                'TM' => 'Turkmenistan',
                'TC' => 'Turks and Caicos Islands',
                'TV' => 'Tuvalu',
                'UG' => 'Uganda',
                'UA' => 'Ukraine',
                'AE' => 'United Arab Emirates',
                'UY' => 'Uruguay',
                'UM' => 'US Minor Outlying Islands',
                'UZ' => 'Uzbekistan',
                'VU' => 'Vanuatu',
                'VE' => 'Venezuela',
                'VN' => 'Vietnam',
                'VG' => 'Virgin Islands (British)',
                'VI' => 'Virgin Islands (USA)',
                'WF' => 'Wallis and Futuna Islands',
                'EH' => 'Western Sahara',
                'WS' => 'Western Samoa',
                'YE' => 'Yemen',
                'ZM' => 'Zambia',
                'ZW' => 'Zimbabwe',
            ];
        }

        return $countries;
    }
}

/* -------------------------------------------------------------
 * State/Province CA
 * ============================================================*/
if (! function_exists('avatar_get_ca_list')) {

    function avatar_get_ca_list()
    {
        $provinces = [
            '' => '',
            'AB' => __('Alberta', 'avatar-tcm'),
            'BC' => __('British Columbia', 'avatar-tcm'),
            'MB' => __('Manitoba', 'avatar-tcm'),
            'NB' => __('New Brunswick', 'avatar-tcm'),
            'NL' => __('Newfoundland and Labrador', 'avatar-tcm'),
            'NS' => __('Nova Scotia', 'avatar-tcm'),
            'NT' => __('Northwest Territories', 'avatar-tcm'),
            'NU' => __('Nunavut', 'avatar-tcm'),
            'ON' => __('Ontario', 'avatar-tcm'),
            'PE' => __('Prince Edward Island', 'avatar-tcm'),
            'QC' => __('Quebec', 'avatar-tcm'),
            'SK' => __('Saskatchewan', 'avatar-tcm'),
            'YT' => __('Yukon', 'avatar-tcm'),
        ];

        return $provinces;
    }
}

/* -------------------------------------------------------------
 * State/Province US
 * ============================================================*/

if (! function_exists('avatar_get_us_list')) {
    function avatar_get_us_list()
    {
        $states = [
            '' => '',
            'AL' => __('Alabama', 'avatar-tcm'),
            'AK' => __('Alaska', 'avatar-tcm'),
            'AZ' => __('Arizona', 'avatar-tcm'),
            'AR' => __('Arkansas', 'avatar-tcm'),
            'CA' => __('California', 'avatar-tcm'),
            'CO' => __('Colorado', 'avatar-tcm'),
            'CT' => __('Connecticut', 'avatar-tcm'),
            'DE' => __('Delaware', 'avatar-tcm'),
            'DC' => __('District of Columbia', 'avatar-tcm'),
            'FL' => __('Florida', 'avatar-tcm'),
            'GA' => __('Georgia', 'avatar-tcm'),
            'HI' => __('Hawaii', 'avatar-tcm'),
            'ID' => __('Idaho', 'avatar-tcm'),
            'IL' => __('Illinois', 'avatar-tcm'),
            'IN' => __('Indiana', 'avatar-tcm'),
            'IA' => __('Iowa', 'avatar-tcm'),
            'KS' => __('Kansas', 'avatar-tcm'),
            'KY' => __('Kentucky', 'avatar-tcm'),
            'LA' => __('Louisiana', 'avatar-tcm'),
            'ME' => __('Maine', 'avatar-tcm'),
            'MD' => __('Maryland', 'avatar-tcm'),
            'MA' => __('Massachusetts', 'avatar-tcm'),
            'MI' => __('Michigan', 'avatar-tcm'),
            'MN' => __('Minnesota', 'avatar-tcm'),
            'MS' => __('Mississippi', 'avatar-tcm'),
            'MO' => __('Missouri', 'avatar-tcm'),
            'MT' => __('Montana', 'avatar-tcm'),
            'NE' => __('Nebraska', 'avatar-tcm'),
            'NV' => __('Nevada', 'avatar-tcm'),
            'NH' => __('New Hampshire', 'avatar-tcm'),
            'NJ' => __('New Jersey', 'avatar-tcm'),
            'NM' => __('New Mexico', 'avatar-tcm'),
            'NY' => __('New York', 'avatar-tcm'),
            'NC' => __('North Carolina', 'avatar-tcm'),
            'ND' => __('North Dakota', 'avatar-tcm'),
            'OH' => __('Ohio', 'avatar-tcm'),
            'OK' => __('Oklahoma', 'avatar-tcm'),
            'OR' => __('Oregon', 'avatar-tcm'),
            'PA' => __('Pennsylvania', 'avatar-tcm'),
            'RI' => __('Rhode Island', 'avatar-tcm'),
            'SC' => __('South Carolina', 'avatar-tcm'),
            'SD' => __('South Dakota', 'avatar-tcm'),
            'TN' => __('Tennessee', 'avatar-tcm'),
            'TX' => __('Texas', 'avatar-tcm'),
            'UT' => __('Utah', 'avatar-tcm'),
            'VT' => __('Vermont', 'avatar-tcm'),
            'VA' => __('Virginia', 'avatar-tcm'),
            'WA' => __('Washington', 'avatar-tcm'),
            'WV' => __('West Virginia', 'avatar-tcm'),
            'WI' => __('Wisconsin', 'avatar-tcm'),
            'WY' => __('Wyoming', 'avatar-tcm'),
            'AS' => __('American Samoa', 'avatar-tcm'),
            'CZ' => __('Canal Zone', 'avatar-tcm'),
            'CM' => __('Commonwealth of the Northern Mariana Islands', 'avatar-tcm'),
            'FM' => __('Federated States of Micronesia', 'avatar-tcm'),
            'GU' => __('Guam', 'avatar-tcm'),
            'MH' => __('Marshall Islands', 'avatar-tcm'),
            'MP' => __('Northern Mariana Islands', 'avatar-tcm'),
            'PW' => __('Palau', 'avatar-tcm'),
            'PI' => __('Philippine Islands', 'avatar-tcm'),
            'PR' => __('Puerto Rico', 'avatar-tcm'),
            'TT' => __('Trust Territory of the Pacific Islands', 'avatar-tcm'),
            'VI' => __('Virgin Islands', 'avatar-tcm'),
            'AA' => __('Armed Forces - Americas', 'avatar-tcm'),
            'AE' => __('Armed Forces - Europe, Canada, Middle East, Africa', 'avatar-tcm'),
            'AP' => __('Armed Forces - Pacific', 'avatar-tcm'),
        ];

        return $states;
    }
}
