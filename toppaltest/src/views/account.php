
<div class="main-content">

<?php

echo $mustache->render('_common/breadcrumb',array('pageInfo' => $page));

$tabs = array (
    array(
        "title" => __("Account"),
        "slug" => "accountinformation",
        "active" => "active"
    ),
    array(
        "title" => __("Billing"),
        "slug"  => "billinginformation"
    ),
    array(
        "title" => __("Merchant Account"),
        "slug"  => "merchantaccountinformation"
    ),
    array(
        "title" => __("Plan Usage"),
        "slug"  => "usage"
    ),
    array(
        "title" => __("Upgrade Plan"),
        "slug"  => "plans"
    )
);

echo $mustache->render('_common/tabs',array('tabs' => $tabs,'hideSaveButton' => true));

$templates = loadTemplateCache(
    '_common/inputClosedTag.html',
    '_common/inputWrappedTag.html',
    'account/accountinformation.html',
    'account/billinginformation.html',
    'account/usage.html',
    'account/plans.html',
    'account/merchantaccountinformation.html'
);

$billingCountries = Array(
    'AF' => 'Afghanistan',
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
    'BA' => 'Bosnia and Herzegovina',
    'BW' => 'Botswana',
    'BV' => 'Bouvet Island',
    'BR' => 'Brazil',
    'IO' => 'British Indian Ocean Territory',
    'VG' => 'British Virgin Islands',
    'BN' => 'Brunei',
    'BG' => 'Bulgaria',
    'BF' => 'Burkina Faso',
    'BI' => 'Burundi',
    'KH' => 'Cambodia',
    'CM' => 'Cameroon',
    'CA' => 'Canada',
    'CV' => 'Cape Verde',
    'KY' => 'Cayman Islands',
    'CF' => 'Central African Republic',
    'TD' => 'Chad',
    'CL' => 'Chile',
    'CN' => 'China',
    'CX' => 'Christmas Island',
    'CC' => 'Cocos [Keeling] Islands',
    'CO' => 'Colombia',
    'KM' => 'Comoros',
    'CG' => 'Congo - Brazzaville',
    'CD' => 'Congo - Kinshasa',
    'CK' => 'Cook Islands',
    'CR' => 'Costa Rica',
    'HR' => 'Croatia',
    'CU' => 'Cuba',
    'CY' => 'Cyprus',
    'CZ' => 'Czech Republic',
    'CI' => 'Côte d’Ivoire',
    'DK' => 'Denmark',
    'DJ' => 'Djibouti',
    'DM' => 'Dominica',
    'DO' => 'Dominican Republic',
    'EC' => 'Ecuador',
    'EG' => 'Egypt',
    'SV' => 'El Salvador',
    'GQ' => 'Equatorial Guinea',
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
    'GH' => 'Ghana',
    'GI' => 'Gibraltar',
    'GR' => 'Greece',
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
    'HM' => 'Heard Island and McDonald Islands',
    'HN' => 'Honduras',
    'HK' => 'Hong Kong SAR China',
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
    'LA' => 'Laos',
    'LV' => 'Latvia',
    'LB' => 'Lebanon',
    'LS' => 'Lesotho',
    'LR' => 'Liberia',
    'LY' => 'Libya',
    'LI' => 'Liechtenstein',
    'LT' => 'Lithuania',
    'LU' => 'Luxembourg',
    'MO' => 'Macau SAR China',
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
    'MM' => 'Myanmar [Burma]',
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
    'PN' => 'Pitcairn Islands',
    'PL' => 'Poland',
    'PT' => 'Portugal',
    'PR' => 'Puerto Rico',
    'QA' => 'Qatar',
    'RO' => 'Romania',
    'RU' => 'Russia',
    'RW' => 'Rwanda',
    'RE' => 'Réunion',
    'BL' => 'Saint Barthélemy',
    'SH' => 'Saint Helena',
    'KN' => 'Saint Kitts and Nevis',
    'LC' => 'Saint Lucia',
    'MF' => 'Saint Martin',
    'PM' => 'Saint Pierre and Miquelon',
    'VC' => 'Saint Vincent and the Grenadines',
    'WS' => 'Samoa',
    'SM' => 'San Marino',
    'SA' => 'Saudi Arabia',
    'SN' => 'Senegal',
    'RS' => 'Serbia',
    'SC' => 'Seychelles',
    'SL' => 'Sierra Leone',
    'SG' => 'Singapore',
    'SK' => 'Slovakia',
    'SI' => 'Slovenia',
    'SB' => 'Solomon Islands',
    'SO' => 'Somalia',
    'ZA' => 'South Africa',
    'GS' => 'South Georgia and the South Sandwich Islands',
    'KR' => 'South Korea',
    'ES' => 'Spain',
    'LK' => 'Sri Lanka',
    'SD' => 'Sudan',
    'SR' => 'Suriname',
    'SJ' => 'Svalbard and Jan Mayen',
    'SZ' => 'Swaziland',
    'SE' => 'Sweden',
    'CH' => 'Switzerland',
    'SY' => 'Syria',
    'ST' => 'São Tomé and Príncipe',
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
    'UM' => 'U.S. Minor Outlying Islands',
    'VI' => 'U.S. Virgin Islands',
    'UG' => 'Uganda',
    'UA' => 'Ukraine',
    'AE' => 'United Arab Emirates',
    'GB' => 'United Kingdom',
//    'US' => 'United States',
    'US' => 'United States of America',
    'UY' => 'Uruguay',
    'UZ' => 'Uzbekistan',
    'VU' => 'Vanuatu',
    'VA' => 'Vatican City',
    'VE' => 'Venezuela',
    'VN' => 'Vietnam',
    'WF' => 'Wallis and Futuna',
    'EH' => 'Western Sahara',
    'YE' => 'Yemen',
    'ZM' => 'Zambia',
    'ZW' => 'Zimbabwe',
    'AX' => 'Åland Islands'
);

