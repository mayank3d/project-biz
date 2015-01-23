<?php
session_start();
include_once 'library.php';
include 'UserManager.php';

if (isset($_SESSION['username']) && ($_SESSION['isAllowed'] == 'true')) {
    
} else {
    $_SESSION['notification'] = 'InValid Login';
    redirect('index.php');
}

$time_jone = array('Africa/Abidjan'=>'Abidjan','Africa/Accra'=>'Accra','Africa/Addis_Ababa'=>'Addis Ababa','Africa/Algiers'=>'Algiers','Africa/Asmara'=>'Asmara',
'Africa/Bamako'=>'Bamako','Africa/Bangui'=>'Bangui','Africa/Banjul'=>'Banjul','Africa/Bissau'=>'Bissau','Africa/Blantyre'=>'Blantyre','Africa/Brazzaville'=>'Brazzaville',
'Africa/Bujumbura'=>'Bujumbura','Africa/Cairo'=>'Cairo','Africa/Casablanca'=>'Casablanca','Africa/Ceuta'=>'Ceuta','Africa/Conakry'=>'Conakry','Africa/Dakar'=>'Dakar',
'Africa/Dar_es_Salaam'=>'Dar es Salaam','Africa/Djibouti'=>'Djibouti','Africa/Douala'=>'Douala','Africa/El_Aaiun'=>'El Aaiun','Africa/Freetown'=>'Freetown','Africa/Gaborone'=>'Gaborone',
'Africa/Harare'=>'Harare','Africa/Johannesburg'=>'Johannesburg','Africa/Kampala'=>'Kampala','Africa/Khartoum'=>'Khartoum','Africa/Kigali'=>'Kigali','Africa/Kinshasa'=>'Kinshasa',
'Africa/Lagos'=>'Lagos','Africa/Libreville'=>'Libreville','Africa/Lome'=>'Lome','Africa/Luanda'=>'Luanda','Africa/Lubumbashi'=>'Lubumbashi','Africa/Lusaka'=>'Lusaka',
'Africa/Malabo'=>'Malabo','Africa/Maputo'=>'Maputo','Africa/Maseru'=>'Maseru','Africa/Mbabane'=>'Mbabane','Africa/Mogadishu'=>'Mogadishu','Africa/Monrovia'=>'Monrovia',
'Africa/Nairobi'=>'Nairobi','Africa/Ndjamena'=>'Ndjamena','Africa/Niamey'=>'Niamey','Africa/Nouakchott'=>'Nouakchott','Africa/Ouagadougou'=>'Ouagadougou','Africa/Porto-Novo'=>'Porto-Novo',
'Africa/Sao_Tome'=>'Sao Tome','Africa/Tripoli'=>'Tripoli','Africa/Tunis'=>'Tunis','Africa/Windhoek'=>'Windhoek','America/Adak'=>'Adak','America/Anchorage'=>'Anchorage','America/Anguilla'=>'Anguilla','America/Antigua'=>'Antigua','America/Araguaina'=>'Araguaina',
'America/Argentina/Buenos_Aires'=>'Argentina - Buenos Aires','America/Argentina/Catamarca'=>'Argentina - Catamarca','America/Argentina/Cordoba'=>'Argentina - Cordoba',
'America/Argentina/Jujuy'=>'Argentina - Jujuy','America/Argentina/La_Rioja'=>'Argentina - La Rioja','America/Argentina/Mendoza'=>'Argentina - Mendoza',
'America/Argentina/Rio_Gallegos'=>'Argentina - Rio Gallegos','America/Argentina/Salta'=>'Argentina - Salta','America/Argentina/San_Juan'=>'Argentina - San Juan',
'America/Argentina/San_Luis'=>'Argentina - San Luis','America/Argentina/Tucuman'=>'Argentina - Tucuman','America/Argentina/Ushuaia'=>'Argentina - Ushuaia',
'America/Aruba'=>'Aruba','America/Asuncion'=>'Asuncion','America/Atikokan'=>'Atikokan','America/Bahia'=>'Bahia','America/Bahia_Banderas'=>'Bahia Banderas','America/Barbados'=>'Barbados',
'America/Belem'=>'Belem','America/Belize'=>'Belize','America/Blanc-Sablon'=>'Blanc-Sablon','America/Boa_Vista'=>'Boa Vista','America/Bogota'=>'Bogota','America/Boise'=>'Boise',
'America/Cambridge_Bay'=>'Cambridge Bay','America/Campo_Grande'=>'Campo Grande','America/Cancun'=>'Cancun','America/Caracas'=>'Caracas','America/Cayenne'=>'Cayenne',
'America/Cayman'=>'Cayman','America/Chicago'=>'Chicago','America/Chihuahua'=>'Chihuahua','America/Costa_Rica'=>'Costa Rica','America/Cuiaba'=>'Cuiaba','America/Curacao'=>'Curacao',
'America/Danmarkshavn'=>'Danmarkshavn','America/Dawson'=>'Dawson','America/Dawson_Creek'=>'Dawson Creek','America/Denver'=>'Denver','America/Detroit'=>'Detroit',
'America/Dominica'=>'Dominica','America/Edmonton'=>'Edmonton','America/Eirunepe'=>'Eirunepe','America/El_Salvador'=>'El Salvador','America/Fortaleza'=>'Fortaleza',
'America/Glace_Bay'=>'Glace Bay','America/Godthab'=>'Godthab','America/Goose_Bay'=>'Goose Bay','America/Grand_Turk'=>'Grand Turk','America/Grenada'=>'Grenada',
'America/Guadeloupe'=>'Guadeloupe','America/Guatemala'=>'Guatemala','America/Guayaquil'=>'Guayaquil','America/Guyana'=>'Guyana','America/Halifax'=>'Halifax','America/Havana'=>'Havana',
'America/Hermosillo'=>'Hermosillo','America/Indiana/Indianapolis'=>'Indiana - Indianapolis','America/Indiana/Knox'=>'Indiana - Knox','America/Indiana/Marengo'=>'Indiana - Marengo',
'America/Indiana/Petersburg'=>'Indiana - Petersburg','America/Indiana/Tell_City'=>'Indiana - Tell City','America/Indiana/Vevay'=>'Indiana - Vevay',
'America/Indiana/Vincennes'=>'Indiana - Vincennes','America/Indiana/Winamac'=>'Indiana - Winamac','America/Inuvik'=>'Inuvik',
'America/Iqaluit'=>'Iqaluit','America/Jamaica'=>'Jamaica','America/Juneau'=>'Juneau','America/Kentucky/Louisville'=>'Kentucky - Louisville',
'America/Kentucky/Monticello'=>'Kentucky - Monticello','America/La_Paz'=>'La Paz','America/Lima'=>'Lima','America/Los_Angeles'=>'Los Angeles','America/Maceio'=>'Maceio',
'America/Managua'=>'Managua','America/Manaus'=>'Manaus','America/Marigot'=>'Marigot','America/Martinique'=>'Martinique','America/Matamoros'=>'Matamoros',
'America/Mazatlan'=>'Mazatlan','America/Menominee'=>'Menominee','America/Merida'=>'Merida','America/Mexico_City'=>'Mexico City','America/Miquelon'=>'Miquelon',
'America/Moncton'=>'Moncton','America/Monterrey'=>'Monterrey','America/Montevideo'=>'Montevideo','America/Montreal'=>'Montreal','America/Montserrat'=>'Montserrat',
'America/Nassau'=>'Nassau','America/New_York'=>'New York','America/Nipigon'=>'Nipigon','America/Nome'=>'Nome','America/Noronha'=>'Noronha','America/North_Dakota/Center'=>'North Dakota - Center',
'America/North_Dakota/New_Salem'=>'North Dakota - New Salem','America/Ojinaga'=>'Ojinaga','America/Panama'=>'Panama','America/Pangnirtung'=>'Pangnirtung',
'America/Paramaribo'=>'Paramaribo','America/Phoenix'=>'Phoenix','America/Port-au-Prince'=>'Port-au-Prince','America/Port_of_Spain'=>'Port of Spain','America/Porto_Velho'=>'Porto Velho',
'America/Puerto_Rico'=>'Puerto Rico','America/Rainy_River'=>'Rainy River','America/Rankin_Inlet'=>'Rankin Inlet','America/Recife'=>'Recife','America/Regina'=>'Regina',
'America/Resolute'=>'Resolute','America/Rio_Branco'=>'Rio Branco','America/Santa_Isabel'=>'Santa Isabel','America/Santarem'=>'Santarem','America/Santiago'=>'Santiago',
'America/Santo_Domingo'=>'Santo Domingo','America/Sao_Paulo'=>'Sao Paulo','America/Scoresbysund'=>'Scoresbysund','America/Shiprock'=>'Shiprock','America/St_Barthelemy'=>'St Barthelemy',
'America/St_Johns'=>'St Johns','America/St_Kitts'=>'St Kitts','America/St_Lucia'=>'St Lucia','America/St_Thomas'=>'St Thomas','America/St_Vincent'=>'St Vincent',
'America/Swift_Current'=>'Swift Current','America/Tegucigalpa'=>'Tegucigalpa','America/Thule'=>'Thule','America/Thunder_Bay'=>'Thunder Bay','America/Tijuana'=>'Tijuana',
'America/Toronto'=>'Toronto','America/Tortola'=>'Tortola','America/Vancouver'=>'Vancouver','America/Whitehorse'=>'Whitehorse','America/Winnipeg'=>'Winnipeg',
'America/Yakutat'=>'Yakutat','America/Yellowknife'=>'Yellowknife','Antarctica/Casey'=>'Casey','Antarctica/Davis'=>'Davis','Antarctica/DumontDUrville'=>'DumontDUrville','Antarctica/Macquarie'=>'Macquarie',
'Antarctica/Mawson'=>'Mawson','Antarctica/McMurdo'=>'McMurdo','Antarctica/Palmer'=>'Palmer','Antarctica/Rothera'=>'Rothera','Antarctica/South_Pole'=>'South Pole',
'Antarctica/Syowa'=>'Syowa','Antarctica/Vostok'=>'Vostok','Asia/Aden'=>'Aden','Asia/Almaty'=>'Almaty','Asia/Amman'=>'Amman','Asia/Anadyr'=>'Anadyr','Asia/Aqtau'=>'Aqtau',
'Asia/Aqtobe'=>'Aqtobe','Asia/Ashgabat'=>'Ashgabat','Asia/Baghdad'=>'Baghdad','Asia/Bahrain'=>'Bahrain','Asia/Baku'=>'Baku','Asia/Bangkok'=>'Bangkok','Asia/Beirut'=>'Beirut',
'Asia/Bishkek'=>'Bishkek','Asia/Brunei'=>'Brunei','Asia/Choibalsan'=>'Choibalsan','Asia/Chongqing'=>'Chongqing','Asia/Colombo'=>'Colombo','Asia/Damascus'=>'Damascus',
'Asia/Dhaka'=>'Dhaka','Asia/Dili'=>'Dili','Asia/Dubai'=>'Dubai','Asia/Dushanbe'=>'Dushanbe','Asia/Gaza'=>'Gaza','Asia/Harbin'=>'Harbin','Asia/Ho_Chi_Minh'=>'Ho Chi Minh',
'Asia/Hong_Kong'=>'Hong Kong','Asia/Hovd'=>'Hovd','Asia/Irkutsk'=>'Irkutsk','Asia/Jakarta'=>'Jakarta','Asia/Jayapura'=>'Jayapura','Asia/Jerusalem'=>'Jerusalem',
'Asia/Kabul'=>'Kabul','Asia/Kamchatka'=>'Kamchatka','Asia/Karachi'=>'Karachi','Asia/Kashgar'=>'Kashgar','Asia/Kathmandu'=>'Kathmandu','Asia/Kolkata'=>'Kolkata',
'Asia/Krasnoyarsk'=>'Krasnoyarsk','Asia/Kuala_Lumpur'=>'Kuala Lumpur','Asia/Kuching'=>'Kuching','Asia/Kuwait'=>'Kuwait','Asia/Macau'=>'Macau','Asia/Magadan'=>'Magadan',
'Asia/Makassar'=>'Makassar','Asia/Manila'=>'Manila','Asia/Muscat'=>'Muscat','Asia/Nicosia'=>'Nicosia','Asia/Novokuznetsk'=>'Novokuznetsk','Asia/Novosibirsk'=>'Novosibirsk',
'Asia/Omsk'=>'Omsk','Asia/Oral'=>'Oral','Asia/Phnom_Penh'=>'Phnom Penh','Asia/Pontianak'=>'Pontianak','Asia/Pyongyang'=>'Pyongyang','Asia/Qatar'=>'Qatar','Asia/Qyzylorda'=>'Qyzylorda',
'Asia/Rangoon'=>'Rangoon','Asia/Riyadh'=>'Riyadh','Asia/Sakhalin'=>'Sakhalin','Asia/Samarkand'=>'Samarkand','Asia/Seoul'=>'Seoul','Asia/Shanghai'=>'Shanghai','Asia/Singapore'=>'Singapore',
'Asia/Taipei'=>'Taipei','Asia/Tashkent'=>'Tashkent','Asia/Tbilisi'=>'Tbilisi','Asia/Tehran'=>'Tehran','Asia/Thimphu'=>'Thimphu','Asia/Tokyo'=>'Tokyo','Asia/Ulaanbaatar'=>'Ulaanbaatar',
'Asia/Urumqi'=>'Urumqi','Asia/Vientiane'=>'Vientiane','Asia/Vladivostok'=>'Vladivostok','Asia/Yakutsk'=>'Yakutsk','Asia/Yekaterinburg'=>'Yekaterinburg','Asia/Yerevan'=>'Yerevan','Atlantic/Azores'=>'Azores',
'Atlantic/Bermuda'=>'Bermuda','Atlantic/Canary'=>'Canary','Atlantic/Cape_Verde'=>'Cape Verde','Atlantic/Faroe'=>'Faroe','Atlantic/Madeira'=>'Madeira','Atlantic/Reykjavik'=>'Reykjavik',
'Atlantic/South_Georgia'=>'South Georgia','Atlantic/Stanley'=>'Stanley','Atlantic/St_Helena'=>'St Helena','Australia/Adelaide'=>'Adelaide','Australia/Brisbane'=>'Brisbane',
'Australia/Broken_Hill'=>'Broken Hill','Australia/Currie'=>'Currie','Australia/Darwin'=>'Darwin','Australia/Eucla'=>'Eucla','Australia/Hobart'=>'Hobart','Australia/Lindeman'=>'Lindeman',
'Australia/Lord_Howe'=>'Lord Howe','Australia/Melbourne'=>'Melbourne','Australia/Perth'=>'Perth','Australia/Sydney'=>'Sydney','Europe/Amsterdam'=>'Amsterdam',
'Europe/Andorra'=>'Andorra','Europe/Athens'=>'Athens','Europe/Belgrade'=>'Belgrade','Europe/Berlin'=>'Berlin','Europe/Bratislava'=>'Bratislava','Europe/Brussels'=>'Brussels',
'Europe/Bucharest'=>'Bucharest','Europe/Budapest'=>'Budapest','Europe/Chisinau'=>'Chisinau','Europe/Copenhagen'=>'Copenhagen','Europe/Dublin'=>'Dublin','Europe/Gibraltar'=>'Gibraltar',
'Europe/Guernsey'=>'Guernsey','Europe/Helsinki'=>'Helsinki','Europe/Isle_of_Man'=>'Isle of Man','Europe/Istanbul'=>'Istanbul','Europe/Jersey'=>'Jersey','Europe/Kaliningrad'=>'Kaliningrad',
'Europe/Kiev'=>'Kiev','Europe/Lisbon'=>'Lisbon','Europe/Ljubljana'=>'Ljubljana','Europe/London'=>'London','Europe/Luxembourg'=>'Luxembourg','Europe/Madrid'=>'Madrid',
'Europe/Malta'=>'Malta','Europe/Mariehamn'=>'Mariehamn','Europe/Minsk'=>'Minsk','Europe/Monaco'=>'Monaco','Europe/Moscow'=>'Moscow','Europe/Oslo'=>'Oslo','Europe/Paris'=>'Paris',
'Europe/Podgorica'=>'Podgorica','Europe/Prague'=>'Prague','Europe/Riga'=>'Riga','Europe/Rome'=>'Rome','Europe/Samara'=>'Samara','Europe/San_Marino'=>'San Marino',
'Europe/Sarajevo'=>'Sarajevo','Europe/Simferopol'=>'Simferopol','Europe/Skopje'=>'Skopje','Europe/Sofia'=>'Sofia','Europe/Stockholm'=>'Stockholm',
'Europe/Tallinn'=>'Tallinn','Europe/Tirane'=>'Tirane','Europe/Uzhgorod'=>'Uzhgorod','Europe/Vaduz'=>'Vaduz','Europe/Vatican'=>'Vatican','Europe/Vienna'=>'Vienna',
'Europe/Vilnius'=>'Vilnius','Europe/Volgograd'=>'Volgograd','Europe/Warsaw'=>'Warsaw','Europe/Zagreb'=>'Zagreb','Europe/Zaporozhye'=>'Zaporozhye','Europe/Zurich'=>'Zurich','Indian/Antananarivo'=>'Antananarivo',
'Indian/Chagos'=>'Chagos','Indian/Christmas'=>'Christmas','Indian/Cocos'=>'Cocos','Indian/Comoro'=>'Comoro','Indian/Kerguelen'=>'Kerguelen','Indian/Mahe'=>'Mahe',
'Indian/Maldives'=>'Maldives','Indian/Mauritius'=>'Mauritius','Indian/Mayotte'=>'Mayotte','Indian/Reunion'=>'Reunion','Pacific/Apia'=>'Apia','Pacific/Auckland'=>'Auckland',
'Pacific/Chatham'=>'Chatham','Pacific/Chuuk'=>'Chuuk','Pacific/Easter'=>'Easter','Pacific/Efate'=>'Efate','Pacific/Enderbury'=>'Enderbury','Pacific/Fakaofo'=>'Fakaofo',
'Pacific/Fiji'=>'Fiji','Pacific/Funafuti'=>'Funafuti','Pacific/Galapagos'=>'Galapagos','Pacific/Gambier'=>'Gambier','Pacific/Guadalcanal'=>'Guadalcanal','Pacific/Guam'=>'Guam',
'Pacific/Honolulu'=>'Honolulu','Pacific/Johnston'=>'Johnston','Pacific/Kiritimati'=>'Kiritimati','Pacific/Kosrae'=>'Kosrae','Pacific/Kwajalein'=>'Kwajalein','Pacific/Majuro'=>'Majuro',
'Pacific/Marquesas'=>'Marquesas','Pacific/Midway'=>'Midway','Pacific/Nauru'=>'Nauru','Pacific/Niue'=>'Niue','Pacific/Norfolk'=>'Norfolk','Pacific/Noumea'=>'Noumea',
'Pacific/Pago_Pago'=>'Pago Pago','Pacific/Palau'=>'Palau','Pacific/Pitcairn'=>'Pitcairn','Pacific/Pohnpei'=>'Pohnpei','Pacific/Port_Moresby'=>'Port Moresby','Pacific/Rarotonga'=>'Rarotonga',
'Pacific/Saipan'=>'Saipan','Pacific/Tahiti'=>'Tahiti','Pacific/Tarawa'=>'Tarawa','Pacific/Tongatapu'=>'Tongatapu','Pacific/Wake'=>'Wake','Pacific/Wallis'=>'Wallis','UTC-12'=>'UTC-12',
'UTC-11.5'=>'UTC-11:30','UTC-11'=>'UTC-11','UTC-10.5'=>'UTC-10:30','UTC-10'=>'UTC-10','UTC-9.5'=>'UTC-9:30','UTC-9'=>'UTC-9','UTC-8.5'=>'UTC-8:30','UTC-8'=>'UTC-8',
'UTC-7.5'=>'UTC-7:30','UTC-7'=>'UTC-7','UTC-6.5'=>'UTC-6:30','UTC-6'=>'UTC-6','UTC-5.5'=>'UTC-5:30','UTC-5'=>'UTC-5','UTC-4.5'=>'UTC-4:30','UTC-4'=>'UTC-4','UTC-3.5'=>'UTC-3:30',
'UTC-3'=>'UTC-3','UTC-2.5'=>'UTC-2:30','UTC-2'=>'UTC-2','UTC-1.5'=>'UTC-1:30','UTC-1'=>'UTC-1','UTC-0.5'=>'UTC-0:30','UTC+0'=>'UTC+0','UTC+0.5'=>'UTC+0:30','UTC+1'=>'UTC+1',
'UTC+1.5'=>'UTC+1:30','UTC+2'=>'UTC+2','UTC+2.5'=>'UTC+2:30','UTC+3'=>'UTC+3','UTC+3.5'=>'UTC+3:30','UTC+4'=>'UTC+4','UTC+4.5'=>'UTC+4:30','UTC+5'=>'UTC+5','UTC+5.5'=>'UTC+5:30',
'UTC+5.75'=>'UTC+5:45','UTC+6'=>'UTC+6','UTC+6.5'=>'UTC+6:30','UTC+7'=>'UTC+7','UTC+7.5'=>'UTC+7:30','UTC+8'=>'UTC+8','UTC+8.5'=>'UTC+8:30','UTC+8.75'=>'UTC+8:45','UTC+9'=>'UTC+9',
'UTC+9.5'=>'UTC+9:30','UTC+10'=>'UTC+10','UTC+10.5'=>'UTC+10:30','UTC+11'=>'UTC+11','UTC+11.5'=>'UTC+11:30','UTC+12'=>'UTC+12','UTC+12.75'=>'UTC+12:45','UTC+13'=>'UTC+13','UTC+13.75'=>'UTC+13:45',
'UTC+14'=>'UTC+14');


