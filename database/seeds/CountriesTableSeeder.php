<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountriesTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        //table name
        $table = 'countries';
        //Using data insert statement.
        DB::table($table)->insert(['code' => 'AF', 'name' => 'Afghanistan']);
        DB::table($table)->insert(['code' => 'AL', 'name' => 'Albania']);
        DB::table($table)->insert(['code' => 'DZ', 'name' => 'Algeria']);
        DB::table($table)->insert(['code' => 'DS', 'name' => 'American Samoa']);
        DB::table($table)->insert(['code' => 'AD', 'name' => 'Andorra']);
        DB::table($table)->insert(['code' => 'AO', 'name' => 'Angola']);
        DB::table($table)->insert(['code' => 'AI', 'name' => 'Anguilla']);
        DB::table($table)->insert(['code' => 'AQ', 'name' => 'Antarctica']);
        DB::table($table)->insert(['code' => 'AG', 'name' => 'Antigua and Barbuda']);
        DB::table($table)->insert(['code' => 'AR', 'name' => 'Argentina']);
        DB::table($table)->insert(['code' => 'AM', 'name' => 'Armenia']);
        DB::table($table)->insert(['code' => 'AW', 'name' => 'Aruba']);
        DB::table($table)->insert(['code' => 'AU', 'name' => 'Australia']);
        DB::table($table)->insert(['code' => 'AT', 'name' => 'Austria']);
        DB::table($table)->insert(['code' => 'AZ', 'name' => 'Azerbaijan']);
        DB::table($table)->insert(['code' => 'BS', 'name' => 'Bahamas']);
        DB::table($table)->insert(['code' => 'BH', 'name' => 'Bahrain']);
        DB::table($table)->insert(['code' => 'BD', 'name' => 'Bangladesh']);
        DB::table($table)->insert(['code' => 'BB', 'name' => 'Barbados']);
        DB::table($table)->insert(['code' => 'BY', 'name' => 'Belarus']);
        DB::table($table)->insert(['code' => 'BE', 'name' => 'Belgium']);
        DB::table($table)->insert(['code' => 'BZ', 'name' => 'Belize']);
        DB::table($table)->insert(['code' => 'BJ', 'name' => 'Benin']);
        DB::table($table)->insert(['code' => 'BM', 'name' => 'Bermuda']);
        DB::table($table)->insert(['code' => 'BT', 'name' => 'Bhutan']);
        DB::table($table)->insert(['code' => 'BO', 'name' => 'Bolivia']);
        DB::table($table)->insert(['code' => 'BA', 'name' => 'Bosnia and Herzegovina']);
        DB::table($table)->insert(['code' => 'BW', 'name' => 'Botswana']);
        DB::table($table)->insert(['code' => 'BV', 'name' => 'Bouvet Island']);
        DB::table($table)->insert(['code' => 'BR', 'name' => 'Brazil']);
        DB::table($table)->insert(['code' => 'IO', 'name' => 'British Indian Ocean Territory']);
        DB::table($table)->insert(['code' => 'BN', 'name' => 'Brunei Darussalam']);
        DB::table($table)->insert(['code' => 'BG', 'name' => 'Bulgaria']);
        DB::table($table)->insert(['code' => 'BF', 'name' => 'Burkina Faso']);
        DB::table($table)->insert(['code' => 'BI', 'name' => 'Burundi']);
        DB::table($table)->insert(['code' => 'KH', 'name' => 'Cambodia']);
        DB::table($table)->insert(['code' => 'CM', 'name' => 'Cameroon']);
        DB::table($table)->insert(['code' => 'CA', 'name' => 'Canada']);
        DB::table($table)->insert(['code' => 'CV', 'name' => 'Cape Verde']);
        DB::table($table)->insert(['code' => 'KY', 'name' => 'Cayman Islands']);
        DB::table($table)->insert(['code' => 'CF', 'name' => 'Central African Republic']);
        DB::table($table)->insert(['code' => 'TD', 'name' => 'Chad']);
        DB::table($table)->insert(['code' => 'CL', 'name' => 'Chile']);
        DB::table($table)->insert(['code' => 'CN', 'name' => 'China']);
        DB::table($table)->insert(['code' => 'CX', 'name' => 'Christmas Island']);
        DB::table($table)->insert(['code' => 'CC', 'name' => 'Cocos (Keeling Islands\')']);
        DB::table($table)->insert(['code' => 'CO', 'name' => 'Colombia']);
        DB::table($table)->insert(['code' => 'KM', 'name' => 'Comoros']);
        DB::table($table)->insert(['code' => 'CG', 'name' => 'Congo']);
        DB::table($table)->insert(['code' => 'CK', 'name' => 'Cook Islands']);
        DB::table($table)->insert(['code' => 'CR', 'name' => 'Costa Rica']);
        DB::table($table)->insert(['code' => 'HR', 'name' => 'Croatia (Hrvatska)']);
        DB::table($table)->insert(['code' => 'CU', 'name' => 'Cuba']);
        DB::table($table)->insert(['code' => 'CY', 'name' => 'Cyprus']);
        DB::table($table)->insert(['code' => 'CZ', 'name' => 'Czech Republic']);
        DB::table($table)->insert(['code' => 'DK', 'name' => 'Denmark']);
        DB::table($table)->insert(['code' => 'DJ', 'name' => 'Djibouti']);
        DB::table($table)->insert(['code' => 'DM', 'name' => 'Dominica']);
        DB::table($table)->insert(['code' => 'DO', 'name' => 'Dominican Republic']);
        DB::table($table)->insert(['code' => 'TP', 'name' => 'East Timor']);
        DB::table($table)->insert(['code' => 'EC', 'name' => 'Ecuador']);
        DB::table($table)->insert(['code' => 'EG', 'name' => 'Egypt']);
        DB::table($table)->insert(['code' => 'SV', 'name' => 'El Salvador']);
        DB::table($table)->insert(['code' => 'GQ', 'name' => 'Equatorial Guinea']);
        DB::table($table)->insert(['code' => 'ER', 'name' => 'Eritrea']);
        DB::table($table)->insert(['code' => 'EE', 'name' => 'Estonia']);
        DB::table($table)->insert(['code' => 'ET', 'name' => 'Ethiopia']);
        DB::table($table)->insert(['code' => 'FK', 'name' => 'Falkland Islands(Malvinas)']);
        DB::table($table)->insert(['code' => 'FO', 'name' => 'Faroe Islands']);
        DB::table($table)->insert(['code' => 'FJ', 'name' => 'Fiji']);
        DB::table($table)->insert(['code' => 'FI', 'name' => 'Finland']);
        DB::table($table)->insert(['code' => 'FR', 'name' => 'France']);
        DB::table($table)->insert(['code' => 'FX', 'name' => 'France Metropolitan']);
        DB::table($table)->insert(['code' => 'GF', 'name' => 'French Guiana']);
        DB::table($table)->insert(['code' => 'PF', 'name' => 'French Polynesia']);
        DB::table($table)->insert(['code' => 'TF', 'name' => 'French Southern Territories']);
        DB::table($table)->insert(['code' => 'GA', 'name' => 'Gabon']);
        DB::table($table)->insert(['code' => 'GM', 'name' => 'Gambia']);
        DB::table($table)->insert(['code' => 'GE', 'name' => 'Georgia']);
        DB::table($table)->insert(['code' => 'DE', 'name' => 'Germany']);
        DB::table($table)->insert(['code' => 'GH', 'name' => 'Ghana']);
        DB::table($table)->insert(['code' => 'GI', 'name' => 'Gibraltar']);
        DB::table($table)->insert(['code' => 'GK', 'name' => 'Guernsey']);
        DB::table($table)->insert(['code' => 'GR', 'name' => 'Greece']);
        DB::table($table)->insert(['code' => 'GL', 'name' => 'Greenland']);
        DB::table($table)->insert(['code' => 'GD', 'name' => 'Grenada']);
        DB::table($table)->insert(['code' => 'GP', 'name' => 'Guadeloupe']);
        DB::table($table)->insert(['code' => 'GU', 'name' => 'Guam']);
        DB::table($table)->insert(['code' => 'GT', 'name' => 'Guatemala']);
        DB::table($table)->insert(['code' => 'GN', 'name' => 'Guinea']);
        DB::table($table)->insert(['code' => 'GW', 'name' => 'Guinea-Bissau']);
        DB::table($table)->insert(['code' => 'GY', 'name' => 'Guyana']);
        DB::table($table)->insert(['code' => 'HT', 'name' => 'Haiti']);
        DB::table($table)->insert(['code' => 'HM', 'name' => 'Heard and Mc Donald Islands']);
        DB::table($table)->insert(['code' => 'HN', 'name' => 'Honduras']);
        DB::table($table)->insert(['code' => 'HK', 'name' => 'Hong Kong']);
        DB::table($table)->insert(['code' => 'HU', 'name' => 'Hungary']);
        DB::table($table)->insert(['code' => 'IS', 'name' => 'Iceland']);
        DB::table($table)->insert(['code' => 'IN', 'name' => 'India']);
        DB::table($table)->insert(['code' => 'IM', 'name' => 'Isle of Man']);
        DB::table($table)->insert(['code' => 'ID', 'name' => 'Indonesia']);
        DB::table($table)->insert(['code' => 'IR', 'name' => 'Iran(Islamic Republic of)']);
        DB::table($table)->insert(['code' => 'IQ', 'name' => 'Iraq']);
        DB::table($table)->insert(['code' => 'IE', 'name' => 'Ireland']);
        DB::table($table)->insert(['code' => 'IL', 'name' => 'Israel']);
        DB::table($table)->insert(['code' => 'IT', 'name' => 'Italy']);
        DB::table($table)->insert(['code' => 'CI', 'name' => 'Ivory Coast']);
        DB::table($table)->insert(['code' => 'JE', 'name' => 'Jersey']);
        DB::table($table)->insert(['code' => 'JM', 'name' => 'Jamaica']);
        DB::table($table)->insert(['code' => 'JP', 'name' => 'Japan']);
        DB::table($table)->insert(['code' => 'JO', 'name' => 'Jordan']);
        DB::table($table)->insert(['code' => 'KZ', 'name' => 'Kazakhstan']);
        DB::table($table)->insert(['code' => 'KE', 'name' => 'Kenya']);
        DB::table($table)->insert(['code' => 'KI', 'name' => 'Kiribati']);
        DB::table($table)->insert(['code' => 'KP', 'name' => 'Korea(Democratic People\'s Republic of)']);
        DB::table($table)->insert(['code' => 'KR', 'name' => 'Korea (Republic of)']);
        DB::table($table)->insert(['code' => 'XK', 'name' => 'Kosovo']);
        DB::table($table)->insert(['code' => 'KW', 'name' => 'Kuwait']);
        DB::table($table)->insert(['code' => 'KG', 'name' => 'Kyrgyzstan']);
        DB::table($table)->insert(['code' => 'LA', 'name' => 'Lao People\'s Democratic Republic']);
        DB::table($table)->insert(['code' => 'LV', 'name' => 'Latvia']);
        DB::table($table)->insert(['code' => 'LB', 'name' => 'Lebanon']);
        DB::table($table)->insert(['code' => 'LS', 'name' => 'Lesotho']);
        DB::table($table)->insert(['code' => 'LR', 'name' => 'Liberia']);
        DB::table($table)->insert(['code' => 'LY', 'name' => 'Libyan Arab Jamahiriya']);
        DB::table($table)->insert(['code' => 'LI', 'name' => 'Liechtenstein']);
        DB::table($table)->insert(['code' => 'LT', 'name' => 'Lithuania']);
        DB::table($table)->insert(['code' => 'LU', 'name' => 'Luxembourg']);
        DB::table($table)->insert(['code' => 'MO', 'name' => 'Macau']);
        DB::table($table)->insert(['code' => 'MK', 'name' => 'Macedonia']);
        DB::table($table)->insert(['code' => 'MG', 'name' => 'Madagascar']);
        DB::table($table)->insert(['code' => 'MW', 'name' => 'Malawi']);
        DB::table($table)->insert(['code' => 'MY', 'name' => 'Malaysia']);
        DB::table($table)->insert(['code' => 'MV', 'name' => 'Maldives']);
        DB::table($table)->insert(['code' => 'ML', 'name' => 'Mali']);
        DB::table($table)->insert(['code' => 'MT', 'name' => 'Malta']);
        DB::table($table)->insert(['code' => 'MH', 'name' => 'Marshall Islands']);
        DB::table($table)->insert(['code' => 'MQ', 'name' => 'Martinique']);
        DB::table($table)->insert(['code' => 'MR', 'name' => 'Mauritania']);
        DB::table($table)->insert(['code' => 'MU', 'name' => 'Mauritius']);
        DB::table($table)->insert(['code' => 'TY', 'name' => 'Mayotte']);
        DB::table($table)->insert(['code' => 'MX', 'name' => 'Mexico']);
        DB::table($table)->insert(['code' => 'FM', 'name' => 'Micronesia  (Federated States of)']);
        DB::table($table)->insert(['code' => 'MD', 'name' => 'Moldova  (Republic of)']);
        DB::table($table)->insert(['code' => 'MC', 'name' => 'Monaco']);
        DB::table($table)->insert(['code' => 'MN', 'name' => 'Mongolia']);
        DB::table($table)->insert(['code' => 'ME', 'name' => 'Montenegro']);
        DB::table($table)->insert(['code' => 'MS', 'name' => 'Montserrat']);
        DB::table($table)->insert(['code' => 'MA', 'name' => 'Morocco']);
        DB::table($table)->insert(['code' => 'MZ', 'name' => 'Mozambique']);
        DB::table($table)->insert(['code' => 'MM', 'name' => 'Myanmar']);
        DB::table($table)->insert(['code' => 'NA', 'name' => 'Namibia']);
        DB::table($table)->insert(['code' => 'NR', 'name' => 'Nauru']);
        DB::table($table)->insert(['code' => 'NP', 'name' => 'Nepal']);
        DB::table($table)->insert(['code' => 'NL', 'name' => 'Netherlands']);
        DB::table($table)->insert(['code' => 'AN', 'name' => 'Netherlands Antilles']);
        DB::table($table)->insert(['code' => 'NC', 'name' => 'New Caledonia']);
        DB::table($table)->insert(['code' => 'NZ', 'name' => 'New Zealand']);
        DB::table($table)->insert(['code' => 'NI', 'name' => 'Nicaragua']);
        DB::table($table)->insert(['code' => 'NE', 'name' => 'Niger']);
        DB::table($table)->insert(['code' => 'NG', 'name' => 'Nigeria']);
        DB::table($table)->insert(['code' => 'NU', 'name' => 'Niue']);
        DB::table($table)->insert(['code' => 'NF', 'name' => 'Norfolk Island']);
        DB::table($table)->insert(['code' => 'MP', 'name' => 'Northern Mariana Islands']);
        DB::table($table)->insert(['code' => 'NO', 'name' => 'Norway']);
        DB::table($table)->insert(['code' => 'OM', 'name' => 'Oman']);
        DB::table($table)->insert(['code' => 'PK', 'name' => 'Pakistan']);
        DB::table($table)->insert(['code' => 'PW', 'name' => 'Palau']);
        DB::table($table)->insert(['code' => 'PS', 'name' => 'Palestine']);
        DB::table($table)->insert(['code' => 'PA', 'name' => 'Panama']);
        DB::table($table)->insert(['code' => 'PG', 'name' => 'Papua New Guinea']);
        DB::table($table)->insert(['code' => 'PY', 'name' => 'Paraguay']);
        DB::table($table)->insert(['code' => 'PE', 'name' => 'Peru']);
        DB::table($table)->insert(['code' => 'PH', 'name' => 'Philippines']);
        DB::table($table)->insert(['code' => 'PN', 'name' => 'Pitcairn']);
        DB::table($table)->insert(['code' => 'PL', 'name' => 'Poland']);
        DB::table($table)->insert(['code' => 'PT', 'name' => 'Portugal']);
        DB::table($table)->insert(['code' => 'PR', 'name' => 'Puerto Rico']);
        DB::table($table)->insert(['code' => 'QA', 'name' => 'Qatar']);
        DB::table($table)->insert(['code' => 'RE', 'name' => 'Reunion']);
        DB::table($table)->insert(['code' => 'RO', 'name' => 'Romania']);
        DB::table($table)->insert(['code' => 'RU', 'name' => 'Russian Federation']);
        DB::table($table)->insert(['code' => 'RW', 'name' => 'Rwanda']);
        DB::table($table)->insert(['code' => 'KN', 'name' => 'Saint Kitts and Nevis']);
        DB::table($table)->insert(['code' => 'LC', 'name' => 'Saint Lucia']);
        DB::table($table)->insert(['code' => 'VC', 'name' => 'Saint Vincent and the Grenadines']);
        DB::table($table)->insert(['code' => 'WS', 'name' => 'Samoa']);
        DB::table($table)->insert(['code' => 'SM', 'name' => 'San Marino']);
        DB::table($table)->insert(['code' => 'ST', 'name' => 'Sao Tome and Principe']);
        DB::table($table)->insert(['code' => 'SA', 'name' => 'Saudi Arabia']);
        DB::table($table)->insert(['code' => 'SN', 'name' => 'Senegal']);
        DB::table($table)->insert(['code' => 'RS', 'name' => 'Serbia']);
        DB::table($table)->insert(['code' => 'SC', 'name' => 'Seychelles']);
        DB::table($table)->insert(['code' => 'SL', 'name' => 'Sierra Leone']);
        DB::table($table)->insert(['code' => 'SG', 'name' => 'Singapore']);
        DB::table($table)->insert(['code' => 'SK', 'name' => 'Slovakia']);
        DB::table($table)->insert(['code' => 'SI', 'name' => 'Slovenia']);
        DB::table($table)->insert(['code' => 'SB', 'name' => 'Solomon Islands']);
        DB::table($table)->insert(['code' => 'SO', 'name' => 'Somalia']);
        DB::table($table)->insert(['code' => 'ZA', 'name' => 'South Africa']);
        DB::table($table)->insert(['code' => 'GS', 'name' => 'South Georgia South Sandwich Islands']);
        DB::table($table)->insert(['code' => 'ES', 'name' => 'Spain']);
        DB::table($table)->insert(['code' => 'LK', 'name' => 'Sri Lanka']);
        DB::table($table)->insert(['code' => 'SH', 'name' => 'St. Helena']);
        DB::table($table)->insert(['code' => 'PM', 'name' => 'St. Pierre and Miquelon']);
        DB::table($table)->insert(['code' => 'SD', 'name' => 'Sudan']);
        DB::table($table)->insert(['code' => 'SR', 'name' => 'Suriname']);
        DB::table($table)->insert(['code' => 'SJ', 'name' => 'Svalbard and Jan Mayen Islands']);
        DB::table($table)->insert(['code' => 'SZ', 'name' => 'Swaziland']);
        DB::table($table)->insert(['code' => 'SE', 'name' => 'Sweden']);
        DB::table($table)->insert(['code' => 'CH', 'name' => 'Switzerland']);
        DB::table($table)->insert(['code' => 'SY', 'name' => 'Syrian Arab Republic']);
        DB::table($table)->insert(['code' => 'TW', 'name' => 'Taiwan']);
        DB::table($table)->insert(['code' => 'TJ', 'name' => 'Tajikistan']);
        DB::table($table)->insert(['code' => 'TZ', 'name' => 'Tanzania ( United Republic of)']);
        DB::table($table)->insert(['code' => 'TH', 'name' => 'Thailand']);
        DB::table($table)->insert(['code' => 'TG', 'name' => 'Togo']);
        DB::table($table)->insert(['code' => 'TK', 'name' => 'Tokelau']);
        DB::table($table)->insert(['code' => 'TO', 'name' => 'Tonga']);
        DB::table($table)->insert(['code' => 'TT', 'name' => 'Trinidad and Tobago']);
        DB::table($table)->insert(['code' => 'TN', 'name' => 'Tunisia']);
        DB::table($table)->insert(['code' => 'TR', 'name' => 'Turkey']);
        DB::table($table)->insert(['code' => 'TM', 'name' => 'Turkmenistan']);
        DB::table($table)->insert(['code' => 'TC', 'name' => 'Turks and Caicos Islands']);
        DB::table($table)->insert(['code' => 'TV', 'name' => 'Tuvalu']);
        DB::table($table)->insert(['code' => 'UG', 'name' => 'Uganda']);
        DB::table($table)->insert(['code' => 'UA', 'name' => 'Ukraine']);
        DB::table($table)->insert(['code' => 'AE', 'name' => 'United Arab Emirates']);
        DB::table($table)->insert(['code' => 'GB', 'name' => 'United Kingdom']);
        DB::table($table)->insert(['code' => 'US', 'name' => 'United States']);
        DB::table($table)->insert(['code' => 'UM', 'name' => 'United States minor outlying islands']);
        DB::table($table)->insert(['code' => 'UY', 'name' => 'Uruguay']);
        DB::table($table)->insert(['code' => 'UZ', 'name' => 'Uzbekistan']);
        DB::table($table)->insert(['code' => 'VU', 'name' => 'Vanuatu']);
        DB::table($table)->insert(['code' => 'VA', 'name' => 'Vatican City State']);
        DB::table($table)->insert(['code' => 'VE', 'name' => 'Venezuela']);
        DB::table($table)->insert(['code' => 'VN', 'name' => 'Vietnam']);
        DB::table($table)->insert(['code' => 'VG', 'name' => 'Virgin Islands (British)']);
        DB::table($table)->insert(['code' => 'VI', 'name' => 'Virgin Islands(U.S.)']);
        DB::table($table)->insert(['code' => 'WF', 'name' => 'Wallis and Futuna Islands']);
        DB::table($table)->insert(['code' => 'EH', 'name' => 'Western Sahara']);
        DB::table($table)->insert(['code' => 'YE', 'name' => 'Yemen']);
        DB::table($table)->insert(['code' => 'ZR', 'name' => 'Zaire']);
        DB::table($table)->insert(['code' => 'ZM', 'name' => 'Zambia']);
        DB::table($table)->insert(['code' => 'ZW', 'name' => 'Zimbabwe']);
    }

}