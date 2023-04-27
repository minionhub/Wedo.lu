<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentMethodsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('payment_methods')->insert([
            'name' => 'Bank Transfer',
            'details' => json_encode([
                'bank' => 'BGL BNP Paribas S.A.',
                'sort_code' => 'BGL',
                'iban' => 'LU050030469353040000',
                'bic' => 'BGLLLULL'
            ])
        ]);

        DB::table('payment_methods')->insert([
            'name' => 'Credit card'
        ]);
    }
}