$time_jone = array(    'Hawaii'=>'(GMT-10:00) Hawaii',
              'Alaska'=>'(GMT-09:00) Alaska',
              'Pacific Time (US &amp; Canada)'=>'(GMT-08:00) Pacific Time (US &amp; Canada)',
              'Arizona'=>'(GMT-07:00) Arizona',
              'Mountain Time (US &amp; Canada)'=>'(GMT-07:00) Mountain Time (US &amp; Canada)',
              'Central Time (US &amp; Canada)'=>'(GMT-06:00) Central Time (US &amp; Canada)',
              'Eastern Time (US &amp; Canada)'=>'(GMT-05:00) Eastern Time (US &amp; Canada)',
              'Indiana (East)'=>'(GMT-05:00) Indiana (East)',
              'International Date Line West'=>'(GMT-11:00) International Date Line West',
              'Midway Island'=>'(GMT-11:00) Midway Island',
              'Samoa'=>'(GMT-11:00) Samoa',
              'Tijuana'=>'(GMT-08:00) Tijuana',
              'Chihuahua'=>'(GMT-07:00) Chihuahua',
              'Mazatlan'=>'(GMT-07:00) Mazatlan',
              'Central America'=>'(GMT-06:00) Central America',
              'Guadalajara'=>'(GMT-06:00) Guadalajara',
              'Mexico City'=>'(GMT-06:00) Mexico City',
              'Monterrey'=>'(GMT-06:00) Monterrey',
              'Saskatchewan'=>'(GMT-06:00) Saskatchewan',
              'Bogota'=>'(GMT-05:00) Bogota',
              'Lima'=>'(GMT-05:00) Lima',
              'Quito'=>'(GMT-05:00) Quito',
              'Caracas'=>'(GMT-04:30) Caracas',
              'Atlantic Time (Canada)'=>'(GMT-04:00) Atlantic Time (Canada)',
              'La Paz'=>'(GMT-04:00) La Paz',
              'Santiago'=>'(GMT-04:00) Santiago',
              'Newfoundland'=>'(GMT-03:30) Newfoundland',
              'Brasilia'=>'(GMT-03:00) Brasilia',
              'Buenos Aires'=>'(GMT-03:00) Buenos Aires',
              'Georgetown'=>'(GMT-03:00) Georgetown',
              'Greenland'=>'(GMT-03:00) Greenland',
              'Mid-Atlantic'=>'(GMT-02:00) Mid-Atlantic',
              'Azores'=>'(GMT-01:00) Azores',
              'Cape Verde Is.'=>'(GMT-01:00) Cape Verde Is.',
              'Casablanca'=>'(GMT) Casablanca',
              'Dublin'=>'(GMT) Dublin',
              'Edinburgh'=>'(GMT) Edinburgh',
              'Lisbon'=>'(GMT) Lisbon',
              'London'=>'(GMT) London',
              'Monrovia'=>'(GMT) Monrovia',
              'Amsterdam'=>'(GMT+01:00) Amsterdam',
              'Belgrade'=>'(GMT+01:00) Belgrade',
              'Berlin'=>'(GMT+01:00) Berlin',
              'Bern'=>'(GMT+01:00) Bern',
              'Bratislava'=>'(GMT+01:00) Bratislava',
              'Brussels'=>'(GMT+01:00) Brussels',
              'Budapest'=>'(GMT+01:00) Budapest',
              'Copenhagen'=>'(GMT+01:00) Copenhagen',
              'Ljubljana'=>'(GMT+01:00) Ljubljana',
              'Madrid'=>'(GMT+01:00) Madrid',
              'Paris'=>'(GMT+01:00) Paris',
              'Prague'=>'(GMT+01:00) Prague',
              'Rome'=>'(GMT+01:00) Rome',
              'Sarajevo'=>'(GMT+01:00) Sarajevo',
              'Skopje'=>'(GMT+01:00) Skopje',
              'Stockholm'=>'(GMT+01:00) Stockholm',
              'Vienna'=>'(GMT+01:00) Vienna',
              'Warsaw'=>'(GMT+01:00) Warsaw',
              'West Central Africa'=>'(GMT+01:00) West Central Africa',
              'Zagreb'=>'(GMT+01:00) Zagreb',
              'Athens'=>'(GMT+02:00) Athens',
              'Bucharest'=>'(GMT+02:00) Bucharest',
              'Cairo'=>'(GMT+02:00) Cairo',
              'Harare'=>'(GMT+02:00) Harare',
              'Helsinki'=>'(GMT+02:00) Helsinki',
              'Istanbul'=>'(GMT+02:00) Istanbul',
              'Jerusalem'=>'(GMT+02:00) Jerusalem',
              'Kyiv'=>'(GMT+02:00) Kyiv',
              'Pretoria'=>'(GMT+02:00) Pretoria',
              'Riga'=>'(GMT+02:00) Riga',
              'Sofia'=>'(GMT+02:00) Sofia',
              'Tallinn'=>'(GMT+02:00) Tallinn',
              'Vilnius'=>'(GMT+02:00) Vilnius',
              'Baghdad'=>'(GMT+03:00) Baghdad',
              'Kuwait'=>'(GMT+03:00) Kuwait',
              'Minsk'=>'(GMT+03:00) Minsk',
              'Nairobi'=>'(GMT+03:00) Nairobi',
              'Riyadh'=>'(GMT+03:00) Riyadh',
              'Tehran'=>'(GMT+03:30) Tehran',
              'Abu Dhabi'=>'(GMT+04:00) Abu Dhabi',
              'Baku'=>'(GMT+04:00) Baku',
              'Moscow'=>'(GMT+04:00) Moscow',
              'Muscat'=>'(GMT+04:00) Muscat',
              'St. Petersburg'=>'(GMT+04:00) St. Petersburg',
              'Tbilisi'=>'(GMT+04:00) Tbilisi',
              'Volgograd'=>'(GMT+04:00) Volgograd',
              'Yerevan'=>'(GMT+04:00) Yerevan',
              'Kabul'=>'(GMT+04:30) Kabul',
              'Islamabad'=>'(GMT+05:00) Islamabad',
              'Karachi'=>'(GMT+05:00) Karachi',
              'Tashkent'=>'(GMT+05:00) Tashkent',
              'Chennai'=>'(GMT+05:30) Chennai',
              'Kolkata'=>'(GMT+05:30) Kolkata',
              'Mumbai'=>'(GMT+05:30) Mumbai',
              'New Delhi'=>'(GMT+05:30) New Delhi',
              'Kathmandu'=>'(GMT+05:45) Kathmandu',
              'Almaty'=>'(GMT+06:00) Almaty',
              'Astana'=>'(GMT+06:00) Astana',
              'Dhaka'=>'(GMT+06:00) Dhaka',
              'Ekaterinburg'=>'(GMT+06:00) Ekaterinburg',
              'Sri Jayawardenepura'=>'(GMT+06:00) Sri Jayawardenepura',
              'Rangoon'=>'(GMT+06:30) Rangoon',
              'Bangkok'=>'(GMT+07:00) Bangkok',
              'Hanoi'=>'(GMT+07:00) Hanoi',
              'Jakarta'=>'(GMT+07:00) Jakarta',
              'Novosibirsk'=>'(GMT+07:00) Novosibirsk',
              'Beijing'=>'(GMT+08:00) Beijing',
              'Chongqing'=>'(GMT+08:00) Chongqing',
              'Hong Kong'=>'(GMT+08:00) Hong Kong',
              'Krasnoyarsk'=>'(GMT+08:00) Krasnoyarsk',
              'Kuala Lumpur'=>'(GMT+08:00) Kuala Lumpur',
              'Perth'=>'(GMT+08:00) Perth',
              'Singapore'=>'(GMT+08:00) Singapore',
              'Taipei'=>'(GMT+08:00) Taipei',
              'Ulaan Bataar'=>'(GMT+08:00) Ulaan Bataar',
              'Urumqi'=>'(GMT+08:00) Urumqi',
              'Irkutsk'=>'(GMT+09:00) Irkutsk',
              'Osaka'=>'(GMT+09:00) Osaka',
              'Sapporo'=>'(GMT+09:00) Sapporo',
              'Seoul'=>'(GMT+09:00) Seoul',
              'Tokyo'=>'(GMT+09:00) Tokyo',
              'Adelaide'=>'(GMT+09:30) Adelaide',
              'Darwin'=>'(GMT+09:30) Darwin',
              'Brisbane'=>'(GMT+10:00) Brisbane',
              'Canberra'=>'(GMT+10:00) Canberra',
              'Guam'=>'(GMT+10:00) Guam',
              'Hobart'=>'(GMT+10:00) Hobart',
              'Melbourne'=>'(GMT+10:00) Melbourne',
              'Port Moresby'=>'(GMT+10:00) Port Moresby',
              'Sydney'=>'(GMT+10:00) Sydney',
              'Yakutsk'=>'(GMT+10:00) Yakutsk',
              'New Caledonia'=>'(GMT+11:00) New Caledonia',
              'Solomon Is.'=>'(GMT+11:00) Solomon Is.',
              'Vladivostok'=>'(GMT+11:00) Vladivostok',
              'Auckland'=>'(GMT+12:00) Auckland',
              'Fiji'=>'(GMT+12:00) Fiji',
              'Kamchatka'=>'(GMT+12:00) Kamchatka',
              'Magadan'=>'(GMT+12:00) Magadan',
              'Marshall Is.'=>'(GMT+12:00) Marshall Is.',
              'Wellington'=>'(GMT+12:00) Wellington',
              'Nuku\'alofa'=>'(GMT+13:00) Nuku\'alofa');
			  