$billingUSstates = Array(
    'AL' => 'Alabama',
    'AK' => 'Alaska',
    'AS' => 'American Samoa',
    'AZ' => 'Arizona',
    'AR' => 'Arkansas',
    'AF' => 'Armed Forces Africa',
    'AA' => 'Armed Forces Americas',
    'AC' => 'Armed Forces Canada',
    'AE' => 'Armed Forces Europe',
    'AM' => 'Armed Forces Middle East',
    'AP' => 'Armed Forces Pacific',
    'CA' => 'California',
    'CO' => 'Colorado',
    'CT' => 'Connecticut',
    'DE' => 'Delaware',
    'DC' => 'District of Columbia',
    'FM' => 'Federated States Of Micronesia',
    'FL' => 'Florida',
    'GA' => 'Georgia',
    'GU' => 'Guam',
    'HI' => 'Hawaii',
    'ID' => 'Idaho',
    'IL' => 'Illinois',
    'IN' => 'Indiana',
    'IA' => 'Iowa',
    'KS' => 'Kansas',
    'KY' => 'Kentucky',
    'LA' => 'Louisiana',
    'ME' => 'Maine',
    'MH' => 'Marshall Islands',
    'MD' => 'Maryland',
    'MA' => 'Massachusetts',
    'MI' => 'Michigan',
    'MN' => 'Minnesota',
    'MS' => 'Mississippi',
    'MO' => 'Missouri',
    'MT' => 'Montana',
    'NE' => 'Nebraska',
    'NV' => 'Nevada',
    'NH' => 'New Hampshire',
    'NJ' => 'New Jersey',
    'NM' => 'New Mexico',
    'NY' => 'New York',
    'NC' => 'North Carolina',
    'ND' => 'North Dakota',
    'MP' => 'Northern Mariana Islands',
    'OH' => 'Ohio',
    'OK' => 'Oklahoma',
    'OR' => 'Oregon',
    'PW' => 'Palau',
    'PA' => 'Pennsylvania',
    'PR' => 'Puerto Rico',
    'RI' => 'Rhode Island',
    'SC' => 'South Carolina',
    'SD' => 'South Dakota',
    'TN' => 'Tennessee',
    'TX' => 'Texas',
    'UT' => 'Utah',
    'VT' => 'Vermont',
    'VI' => 'Virgin Islands',
    'VA' => 'Virginia',
    'WA' => 'Washington',
    'WV' => 'West Virginia',
    'WI' => 'Wisconsin',
    'WY' => 'Wyoming'
);
?>

</div>
<?php require('_common/lightboxes.html'); ?>

