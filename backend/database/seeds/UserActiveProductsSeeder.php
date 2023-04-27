<?php

use App\Models\User;
use App\Models\Product;
use App\Models\Company;
use App\Models\ProductType;
use Illuminate\Database\Seeder;

class UserActiveProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();

        $mainProducts = array(
            Product::where('slug', 'free')->value('id'),
            Product::where('slug', 'start')->value('id'),
            Product::where('slug', 'pro')->value('id'),
            Product::where('slug', 'expert')->value('id'),
            Product::where('slug', 'power')->value('id')
        );

        $startProExpert = array(
            Product::where('slug', 'start')->value('id'),
            Product::where('slug', 'pro')->value('id'),
            Product::where('slug', 'expert')->value('id')
        );

        $startPro = array(
            Product::where('slug', 'start')->value('id'),
            Product::where('slug', 'pro')->value('id'),
        );

        $freeId = Product::where('slug', 'free')->value('id');
        $startId = Product::where('slug', 'start')->value('id');
        $proId = Product::where('slug', 'pro')->value('id');

        foreach ($users as $user) {
            if ($user->manages_companies) {
                $userCompanyIds = Company::where('user_id', $user->id)->pluck('listing_id')->toArray();

                foreach ($userCompanyIds as $userCompanyId) {

                    if (random_int(0, 4) == 1) {
                        // FREE company and subscription
                        Company::where('listing_id', $userCompanyId)->where('user_id', $user->id)->is_premium_listing = 0;

                        DB::table('user_active_products')->insert([
                            'user_id' => $user->id,
                            'product_id' => $freeId, // FREE
                            'company_id' => $userCompanyId
                        ]);
                    } else {

                        $hasProduct = false;

                        if ($user->id == 2) { // Jane Doe
                            $hasProduct = true;
                            $productToAssign = $startId; // START
                        } else if ($user->id == 3) { // Rudolphe
                            $hasProduct = true;
                            $productToAssign = $startProExpert[array_rand($startProExpert)]; // START or PRO or EXPERT
                        } else if ($user->id == 4) { // Anton
                            $hasProduct = true;
                            $productToAssign = $startPro[array_rand($startPro)]; // START or PRO
                        } else if ($user->id == 7) { // One Company Guy
                            $hasProduct = true;
                            $productToAssign = $proId; // PRO
                        }

                        if ($hasProduct)
                            DB::table('user_active_products')->insert([
                                'user_id' => $user->id,
                                'product_id' => $productToAssign,
                                'company_id' => $userCompanyId
                            ]);
                    }
                }
            }
        }

        /************************************************************************/



        // foreach ($users as $user)
        //     if ($user->manages_companies == true) {

        //       DB::table('user_active_products')->insert([
        //            'user_id' => $user->id,
        //            'product_id' => array_rand($mainIds) + 1
        //        ]);

        /* if (random_int(0, 2))
                    DB::table('user_active_products')->insert([
                        'user_id' => $user->id,
                        'product_id' => 3 // Visibility addon subscription
                    ]); */
        //    }
    }
}
