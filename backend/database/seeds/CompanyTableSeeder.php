<?php

use App\Models\User;
use App\Models\Company;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanyTableSeeder extends Seeder
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

        $categoriesAll = App\Models\Category::limit(10)->get();

        $timezones = App\Models\Timezone::all();

        $services = App\Models\Service::all();
        $serviceIdsAll = [];
        foreach ($services as $service) {
            $serviceIdsAll[] = $service->id;
        }

        $number = env('NUMBER_OF_SAMPLE_COMPANIES_TO_SEED');
        for ($i = 0; $i < $number; $i++) {

            $companyName = $faker->company;
            //            $slug = $i == 0 ? 'first-company-slug' : str_slug($companyName, '-');

            if ($i == 99)
                $userId = 7; // One Company Guy
            else
                $userId = $users[random_int(1, 3)]['id'];

            $openingHours = [
                ['type' => 0, 'intervals' => [['9:00', '12:00'], ['13:00', '16:00']]],
                ['type' => 1, 'intervals' => []],
                ['type' => 0, 'intervals' => [['9:00', '12:00'], ['13:00', '16:00']]],
                ['type' => 2, 'intervals' => []],
                ['type' => 0, 'intervals' => [['9:00', '12:00'], ['13:00', '16:00']]],
                ['type' => 3, 'intervals' => []],
                ['type' => 0, 'intervals' => [['9:00', '12:00'], ['13:00', '16:00']]]
            ];

            $serviceIds = $faker->randomElements($serviceIdsAll, 5);

            $lat = $faker->latitude;
            $lon = $faker->longitude;

            $location = (string)$lat.','.(string)$lon;

            $company = [
                'logo_img' => $faker->imageUrl(300, 100),
                'cover_img' => $faker->imageUrl(1900, 600),
                'full_description' => $faker->paragraph(6),
                'contact_email' => $faker->companyEmail,
                'region' => json_encode($faker->randomElements(
                    $regionIds,
                    5
                )),
                'company_name' => $companyName,
                'short_desc' => $faker->sentence,
                'street' => $faker->streetAddress,
                'houseNbr' => $faker->buildingNumber,
                'zip_code' => $faker->randomNumber(5),
                'city' => $faker->city,
                'map_longitude' => $lon,
                'map_latitude' => $lat,
                'location' => $location,
                'set_of_images' => json_encode([
                    $faker->imageUrl(900, 600),
                    $faker->imageUrl(900, 600),
                    $faker->imageUrl(900, 600)
                ]),
                'phone' => $faker->phoneNumber,
                'website_url' => $faker->url,
                'fax' => $faker->phoneNumber,
                'e_commerce' => $faker->word,
                'social_networks' => json_encode([
                    ['type' => 'Facebook', 'link' => $faker->url],
                    ['type' => 'Facebook', 'link' => $faker->url]
                ]),
                'timezone_id' => $faker->randomElement($timezones)->id,
                'codeNace' => $faker->word,
                'commercialRegisterCode' => $faker->word,
                'internationalTVAnbr' => $faker->word,
                'nationalTVAnbr' => $faker->word,
                'shareCapital' => $faker->randomNumber(5),
                'employeeNbr' => $faker->randomNumber(3),
                'foundationDate' => $faker->date(),
                'brands' => '["AEG", "BOSCH", "CONSTRUCTA", "JURA", "LIEBHERR", "MIELE", "NEFF", "SIEMENS"]',
                'opening_hours' => json_encode([
                    'Monday' => $faker->randomElement($openingHours),
                    'Tuesday' => $faker->randomElement($openingHours),
                    'Wednesday' => $faker->randomElement($openingHours),
                    'Thursday' => $faker->randomElement($openingHours),
                    'Friday' => $faker->randomElement($openingHours),
                    'Saturday' => $faker->randomElement($openingHours),
                    'Sunday' => $faker->randomElement($openingHours)
                ]),
                'accepted_payment_methods' => '["Virement bancaire","Carte de credit"]',
                'spoken_languages' => json_encode($faker->words(5)),
                'certifications' => json_encode($faker->words(5)),
                'facilities' => json_encode($faker->words(5)),
                'is_premium_listing' => $i == 0 ? false : true,
                'created_at' => $faker->date('Y-m-d'),
                'user_id' => $i == 0 ? null : $userId
            ];

            $user = User::find($userId);
            $user->manages_companies = true;
            $user->save();

            $companyORM = new \App\Models\Company($company);

            $companyORM->saveOrFail();
            $listing_id = $companyORM->listing_id;

            $categories = $faker->randomElements($categoriesAll, 3);
            foreach ($categories as $category) {
                $companyORM->categories()->attach($category->id);
            }

            foreach ($serviceIds as $serviceId) {
                DB::table('listings_services')->insert([
                    'service_id' => $serviceId,
                    'listing_id' => $listing_id,
                    'type' => 'company'
                ]);
            }

            for ($j = 0; $j < 3; $j++) {
                DB::table('contact_people')->insert([
                    'name' => $faker->name,
                    'position' => $faker->randomElement(['Gérant', 'Gérant administratif', 'Directeur']),
                    'phone' => $faker->phoneNumber,
                    'company_id' => $listing_id
                ]);
            }

            DB::table('listings')->insert([
                'listing_id' => $listing_id,
                'slug' => $companyORM->slug,
                'listing_type' => 'company',
                'status' => 'published',
                'user_id' => $userId
            ]);
        }

        Company::createIndex($shards = null, $replicas = null);
        Company::putMapping($ignoreConflicts = true);
        Company::addAllToIndex();
    }
}
