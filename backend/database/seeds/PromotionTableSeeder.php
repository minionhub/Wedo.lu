<?php

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PromotionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        $users = App\Models\User::all()->toArray();

        $firstRegionId = App\Models\Region::all()->first()->region_id;
        $lastRegionId = App\Models\Region::all()->last()->region_id;

        for ($i = $firstRegionId; $i <= $lastRegionId; $i++) {
            $regionIds[$i] = $i;
        }

        $number = env('NUMBER_OF_SAMPLE_PROMOTIONS_TO_SEED');
        for($i = 0; $i < $number; $i++) {

            $userId = $users[random_int(0, count($users) - 1)]['id'];
            $company = App\Models\Company::where('user_id', $userId)->first();
            if($company == null) continue;
            $companyId = $company->listing_id;

            $title = $faker->jobTitle;

            $promotion = [
                'logo_img' => $faker->imageUrl(300,100),
                'cover_img' => $faker->imageUrl(1900,600),
                'full_description' => $faker->paragraph(6),
                'contact_email' => $faker->companyEmail,
                'region' => json_encode($faker->randomElement(
                    $regionIds
                )),
                'title' => $title,
                'short_description' => $faker->sentence,
                'set_of_images' => json_encode([
                    $faker->imageUrl(900,600),
                    $faker->imageUrl(900,600),
                    $faker->imageUrl(900,600)
                ]),
                'price' => $faker->randomFloat(1),
                'video_url' => $faker->url,
                'url' => $faker->url,
                'created_at' => $faker->date('Y-m-d'),
                'company_id' => $companyId,
                'user_id' => $userId
            ];

            $promotionORM = new \App\Models\Promotion($promotion);
            $promotionORM->save();

            DB::table('listings')->insert([
                'listing_id' => $promotionORM->listing_id,
                'slug' => $promotionORM->slug,
                'listing_type' => 'promotion',
                'status' => 'published',
                'user_id' => $userId
            ]);

        }
    }
}