?>
<!DOCTYPE html>
<html lang="">
    <?php include_once 'header.php'; ?>
    <body onLoad="">
    <style>
	div.field-wrap{
		margin:5px;
		 font-weight:bold;
	}
    div.form-row{
		margin:10px;
		 font-weight:bold;
	}
    </style>
        <?php include_once 'logo.php'; ?>
        <?php include_once 'sideMenu.php'; ?>
        <?php //include_once 'alert.php'; ?>
        <section class="content">
            <div class="widget-container">
                <section class="widget small">
                    <header> 
                        <span class="icon">&#128363;</span>
                        <hgroup>
                            <h1>Profile</h1>
                            <h2>Make sure everything is fine</h2>
                        </hgroup>
                        <!--<aside>
                            <span>
                                <a href="#">&#9881;</a>
                                <ul class="settings-dd">
                                    <li><span style="none"><label style="hidden">Settings</label><input type="checkbox"/></span></li>
                                    <li><label>Public Profile</label><input type="checkbox" id="publicProfile" name="publicProfile" onChange="makePublicProfile(this.checked)"/></li>
                                    <li><label>Public Newslets</label><input type="checkbox" id="publicNewslets" name="publicNewslets" onChange="makePublicNewslets(this.checked)"/></li>
                                </ul>
                            </span>
                        </aside>-->
                    </header>
                    <?php
                    $userManager = new UserManager;
                    $person = $userManager->getUserInfo($_SESSION['userId']);
                    ?><form action="updateUser.php" method="post">
                        <input type="hidden" value="<?php echo $_SESSION['userId'] ?>" name="userId"/>

                        <div class="content no-padding ">
                            <div class="field-wrap">
                                <div class="form-row">Full Name :</div>  <input type="text" name="firstName" value="<?php echo $person['FIRST_NAME'] .' '. $person['LAST_NAME'];?> <?php  ?>">
                            </div>
                            <div class="field-wrap">
                                <div class="form-row">User Name : </div> 
                                <?php
								//print_r($user_info);
								?>
                                <input type="text" name="user_name" value="<?php echo $user_info['USERNAME'];?>" readonly>
                            </div>
                            
                            <div class="field-wrap">
                                <div class="form-row">Email : </div> <input type="text" name="EMAIL"  value="<?php echo $user_info['EMAIL'];?>">
                            </div>
                            <!--<div class="field-wrap">
                                <div class="form-row">Mobile : </div> <input type="text" name="mobile"  value="<?php echo $person['MOBILE'] ?>">
                            </div>-->
                            <!--<div class="field-wrap">
                                <div class="form-row">Address : </div> <input type="text" name="address" value="<?php echo $person['ADDRESS'] ?>">
                            </div>-->
                            <div class="field-wrap">
                                <div class="form-row">City : </div> <input type="text" name="CITY" value="<?php echo $person['CITY'] ?>">
                            </div>
                            <div class="field-wrap">
                                <div class="form-row">State : </div> <input type="text" name="STATE" value="<?php echo $person['STATE'] ?>">
                            </div>
                            
                            <div class="field-wrap">
                                <div class="form-row">Country : </div> 
                                <?php //echo $person['COUNTRY']; ?>
                                <select name="COUNTRY" id="COUNTRY">
                               
                                
								<?php
								$rec = mysql_query("select * from country");
								while($row = mysql_fetch_array($rec)){
									?>
                                     <option value="<?php echo $row['name'];?>" <?php if($row['name'] == $person['COUNTRY']){?> selected <?php } ?>><?php echo $row['name'];?></option>
                                    <?php
								}
								?>
                                </select>
                                <!--<input type="text" name="COUNTRY" value="<?php echo $person['COUNTRY'] ?>">-->
                            </div>
                            
                           
                            <div class="field-wrap">
                                <div class="form-row">Time Zone : </div>  
                                <select name="TIME_ZONE" id="TIME_ZONE">
						<?php
						foreach($time_jone as $key=>$val){
						?>
                        <option value="<?php echo $key;?>" <?php if($key == $person['TIME_ZONE']){?> selected <?php } ?> ><?php echo $val;?></option>
                        <?php
						}
						?>
						</select>
                            </div>
                            <!--<div class="field-wrap">
                                <div class="form-row">Address : </div> <input type="text" name="state" value="<?php echo $person['STATE'] ?>">
                            </div>-->
                            <div class="field-wrap">
                                <div class="form-row">Date of Birth : </div> <input type="text" id="dateOfBirth" name="dateOfBirth" value="<?php echo $person['DATE_OF_BIRTH'] ?>">
                            </div>
                            <!--<div class="field-wrap">
                                <div class="form-row">Anniversary Date : </div> <input type="text" id="anniversaryDate" name="anniversaryDate" value="<?php echo $person['ANNIVERSARY_DATE'] ?>">
                            </div>-->
                            <div class="field-wrap">
                                <div class="form-row">Account Type : </div> 
                                <div style="width:100%;">
                                <div style="float:left; margin:5px;">
                                <?php
								//echo $person['PUBLIC_PROFILE'];
								?>
                                <input type="radio" id="public_profile_Y" name="public_profile" <?php if($person['PUBLIC_PROFILE']=='Y'){?> checked <?php }?> value="Y" style="width:5px;"></div> <div style="float:left; margin:5px;">Public Profile <br>
                                <small style="font-size:10px;">Anyone can subscribe <br>to you without asking</small></div>
                                <div style="float:left; margin:5px;"><input type="radio" id="public_profile_N" name="public_profile" <?php if($person['PUBLIC_PROFILE']=='N'){?> checked <?php }?> value="N" style="width:5px;"></div> <div style="float:left; margin:5px;">Private Profile <br>
                                <small style="font-size:10px;">User must take your permission<br> before subscription</small></div>
                                </div>
                            </div>
							<div class="field-wrap" style="width:98%; float:left;">
                            <br>
                            <div style="margin:5px;">
                            <small><a href="changepassword.php">Change Password</a></small>
                            </div>
                            <br>
                            <input type="submit" style="color:#FFF; font-weight:bold;" class="blue" value="SAVE"/>
							</div>
                    </form>
            </div>
        </section>
        <section class="widget small">
            <header> 
                <span class="icon">&#128363;</span>
                <hgroup>
                    <h1>Image</h1>
                    <h2>See how other see you !!</h2>
                </hgroup>
            </header>
            <div class="content no-padding ">
                <form action="upload_file.php" method="post" enctype="multipart/form-data">
                    <div class="field-wrap">
                        <div class="form-row">
	                        <label for="file">Small Image:</label>
                        </div>
	                    <img src="upload/<?php echo $_SESSION['userId']; ?>_S.png" alt=""/>
                    </div>
					<div class="field-wrap">
                        <div class="form-row">
                    <label for="file">Medium Image:</label>
                   		</div>
                    <img src="upload/<?php echo $_SESSION['userId']; ?>_M.png" alt=""/>
                    </div>
                    <div class="field-wrap">
                        <div class="form-row">
	                    <label for="file">File name:</label>
                    	</div>
                    <input type="file" name="file" id="file">
                    </div>
                    <div class="field-wrap">
                    <input type="hidden" id="userId" name="userId" value='<?php echo $_SESSION['userId']; ?>'/>
                    <input type="submit" class="blue" style="color:#FFF; font-weight:bold;" name="submit" value="Submit">
                    </div>
                </form>
            </div>
        </section>
    </div>