<script>

    // Deferred objects (deferreds). Ignore for now.
    ds = [];

    $(function() {

        ds.push(
                // Don't mind me ;)

                C.ssm.loadPartial.helper( {
                    url: 'getAccountInformation.php',
                    template: 'account/accountinformation.html',
                    elementId: 'accountinformation'
//                data: {
//                    firstName: C.ssm.loadPartial.formField( C.ssm.fields.firstName ),
//                    lastName: C.ssm.loadPartial.formField( C.ssm.fields.lastName ),
//                    email: C.ssm.loadPartial.formField( C.ssm.fields.email ),
//                    password: C.ssm.loadPartial.formField( C.ssm.fields.password ),
//                    passwordConf: C.ssm.loadPartial.formField( C.ssm.fields.passwordConf ),
//                    defaultLanguage: C.ssm.loadPartial.formField( C.ssm.fields.defaultLanguage ),
//                    currency: C.ssm.loadPartial.formField( C.ssm.fields.currency ),
//                    seoURL: C.ssm.loadPartial.formField( C.ssm.fields.seoURL ),
//                    marketBio: C.ssm.loadPartial.formField( C.ssm.fields.marketBio ),
//                    marketBioText: C.ssm.loadPartial.formField( C.ssm.fields.marketBioText )
//                }
                } ),


                C.ssm.loadPartial.helper( {
                    url: 'getBillingInformation.php',
                    template: 'account/billinginformation.html',
                    elementId: 'billinginformation'
//                data: {
//                    address: C.ssm.loadPartial.formField( C.ssm.fields.address ),
//                    city: C.ssm.loadPartial.formField( C.ssm.fields.city ),
//                    country: C.ssm.loadPartial.formField( C.ssm.fields.country ),
//                    state: C.ssm.loadPartial.formField( C.ssm.fields.state ),
//                    zip: C.ssm.loadPartial.formField( C.ssm.fields.zip ),
//                    creditCard: C.ssm.loadPartial.formField( C.ssm.fields.creditCard ),
//                    ccw: C.ssm.loadPartial.formField( C.ssm.fields.ccw ),
//                    expMonth: C.ssm.loadPartial.formField( {name:"expMonth", label:"expMonth"}, C.ssm.fields.monthDropDown ),
//                    expYear: C.ssm.loadPartial.formField( {name:"expYear", label:"expYear"}, C.ssm.fields.yearDropDown10 )
//                }
                } ),


                // New loadPartial.helper() version of the above (not tested, just here for example transcription)
                // NOTICE!!! You need to specify .json and .html file extensions with loadPartial.helper();
                C.ssm.loadPartial.helper( {
                    url: 'getPlanUsage.php',
                    template: 'account/usage.html',
                    elementId: 'usage'
                } ),
                C.ssm.loadPartial.helper( {
                    url: 'getPlans.php',
                    template: 'account/plans.html',
                    elementId: 'plans'
                } ),
                C.ssm.loadPartial.helper( {
                    url: 'getMerchantAccountInformation.php',
                    template: 'account/merchantaccountinformation.html',
                    elementId: 'merchantaccountinformation'
                } )

        );

        var billing = {

            popuplateCountries: function() {
                var billingcountries= <?php echo json_encode($billingCountries)?>;
                $.each(billingcountries, function(code, state){
                    var prevcountry = $("#inputcountry").val();
                    if( prevcountry==code){
                        var option = '<option value="' + code + '"selected>' + state + '</option>';
                    }else{
                        var option = '<option value="' + code + '">' + state + '</option>';
                    }

                    $('#country').append(option);
                });
//                $('#state').html('');
            },

            populateUSstates: function(){
                var billingUSstates = <?php echo json_encode($billingUSstates)?>;

                $.each(billingUSstates, function(code, state){
                    var prevstate = $("#inputstate").val();
                    if( prevstate==code){
                        var option = '<option value="' + code + '"selected>' + state + '</option>';
                    }else{
                        var option = '<option value="' + code + '">' + state + '</option>';
                    }
//                    var option = '<option value="' + code + '">' + state + '</option>';
                    $('#state').append(option);
                });

            },

            matchStates: function() {
                $('#body').on('change', '#country', function(){
                    if($(this).val().toLowerCase() == 'us') {
                        billing.populateUSstates();
                    } else {
                        $('#state').html('');
                    }
                });
            }
        }

        $.when.apply( this, ds ).then(

                // ALL completed successfully. Do this stuff
                function() {

                    console.log('all done');
                    billing.matchStates();
                    billing.popuplateCountries();
                    billing.populateUSstates();
//                    billing.matchStates();

                });

    });


    var saveButtons = {

        account: function() {
            C.ssm.ajax.service( {
                url: '../src/jsapiCalls/saveAccount.php',
                data: $("#accountinfo").serialize()
            } )
                    .done( function( response ) {

                        if(response.responseCode == 1000) {

                            noticeText=response.responseText;
                            setSuccessNotice(noticeText);

                            // Log successful response to console (wrapper handles/logs failures). Todo: Remove this.
                            C.ssm.log( "Email successfully shared. Response:", response );

                            $("#publish_email").val("");
                            $("#publish_message").val("");

                            // Redirect Page
                            //window.location.href( 'account' );




                        } else {
                            noticeText=response.responseText;
                            setErrorNotice(noticeText);
                        }

                    } );

        },
        billing: function() {
            C.ssm.ajax.service( {
                url: '../src/jsapiCalls/saveBilling.php',
                data: $("#billingInformationForm").serialize()
            } )
                    .done( function( response ) {

                        if(response.responseCode == 1000) {

                            noticeText=response.responseText;
                            setSuccessNotice(noticeText);

                            // Log successful response to console (wrapper handles/logs failures). Todo: Remove this.
                            C.ssm.log( "Email successfully shared. Response:", response );

                            $("#publish_email").val("");
                            $("#publish_message").val("");

                            $("#creditcard").val("****************");
                            $("#cvv").val("***");
                            // Redirect Page
                            //window.location.href( 'account' );




                        } else {
                            noticeText=response.responseText;
                            setErrorNotice(noticeText);
                        }

                    } );

        },
        accountmerchant: function() {
            C.ssm.ajax.service( {
                url: '../src/jsapiCalls/saveAccountMerchant.php',
                data: $("#merchantAccountInformationForm").serialize()
            } )
                    .done( function( response ) {

                        if(response.responseCode == 1000) {

                            noticeText=response.responseText;
                            setSuccessNotice(noticeText);

                            // Log successful response to console (wrapper handles/logs failures). Todo: Remove this.
                            C.ssm.log( "Email successfully shared. Response:", response );

                            $("#publish_email").val("");
                            $("#publish_message").val("");

                            // Redirect Page
                            //window.location.href( 'account' );




                        } else {
                            noticeText=response.responseText;
                            setErrorNotice(noticeText);
                        }

                    } );

        }

    };

    //Pre-load mustache templates
    C.ssm.mustache.addTemplates( <?php echo $templates; ?> );

