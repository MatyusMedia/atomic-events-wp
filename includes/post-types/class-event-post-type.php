<?php
defined('WPINC') or die;
class AtomicEvents_PostType {
    public function __construct($version) {
    }

    public function create_event_post_type() {
        $labels = array(
            'name' => 'Events',
            'singular_name' => 'Event',
            'add_new' => 'Add New Event',
            'add_new_item' => 'Add New Event',
            'edit_item' => 'Edit Event',
            'new_item' => 'New Event',
            'all_items' => 'All Events',
            'view_item' => 'View Event',
            'search_items' => 'Search Events',
            'not_found' => 'No events found',
            'not_found_in_trash' => 'No events found in Trash',
            'menu_name' => 'Events'
        );

        $args = array(
            'labels' => $labels,
            'public' => true,
            'has_archive' => true,
            'menu_icon' => 'dashicons-calendar-alt',
            'rewrite' => array('slug' => 'event'),
            'supports' => array('title', 'editor', 'custom-fields', 'thumbnail', 'excerpt'),
            // 'show_in_rest' => true
        );

        register_post_type('atomic-event', $args);
    }

    public function add_event_meta_boxes() {
        add_meta_box(
            'event_details_meta_box',
            'Event Details',
            array($this, 'display_event_details_meta_box'),
            'atomic-event',
            'normal',
            'high'
        );
        add_meta_box(
            'event_details_venue',
            'Event Address',
            array($this, 'display_event_venue_meta_box'),
            'atomic-event',
            'normal',
            'high'
        );
    }

    public function display_event_venue_meta_box($post) {
        $event_venue = get_post_meta($post->ID, 'event_venue', true);
        $event_address = get_post_meta($post->ID, 'event_address', true);
        $event_location_city = get_post_meta($post->ID, 'event_location_city', true);
        $event_location_state = get_post_meta($post->ID, 'event_location_state', true);
        $event_postcode = get_post_meta($post->ID, 'event_postcode', true);
        $event_country = get_post_meta($post->ID, 'event_country', true);
        $event_location_region = get_post_meta($post->ID, 'event_location_region', true);
?>

        <div class="atmc_event_edit_fieldwrap">
            <label class="atmc_event_edit_field_label" for="event_venue">Venue Name:</label><br>
            <input type="text" id="event_venue" name="event_venue" value="<?php echo esc_attr($event_venue); ?>" style="min-width:400px; max-width: 600px;">
        </div>
        <div class="atmc_event_edit_fieldwrap">
            <label class="atmc_event_edit_field_label" for="event_address">Address:</label><br>
            <input type="text" id="event_address" name="event_address" value="<?php echo esc_attr($event_address); ?>" style="min-width:400px; max-width: 600px;">
        </div>
        <div class="atmc_event_edit_fieldwrap">
            <label class="atmc_event_edit_field_label" for="event_location_city">Location (City):</label><br>
            <input type="text" id="event_location_city" name="event_location_city" value="<?php echo esc_attr($event_location_city); ?>" style="min-width:400px; max-width: 600px;">
        </div>
        <div class="atmc_event_edit_fieldwrap">
            <label class="atmc_event_edit_field_label" for="event_country">Country:</label><br>
            <select id="event_country" name="event_country" style="min-width:400px; max-width: 600px;" onchange="atmvnts_showAdditionalFields(this.value)">
                <option value="">Select Country</option>
                <?php
                // Get list of countries
                $countries = $this->get_countries_list();
                foreach ($countries as $code => $name) {
                    echo '<option value="' . esc_attr($code) . '" ' . esc_attr(selected($event_country, $code, false)) . '>' . esc_attr($name) . '</option>';
                }
                ?>
            </select>
        </div>
        <div id="additional_fields_state" style="display: none;">
            <div class="atmc_event_edit_fieldwrap">
                <label class="atmc_event_edit_field_label" for="event_location_state">State:</label><br>
                <select id="event_location_state" name="event_location_state" style="min-width:400px; max-width: 600px;">
                    <option value="">Select State</option>
                    <?php
                    // Get list of states if United States is selected
                    $states = $this->get_states_list();
                    foreach ($states as $code => $name) {
                        echo '<option value="' . esc_attr($code) . '" ' . esc_attr(selected($event_location_state, $code, false)) . '>' . esc_attr($name) . '</option>';
                    }
                    ?>
                </select>
            </div>
        </div>
        <div id="additional_fields_region" style="display: none;">
            <div class="">
                <label class="atmc_event_edit_field_label" for="event_location_region">Region:</label><br>
                <input type="text" id="event_location_region" name="event_location_region" value="<?php echo esc_attr($event_location_region); ?>" style="min-width:400px; max-width: 600px;">
            </div>
        </div>
        <div class="atmc_event_edit_fieldwrap">
            <label class="atmc_event_edit_field_label" for="event_postcode">Post Code:</label><br>
            <input type="text" id="event_postcode" name="event_postcode" value="<?php echo esc_attr($event_postcode); ?>" style="min-width:400px; max-width: 600px;">
        </div>
        <?php wp_nonce_field('event_form_action', 'event_form_nonce'); ?>
    <?php
    }