</section>
<link rel="stylesheet" href="css/jquery-ui.css" media="all" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
<script src="js/jquery.wysiwyg.js"></script>
<script src="js/custom.js"></script>
<script src="js/cycle.js"></script>
<script src="js/jquery.checkbox.min.js"></script>
<!--<script src="js/flot.js"></script>
<script src="js/flot.resize.js"></script>
<script src="js/flot-graphs.js"></script>
<script src="js/flot-time.js"></script>
<script src="js/cycle.js"></script>-->
<script src="js/jquery.tablesorter.min.js"></script>
<script src="js/jquery-ui.js"></script>
<script type="text/javascript">

                                        function makePublicProfile(status) {
                                            msg = 'N';
                                            if (status) {
                                                msg = 'Y';
                                            }
                                            $.post("profileSetting.php", {userId: '<?php echo $_SESSION['userId'] ?>', status: msg},
                                            function(data) {
                                            });
                                        }

                                        function makePublicNewslets(status) {
                                            msg = 'N';
                                            if (status) {
                                                msg = 'Y';
                                            }
                                            $.post("NewsletSetting.php", {userId: '<?php echo $_SESSION['userId'] ?>', status: msg},
                                            function(data) {
                                            });
                                        }
                                        $(function() {
                                            $("#dateOfBirth").datepicker({
                                                yearRange: "1900:2013",
                                                changeMonth: true,
                                                changeYear: true
                                            });
                                            $("#anniversaryDate").datepicker({
                                                yearRange: "1900:2013",
                                                changeMonth: true,
                                                changeYear: true
                                            });
                                        });
</script>
</body>
</html>