</script>
<script type="text/javascript">



    $("button.btn-success").on("click", function(event) {

        var $this = $(this),
                thisText = $this.html(),
                newText = 'Saving...';

        $this.addClass('disabled').html(newText);

        toyin = $.ajax({
            url:"../src/jsapiCalls/saveClientInfo.php",
            data:$("form").serialize()
            })
                .done(function(responseText){
                    $this.removeClass('disabled').html(thisText);
                    console.log(responseText);
                });

        console.log($(toyin));
    });



    function upgradePlan(plan_id) {

        C.ssm.ajax.service( {
            url: '../src/jsapiCalls/upgradePlan.php?plan_id=' + plan_id
        } )
            .done( function( response ) {

                if(response.responseCode == 1000) {

                    noticeText=response.responseText;
                    setSuccessNotice(noticeText);

                    //refresh this tab
                	C.ssm.loadPartial.helper( {
                	    url: 'getPlans.php',
                	    template: 'account/plans.html',
                	    elementId: 'plans'
                	} );

                	//also refresh plan usage page
                    C.ssm.loadPartial.helper( {
                        url: 'getPlanUsage.php',
                        template: 'account/usage.html',
                        elementId: 'usage'
                    } );
                	
                	// Log successful response to console (wrapper handles/logs failures). Todo: Remove this.
                    C.ssm.log( "Upgraded to plan: " + plan_id + ". Response:", response );

                    // Redirect Page
                    //window.location.href( 'account' );




                }else{
                    noticeText=response.responseText;
                    setErrorNotice(noticeText);
                }

            } );

    }
</script>
<script type="text/javascript" src="js/cinsay/account_validate.js"></script>
<script type="text/javascript" src="js/cinsay/billing_validate.js"></script>
<script type="text/javascript" src="js/cinsay/merchant_account_validate.js"></script>