    public function display_event_details_meta_box($post) {

        $event_featured = get_post_meta($post->ID, 'event_featured', true);
        $event_featured_value = (isset($event_featured) && !empty($event_featured)) ? 1 : 0;

        $event_member_only = get_post_meta($post->ID, 'event_member_only', true);
        $event_member_only_value = (isset($event_member_only) && !empty($event_member_only)) ? 1 : 0;

        $event_member_only = get_post_meta($post->ID, 'event_member_only', true);
        $event_member_only_value = (isset($event_member_only) && !empty($event_member_only)) ? 1 : 0;

        $event_outbound_link = get_post_meta($post->ID, 'event_outbound_link', true);
        $event_start_date = get_post_meta($post->ID, 'event_start_date', true);
        $event_start_time = get_post_meta($post->ID, 'event_start_time', true);

        $event_all_day = get_post_meta($post->ID, 'event_all_day', true);
        $event_all_day_value = (isset($event_all_day) && !empty($event_all_day)) ? 1 : 0;

        $event_end_date = get_post_meta($post->ID, 'event_end_date', true);
        $event_end_time = get_post_meta($post->ID, 'event_end_time', true);
        // $event_tag = get_post_meta($post->ID, 'event_tag', true);

        // echo tribe_get_start_date(11227);
    ?>


        <div class="atmc_event_edit_fieldwrap">
            <span>Featured Event:</span><br>

            <div class="onoffswitch">
                <input type="checkbox" name="event_featured" value="1" class="onoffswitch-checkbox" id="event_featured" tabindex="0" <?php checked($event_featured_value, 1); ?> />

                <label class="onoffswitch-label" for="event_featured">
                    <span class="onoffswitch-inner"></span>
                    <span class="onoffswitch-switch"></span>
                </label>
            </div>
        </div>

        <div class="atmc_event_edit_fieldwrap">
            <span>Members only Event:</span><br>

            <div class="onoffswitch">
                <input type="checkbox" name="event_member_only" value="1" class="onoffswitch-checkbox" id="event_member_only" tabindex="0" <?php checked($event_member_only_value, 1); ?> />

                <label class="onoffswitch-label" for="event_member_only">
                    <span class="onoffswitch-inner"></span>
                    <span class="onoffswitch-switch"></span>
                </label>
            </div>
        </div>

        <div class="atmc_event_edit_fieldwrap">
            <div class="atmc_admin_date_time_container">
                <div class="atmc_admin_date_time_wrapper">

                    <label class="atmc_event_edit_field_label" for="event_start_date">Event Start Date:</label><br>
                    <input type="date" id="event_start_date" name="event_start_date" value="<?php echo esc_attr($event_start_date); ?>" style="width: 200px;">
                </div>
                <div class="atmc_admin_date_time_wrapper">
                    <label class="atmc_event_edit_field_label" for="event_start_time">Start Time:</label><br>
                    <input type="time" id="event_start_time" name="event_start_time" value="<?php echo esc_attr($event_start_time); ?>" style="width: 100px;">
                </div>

            </div>
        </div>
        <div class="atmc_event_edit_fieldwrap">
            <div class="atmc_admin_date_time_wrapper">
                <input type="checkbox" name="event_all_day" value="1" class="event_all_day" id="event_all_day" tabindex="0" <?php checked($event_all_day_value, 1); ?>>

                <label class="atmc_event_edit_field_label" for="event_all_day">
                    All day event
                </label>
            </div>
        </div>

        <div class="atmc_event_edit_fieldwrap">
            <div class="atmc_admin_date_time_container">
                <div class="atmc_admin_date_time_wrapper">
                    <label class="atmc_event_edit_field_label" for=" event_end_date">Event End Date:</label><br>
                    <input type="date" id="event_end_date" name="event_end_date" value="<?php echo esc_attr($event_end_date); ?>" style="width: 200px;">
                </div>

                <div class="atmc_admin_date_time_wrapper">
                    <label class="atmc_event_edit_field_label" for=" event_end_time">End Time:</label><br>
                    <input type="time" id="event_end_time" name="event_end_time" value="<?php echo esc_attr($event_end_time); ?>" style="width: 100px;">
                </div>
            </div>
        </div>

        <div class="atmc_event_edit_fieldwrap">
            <label class="atmc_event_edit_field_label" for="event_outbound_link">Outbound Link (URL):</label><br>
            <input type="text" id="event_outbound_link" name="event_outbound_link" value="<?php echo esc_attr($event_outbound_link); ?>" style="width:100%;">
            <div class="atmc_event_edit_fieldwrap">
                Adding an outbout link will turn "More" button into a link to the URL instead of the detail page of the event. (Must have protocol https:// ...)
            </div>
        </div>
<?php
    }

    public function save_event_details_meta_box($post_id) {
        if (! wp_verify_nonce(sanitize_text_field(wp_unslash($_GET['event_form_nonce'])), 'event_form_action')) {
            return;
        }

        if (isset($_POST['event_outbound_link'])) {
            update_post_meta($post_id, 'event_outbound_link', sanitize_url(trim(wp_unslash($_POST['event_outbound_link']))));
        }

        if (isset($_POST['event_featured'])) {
            update_post_meta($post_id, 'event_featured', 1);
        } else {
            update_post_meta($post_id, 'event_featured', 0);
        }

        if (isset($_POST['event_member_only'])) {
            update_post_meta($post_id, 'event_member_only', 1);
        } else {
            update_post_meta($post_id, 'event_member_only', 0);
        }

        if (isset($_POST['event_venue'])) {
            update_post_meta($post_id, 'event_venue', sanitize_text_field(wp_unslash($_POST['event_venue'])));
        }

        if (isset($_POST['event_location_city'])) {
            update_post_meta($post_id, 'event_location_city', sanitize_text_field(wp_unslash($_POST['event_location_city'])));
        }

        if (isset($_POST['event_address'])) {
            update_post_meta($post_id, 'event_address', sanitize_text_field(wp_unslash($_POST['event_address'])));
        }

        if (isset($_POST['event_country'])) {
            update_post_meta($post_id, 'event_country', sanitize_text_field(wp_unslash($_POST['event_country'])));
        }

        if (isset($_POST['event_location_state'])) {
            update_post_meta($post_id, 'event_location_state', sanitize_text_field(wp_unslash($_POST['event_location_state'])));
        }

        if (isset($_POST['event_postcode'])) {
            update_post_meta($post_id, 'event_postcode', sanitize_text_field(wp_unslash($_POST['event_postcode'])));
        }

        if (isset($_POST['event_location_region'])) {
            update_post_meta($post_id, 'event_location_region', sanitize_text_field(wp_unslash($_POST['event_location_region'])));
        }

        if (isset($_POST['event_start_date'])) {
            update_post_meta($post_id, 'event_start_date', sanitize_text_field(wp_unslash($_POST['event_start_date'])));
        }

        if (isset($_POST['event_start_time'])) {
            update_post_meta($post_id, 'event_start_time', sanitize_text_field(wp_unslash($_POST['event_start_time'])));
        }

        if (isset($_POST['event_all_day'])) {
            update_post_meta($post_id, 'event_all_day', 1);
        } else {
            update_post_meta($post_id, 'event_all_day', 0);
        }

        if (isset($_POST['event_end_date'])) {
            update_post_meta($post_id, 'event_end_date', sanitize_text_field(wp_unslash($_POST['event_end_date'])));
        }

        if (isset($_POST['event_end_time'])) {
            update_post_meta($post_id, 'event_end_time', sanitize_text_field(wp_unslash($_POST['event_end_time'])));
        }

        // if (isset($_POST['event_tag'])) {
        //     update_post_meta($post_id, 'event_tag', sanitize_text_field(wp_unslash($_POST['event_tag'])));
        // }


        // Calculate and save event start timestamp
        if (isset($_POST['event_start_date'])) {
            $start_date = sanitize_text_field(wp_unslash($_POST['event_start_date']));
        } else {
            $start_date = '';
        }

        if (isset($_POST['event_start_time'])) {
            $start_time = sanitize_text_field(wp_unslash($_POST['event_start_time']));
        } else {
            $start_time = '';
        }
        $start_timestamp = strtotime("$start_date $start_time");
        if ($start_timestamp !== false) {
            update_post_meta($post_id, 'event_start_timestamp', $start_timestamp);
        }


        // Calculate and save event end timestamp

        if (isset($_POST['event_end_date'])) {
            $end_date = sanitize_text_field(wp_unslash($_POST['event_end_date']));
        } else {
            $end_date = '';
        }

        if (isset($_POST['event_end_time'])) {
            $end_time = sanitize_text_field(wp_unslash($_POST['event_end_time']));
        } else {
            $end_time = '';
        }

        $end_timestamp = strtotime("$end_date $end_time");
        if ($end_timestamp !== false) {
            update_post_meta($post_id, 'event_end_timestamp', $end_timestamp);
        }
    }

    // Function to get list of countries
    private function get_countries_list() {
        $countries = array(
            'US' => 'United States of America',
            'AF' => 'Afghanistan',
            'AX' => 'Åland Islands',
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
            'BO' => 'Bolivia (Plurinational State of)',
            'BQ' => 'Bonaire, Sint Eustatius and Saba',
            'BA' => 'Bosnia and Herzegovina',
            'BW' => 'Botswana',
            'BV' => 'Bouvet Island',
            'BR' => 'Brazil',
            'IO' => 'British Indian Ocean Territory',
            'BN' => 'Brunei Darussalam',
            'BG' => 'Bulgaria',
            'BF' => 'Burkina Faso',
            'BI' => 'Burundi',
            'CV' => 'Cabo Verde',
            'KH' => 'Cambodia',
            'CM' => 'Cameroon',
            'CA' => 'Canada',
            'KY' => 'Cayman Islands',
            'CF' => 'Central African Republic',
            'TD' => 'Chad',
            'CL' => 'Chile',
            'CN' => 'China',
            'CX' => 'Christmas Island',
            'CC' => 'Cocos (Keeling) Islands',
            'CO' => 'Colombia',
            'KM' => 'Comoros',
            'CG' => 'Congo',
            'CD' => 'Congo (Democratic Republic of the)',
            'CK' => 'Cook Islands',
            'CR' => 'Costa Rica',
            'CI' => "Côte d'Ivoire",
            'HR' => 'Croatia',
            'CU' => 'Cuba',
            'CW' => 'Curaçao',
            'CY' => 'Cyprus',
            'CZ' => 'Czech Republic',
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
            'FK' => 'Falkland Islands (Malvinas)',
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
            'VA' => 'Holy See',
            'HN' => 'Honduras',
            'HK' => 'Hong Kong',
            'HU' => 'Hungary',
            'IS' => 'Iceland',
            'IN' => 'India',
            'ID' => 'Indonesia',
            'IR' => 'Iran (Islamic Republic of)',
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
            'KP' => "Korea (Democratic People's Republic of)",
            'KR' => 'Korea (Republic of)',
            'KW' => 'Kuwait',
            'KG' => 'Kyrgyzstan',
            'LA' => "Lao People's Democratic Republic",
            'LV' => 'Latvia',
            'LB' => 'Lebanon',
            'LS' => 'Lesotho',
            'LR' => 'Liberia',
            'LY' => 'Libya',
            'LI' => 'Liechtenstein',
            'LT' => 'Lithuania',
            'LU' => 'Luxembourg',
            'MO' => 'Macao',
            'MK' => 'Macedonia (the former Yugoslav Republic of)',
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
            'FM' => 'Micronesia (Federated States of)',
            'MD' => 'Moldova (Republic of)',
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
            'NC' => 'New Caledonia',
            'NZ' => 'New Zealand',
            'NI' => 'Nicaragua',
            'NE' => 'Niger',
            'NG' => 'Nigeria',
            'NU' => 'Niue',
            'NF' => 'Norfolk Island',
            'MP' => 'Northern Mariana Islands',
            'NO' => 'Norway',
            'OM' => 'Oman',
            'PK' => 'Pakistan',
            'PW' => 'Palau',
            'PS' => 'Palestine, State of',
            'PA' => 'Panama',
            'PG' => 'Papua New Guinea',
            'PY' => 'Paraguay',
            'PE' => 'Peru',
            'PH' => 'Philippines',
            'PN' => 'Pitcairn',
            'PL' => 'Poland',
            'PT' => 'Portugal',
            'PR' => 'Puerto Rico',
            'QA' => 'Qatar',
            'RE' => 'Réunion',
            'RO' => 'Romania',
            'RU' => 'Russian Federation',
            'RW' => 'Rwanda',
            'BL' => 'Saint Barthélemy',
            'SH' => 'Saint Helena, Ascension and Tristan da Cunha',
            'KN' => 'Saint Kitts and Nevis',
            'LC' => 'Saint Lucia',
            'MF' => 'Saint Martin (French part)',
            'PM' => 'Saint Pierre and Miquelon',
            'VC' => 'Saint Vincent and the Grenadines',
            'WS' => 'Samoa',
            'SM' => 'San Marino',
            'ST' => 'Sao Tome and Principe',
            'SA' => 'Saudi Arabia',
            'SN' => 'Senegal',
            'RS' => 'Serbia',
            'SC' => 'Seychelles',
            'SL' => 'Sierra Leone',
            'SG' => 'Singapore',
            'SX' => 'Sint Maarten (Dutch part)',
            'SK' => 'Slovakia',
            'SI' => 'Slovenia',
            'SB' => 'Solomon Islands',
            'SO' => 'Somalia',
            'ZA' => 'South Africa',
            'GS' => 'South Georgia and the South Sandwich Islands',
            'SS' => 'South Sudan',
            'ES' => 'Spain',
            'LK' => 'Sri Lanka',
            'SD' => 'Sudan',
            'SR' => 'Suriname',
            'SJ' => 'Svalbard and Jan Mayen',
            'SZ' => 'Swaziland',
            'SE' => 'Sweden',
            'CH' => 'Switzerland',
            'SY' => 'Syrian Arab Republic',
            'TW' => 'Taiwan, Province of China',
            'TJ' => 'Tajikistan',
            'TZ' => 'Tanzania, United Republic of',
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
            'GB' => 'United Kingdom of Great Britain and Northern Ireland',
            'UM' => 'United States Minor Outlying Islands',
            'UY' => 'Uruguay',
            'UZ' => 'Uzbekistan',
            'VU' => 'Vanuatu',
            'VE' => 'Venezuela (Bolivarian Republic of)',
            'VN' => 'Viet Nam',
            'VG' => 'Virgin Islands (British)',
            'VI' => 'Virgin Islands (U.S.)',
            'WF' => 'Wallis and Futuna',
            'EH' => 'Western Sahara',
            'YE' => 'Yemen',
            'ZM' => 'Zambia',
            'ZW' => 'Zimbabwe',
        );

        return $countries;
    }

    // Function to get list of states
    private function get_states_list() {
        $states = array(
            'AL' => 'Alabama',
            'AK' => 'Alaska',
            'AZ' => 'Arizona',
            'AR' => 'Arkansas',
            'CA' => 'California',
            'CO' => 'Colorado',
            'CT' => 'Connecticut',
            'DE' => 'Delaware',
            'FL' => 'Florida',
            'GA' => 'Georgia',
            'HI' => 'Hawaii',
            'ID' => 'Idaho',
            'IL' => 'Illinois',
            'IN' => 'Indiana',
            'IA' => 'Iowa',
            'KS' => 'Kansas',
            'KY' => 'Kentucky',
            'LA' => 'Louisiana',
            'ME' => 'Maine',
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
            'OH' => 'Ohio',
            'OK' => 'Oklahoma',
            'OR' => 'Oregon',
            'PA' => 'Pennsylvania',
            'RI' => 'Rhode Island',
            'SC' => 'South Carolina',
            'SD' => 'South Dakota',
            'TN' => 'Tennessee',
            'TX' => 'Texas',
            'UT' => 'Utah',
            'VT' => 'Vermont',
            'VA' => 'Virginia',
            'WA' => 'Washington',
            'WV' => 'West Virginia',
            'WI' => 'Wisconsin',
            'WY' => 'Wyoming',
        );

        return $states;
    }
}
