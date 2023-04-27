<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TimezonesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $timezones = [
            [ 'name' => 'Europe/Kirov', 'code' => '' ],
            [ 'name' => 'Europe/Lisbon', 'code' => '' ],
            [ 'name' => 'Europe/Ljubljana', 'code' => '' ],
            [ 'name' => 'Europe/London', 'code' => '' ],
            [ 'name' => 'Europe/Luxembourg', 'code' => '' ],
            [ 'name' => 'Europe/Madrid', 'code' => '' ],
            [ 'name' => 'Europe/Malta', 'code' => '' ],
            [ 'name' => 'Europe/Mariehamn', 'code' => '' ],
            [ 'name' => 'Europe/Minsk', 'code' => '' ],
            [ 'name' => 'Europe/Monaco', 'code' => '' ],
            [ 'name' => 'Europe/Moscow', 'code' => '' ],
            [ 'name' => 'Europe/Oslo', 'code' => '' ],
            [ 'name' => 'Europe/Paris', 'code' => '' ],
            [ 'name' => 'Europe/Podgorica', 'code' => '' ],
            [ 'name' => 'Europe/Prague', 'code' => '' ],
            [ 'name' => 'Europe/Riga', 'code' => '' ],
            [ 'name' => 'Europe/Rome', 'code' => '' ],
            [ 'name' => 'Europe/Samara', 'code' => '' ],
            [ 'name' => 'Europe/San_Marino', 'code' => '' ],
            [ 'name' => 'Europe/Sarajevo', 'code' => '' ],
            [ 'name' => 'Europe/Saratov', 'code' => '' ],
            [ 'name' => 'Europe/Simferopol', 'code' => '' ],
            [ 'name' => 'Europe/Skopje', 'code' => '' ],
            [ 'name' => 'Europe/Sofia', 'code' => '' ],
            [ 'name' => 'Europe/Stockholm', 'code' => '' ],
            [ 'name' => 'Europe/Tallinn', 'code' => '' ],
            [ 'name' => 'Europe/Ulyanovsk', 'code' => '' ],
            [ 'name' => 'Europe/Tirane', 'code' => '' ],
            [ 'name' => 'Europe/Uzhgorod', 'code' => '' ],
            [ 'name' => 'Europe/Vaduz', 'code' => '' ],
            [ 'name' => 'Europe/Vatican', 'code' => '' ],
            [ 'name' => 'Europe/Vienna', 'code' => '' ],
            [ 'name' => 'Europe/Vilnius', 'code' => '' ],
            [ 'name' => 'Europe/Volgograd', 'code' => '' ],
            [ 'name' => 'Europe/Warsaw', 'code' => '' ],
            [ 'name' => 'Europe/Zagreb', 'code' => '' ],
            [ 'name' => 'Europe/Zaporozhye', 'code' => '' ],
            [ 'name' => 'Europe/Zurich', 'code' => '' ],
            [ 'name' => 'Indian/Antananarivo', 'code' => '' ],
            [ 'name' => 'Indian/Chagos', 'code' => '' ],
            [ 'name' => 'Indian/Christmas', 'code' => '' ],
            [ 'name' => 'Indian/Cocos', 'code' => '' ],
            [ 'name' => 'Indian/Comoro', 'code' => '' ],
            [ 'name' => 'Indian/Kerguelen', 'code' => '' ],
            [ 'name' => 'Indian/Mahe', 'code' => '' ],
            [ 'name' => 'Indian/Maldives', 'code' => '' ],
            [ 'name' => 'Indian/Mauritius', 'code' => '' ],
            [ 'name' => 'Indian/Mayotte', 'code' => '' ],
            [ 'name' => 'Indian/Reunion', 'code' => '' ],
            [ 'name' => 'Pacific/Apia', 'code' => '' ],
            [ 'name' => 'Pacific/Auckland', 'code' => '' ],
            [ 'name' => 'Pacific/Bougainville', 'code' => '' ],
            [ 'name' => 'Pacific/Chatham', 'code' => '' ],
            [ 'name' => 'Pacific/Chuuk', 'code' => '' ],
            [ 'name' => 'Pacific/Easter', 'code' => '' ],
            [ 'name' => 'Pacific/Efate', 'code' => '' ],
            [ 'name' => 'Pacific/Enderbury', 'code' => '' ],
            [ 'name' => 'Pacific/Fakaofo', 'code' => '' ],
            [ 'name' => 'Pacific/Fiji', 'code' => '' ],
            [ 'name' => 'Pacific/Funafuti', 'code' => '' ],
            [ 'name' => 'Pacific/Galapagos', 'code' => '' ],
            [ 'name' => 'Pacific/Gambier', 'code' => '' ],
            [ 'name' => 'Pacific/Guadalcanal', 'code' => '' ],
            [ 'name' => 'Pacific/Guam', 'code' => '' ],
            [ 'name' => 'Pacific/Honolulu', 'code' => '' ],
            [ 'name' => 'Pacific/Kiritimati', 'code' => '' ],
            [ 'name' => 'Pacific/Kosrae', 'code' => '' ],
            [ 'name' => 'Pacific/Kwajalein', 'code' => '' ],
            [ 'name' => 'Pacific/Majuro', 'code' => '' ],
            [ 'name' => 'Pacific/Marquesas', 'code' => '' ],
            [ 'name' => 'Pacific/Midway', 'code' => '' ],
            [ 'name' => 'Pacific/Nauru', 'code' => '' ],
            [ 'name' => 'Pacific/Niue', 'code' => '' ],
            [ 'name' => 'Pacific/Norfolk', 'code' => '' ],
            [ 'name' => 'Pacific/Noumea', 'code' => '' ],
            [ 'name' => 'Pacific/Pago_Pago', 'code' => '' ],
            [ 'name' => 'Pacific/Palau', 'code' => '' ],
            [ 'name' => 'Pacific/Pitcairn', 'code' => '' ],
            [ 'name' => 'Pacific/Pohnpei', 'code' => '' ],
            [ 'name' => 'Pacific/Port_Moresby', 'code' => '' ],
            [ 'name' => 'Pacific/Rarotonga', 'code' => '' ],
            [ 'name' => 'Pacific/Saipan', 'code' => '' ],
            [ 'name' => 'Pacific/Tahiti', 'code' => '' ],
            [ 'name' => 'Pacific/Tarawa', 'code' => '' ],
            [ 'name' => 'Pacific/Tongatapu', 'code' => '' ],
            [ 'name' => 'Pacific/Wake', 'code' => '' ],
            [ 'name' => 'Pacific/Wallis', 'code' => '' ],
            [ 'name' => 'UTC', 'code' => '' ]
        ];

        foreach ($timezones as $timezone) {
            DB::table('timezones')->insert([
                'name' => $timezone['name']
            ]);
        }
    }
}
