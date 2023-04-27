<?php

use App\Models\JobOffer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JobOfferTableSeeder extends Seeder
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

        $categories = App\Models\Category::all()->toArray();

        $firstRegionId = App\Models\Region::all()->first()->region_id;
        $lastRegionId = App\Models\Region::all()->last()->region_id;

        for ($i = $firstRegionId; $i <= $lastRegionId; $i++) {
            $regionIds[$i] = $i;
        }

        $number = env('NUMBER_OF_SAMPLE_JOBOFFERS_TO_SEED');
        for($i = 0; $i < $number; $i++) {

            $userId = $users[random_int(1, 3)]['id'];
            $company = App\Models\Company::where('user_id', $userId)->first();
            if($company == null) continue;
            $companyId = $company->listing_id;

            $categoryId = $categories[random_int(0, count($categories) - 1)]['id'];

            $jobTitle = $faker->jobTitle;

            $job = [
                'logo_img' => $faker->imageUrl(300,100),
                'cover_img' => $faker->imageUrl(1900,600),
                'full_description' => $faker->paragraph(6),
                'contact_email' => $faker->companyEmail,
                'region' => json_encode($faker->randomElements(
                    $regionIds,
                    5
                )),
                'job_title' => $jobTitle,
                'contract_type' => $faker->randomElement(['CDI', 'CDD', 'Internship']),
                'pdf' => $faker->url,
                'payment' => $faker->word,
                'phone' => $faker->phoneNumber,
                'website_url' => $faker->url,
                'map_longitude' => $faker->longitude,
                'map_latitude' => $faker->latitude,
                'company_name' => $faker->company,
                'company_social_security_number' => $faker->randomNumber(7),
                'contact_person' => $faker->name,
                'level_of_luxembourgish' => $faker->randomElement(['NotRequired', 'A1', 'A2', 'B1', 'B2', 'C1', 'C2', 'C3']),
                'level_of_german' => $faker->randomElement(['NotRequired', 'A1', 'A2', 'B1', 'B2', 'C1', 'C2', 'C3']),
                'level_of_french' => $faker->randomElement(['NotRequired', 'A1', 'A2', 'B1', 'B2', 'C1', 'C2', 'C3']),
                'level_of_english' => $faker->randomElement(['NotRequired', 'A1', 'A2', 'B1', 'B2', 'C1', 'C2', 'C3']),
                'created_at' => $faker->date('Y-m-d'),
                'category_id' => $categoryId,
                'company_id' => $companyId,
                'user_id' => $userId
            ];

            $jobOffer = new \App\Models\JobOffer($job);
            $jobOffer->save();

            DB::table('listings')->insert([
                'listing_id' => $jobOffer->listing_id,
                'slug' => $jobOffer->slug,
                'listing_type' => 'job_offer',
                'status' => 'published',
                'user_id' => $userId
            ]);

        }

        JobOffer::createIndex($shards = null, $replicas = null);
        JobOffer::putMapping($ignoreConflicts = true);
        JobOffer::addAllToIndex();
    }
}
