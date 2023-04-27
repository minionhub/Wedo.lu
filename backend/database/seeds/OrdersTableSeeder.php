<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

//        $firstRegionId = App\Models\Region::all()->first()->region_id;
//        $lastRegionId = App\Models\Region::all()->last()->region_id;

//        for ($i = $firstRegionId; $i <= $lastRegionId; $i++) {
//            $regionIds[$i] = $i;
//        }
        $countries =App\Models\Country::all()->toArray();

        $users = App\Models\User::all()->toArray();

        $products = App\Models\Product::all()->toArray();

        $paymentMethods = App\Models\PaymentMethod::all()->toArray();

        if($users && $products) {

            for($i = 0; $i <= 100; $i++) {

                $user = $users[random_int(1, 3)];
                $companies = App\Models\Company::where('user_id', $user['id'])->get()->toArray();
                $product = $products[random_int(0, count($products) - 1)];
                $paymentMethod = $paymentMethods[random_int(0, count($paymentMethods) - 1)];

                $companyId = count($companies) > 0 ?
                    $companies[random_int(0, count($companies) - 1)]['listing_id'] :
                    null;

                $isPrimaryExist = App\Models\Address::where('company_id', $companyId)
                    ->where('is_primary', true)->count() > 0;

                $address = [
                    'country_id' => $faker->randomElement($countries)['id'],
                    'first_name' => $faker->firstName,
                    'last_name' => $faker->lastName,
                    'street_name' => $faker->streetName,
                    'house_number' => $faker->randomNumber(3),
                    'city' => $faker->city,
                    'zip' => $faker->randomNumber(6),
                    'phone' => $faker->phoneNumber,
                    'email' => $faker->email,
                    'is_primary' => $isPrimaryExist ? false : true,
                    'user_id' => $user['id'],
                    'company_id' => $companyId
                ];
                $addressId = DB::table('addresses')->insertGetId($address);

                $count = random_int(1, 5);
                $subtotal = $count * $product['price'];
                $tax = 0.17 * $subtotal;
                $total = $tax + $subtotal;

                $order = [
                    'code' => $faker->randomNumber(5),
                    'user_id' => $user['id'],
                    'product_id' => $product['id'],
                    'count' => $count,
                    'total' => $total,
                    'subtotal' => $subtotal,
                    'tax' => $tax,
                    'first_renew' => date('Y-m-d'),
                    'last_renew' => date('Y-m-d'),
                    'expire' => date('Y-m-d'),
                    'payment_method_id' => $paymentMethod['id'],
                    'address_id' => $addressId,
                    'status' => $faker->randomElement(['pending', 'processing', 'failed']),
                ];

                DB::table('orders')->insert($order);

            }

        }
    }
}
