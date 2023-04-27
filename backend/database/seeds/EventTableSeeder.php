<?php

use App\Models\Service;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EventTableSeeder extends Seeder
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

        $services = App\Models\Service::all();
        $serviceIdsAll = [];
        foreach ($services as $service) {
            $serviceIdsAll[] = $service->id;
        }

        $number = env('NUMBER_OF_SAMPLE_EVENTS_TO_SEED');
        for($i = 0; $i < $number; $i++) {

            $userId = $users[random_int(0, count($users) - 1)]['id'];
            $company = App\Models\Company::where('user_id', $userId)->first();
            if($company == null) continue;
            $companyId = $company->listing_id;

            $title = $faker->jobTitle;

            $serviceIds = $faker->randomElements($serviceIdsAll, 5);

            $event = [
                'logo_img' => $faker->imageUrl(300,100),
                'cover_img' => $faker->imageUrl(1900,600),
                'full_description' => $faker->paragraph(6),
                'contact_email' => $faker->companyEmail,
                'region' => json_encode($faker->randomElement(
                    $regionIds
                )),
                'title' => $title,
                'tagLine' => $faker->word,
                'set_of_images' => json_encode([
                    $faker->imageUrl(900,600),
                    $faker->imageUrl(900,600),
                    $faker->imageUrl(900,600)
                ]),
                'map_latitude' => $faker->latitude,
                'map_longitude' => $faker->longitude,
                'contact_phone' => $faker->phoneNumber,
                'video_url' => $faker->url,
                'event_link' => $faker->url,
                'address' => $faker->address,
                'date_and_time' => $faker->dateTime,
                'created_at' => $faker->date('Y-m-d'),
                'company_id' => $companyId,
                'user_id' => $userId
            ];

            $eventORM = new \App\Models\Event($event);
            $eventORM->save();

            foreach ($serviceIds as $serviceId) {
                DB::table('listings_services')->insert([
                    'service_id' => $serviceId,
                    'listing_id' => $eventORM->listing_id,
                    'type' => 'event'
                ]);
            }

            DB::table('listings')->insert([
                'listing_id' => $eventORM->listing_id,
                'slug' => $eventORM->slug,
                'listing_type' => 'event',
                'status' => 'published',
                'user_id' => $userId
            ]);

        }
    }
}
