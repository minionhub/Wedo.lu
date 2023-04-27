<?php

use App\Enums\Role;
use App\Models\Language;
use App\Enums\ProjectStatus;
use App\Models\User;
use App\Models\Region;
use App\Models\Project;
use App\Models\ProjectSubCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\ProjectStartTime;

class ProjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws Exception
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $users = User::all()->toArray();
        $subcategories = ProjectSubCategory::all()->toArray();

        $firstLanguageKey = Language::all()->first()->key;
        $lastLanguageKey = Language::all()->last()->key;

        $firstRegionId = Region::all()->first()->region_id;
        $lastRegionId = Region::all()->last()->region_id;

        $projectStartTimes = ProjectStartTime::all()->pluck('key')->toArray();

        for ($i = $firstRegionId; $i <= $lastRegionId; $i++) {
            $regionIds[$i] = $i;
        }

        $attachedFiles = null;
        $numberOfAttachments = 0; // random_int(0, 10);

        if ($numberOfAttachments > 0) {
            $attachedFiles = '{"attached_files" : [';
            for ($i = 1; $i <= $numberOfAttachments; $i++) {
                $attachedFiles .= '"/files/';
                $attachedFiles .= $faker->word;
                $attachedFiles .= implode($faker->randomElements(array(".txt", ".jpg", ".png", ".pdf", ".docx", ".odt", ".zip"), 1));

                if ($i !== $numberOfAttachments) {
                    $attachedFiles .= '",';
                } else
                    $attachedFiles .= '"]}';
            }
        }

        $projectTitle = 'Project added by a private user';

        $project = new Project;

        $project->title = $projectTitle;
        $project->website_language = $faker->randomElement(array('fr', 'de', 'en'));
        $project->publish_date = $faker->date();
        $project->status = json_encode($faker->randomElement(array(ProjectStatus::draft, ProjectStatus::published, ProjectStatus::archived)));
        $project->description = $faker->sentence;
        $project->attached_files = $attachedFiles; // '{"attached_files" : ["/files/' . $faker->word . '.jpg", "/files/' . $faker->word . '.pdf"]}'; // json_encode('{"attached_files" : [/files/' . $faker->word . '.png, "/files/' . $faker->word . '.pdf"]}');
        $project->author_name = $faker->name;
        $project->author_email = 'me@momo.lu';
        $project->author_phone = $faker->e164PhoneNumber;
        $project->author_prefers_to_be_contacted_in = Language::where('key', random_int($firstLanguageKey, $lastLanguageKey))->value('code');
        $project->project_address = $faker->address;
        $project->region = json_encode($faker->randomElements(
            $regionIds,
            5
        ));
        $project->start_time = $projectStartTimes[array_rand($projectStartTimes)];
        $project->number_of_offers = $faker->numberBetween(0, 1000);
        $project->author_id = 5;

        $project->save();

        DB::table('projects_project_subcategories')->insert(
            array(
                'subcategory_id' => 1,
                'project_id' => 1,
            )
        );

        $number = env('NUMBER_OF_SAMPLE_PROJECTS_TO_SEED');
        for ($i = 2; $i < $number; $i++) {

            if (random_int(0, 2)) {
                $random_user = User::find($users[random_int(0, count($users) - 3)]['id']);
                $random_name = $random_user->display_name;
                $random_email = $random_user->email;
                $author_id = $random_user->id;
            } else {
                $new_random_user = new User;
                $new_random_user->first_name = $faker->firstName;
                $new_random_user->last_name = $faker->lastName;
                $new_random_user->nickname = $faker->word;
                $new_random_user->display_name = $faker->name;
                $new_random_user->email = $faker->email;
                $new_random_user->email_project_notifications = null;
                $new_random_user->password = Hash::make('123');
                $new_random_user->role = Role::Regular;

                $new_random_user->save();

                $random_name = $new_random_user->display_name;
                $random_email = $new_random_user->email;
                $author_id = $new_random_user->id;
            }

            $attachedFiles = null;
            $numberOfAttachments = random_int(0, 10);

            if ($numberOfAttachments > 0) {
                $attachedFiles = '{"attached_files" : [';
                for ($j = 1; $j <= $numberOfAttachments; $j++) {
                    $attachedFiles .= '"/files/';
                    $attachedFiles .= $faker->word;
                    $attachedFiles .= implode($faker->randomElements(array(".txt", ".jpg", ".png", ".pdf", ".docx", ".odt", ".zip"), 1));

                    if ($j !== $numberOfAttachments) {
                        $attachedFiles .= '",';
                    } else
                        $attachedFiles .= '"]}';
                }
            }

            $project = new Project;

            $project->title = $faker->jobTitle;
            $project->website_language = $faker->randomElement(array('fr', 'de', 'en'));
            $project->publish_date = $faker->date();
            $project->status = json_encode($faker->randomElement(array(ProjectStatus::draft, ProjectStatus::published, ProjectStatus::archived)));
            $project->description = $faker->sentence;
            $project->attached_files = $attachedFiles;
            $project->author_name = $random_name;
            $project->author_email = $random_email;
            $project->author_phone = $faker->e164PhoneNumber;
            $project->author_prefers_to_be_contacted_in = Language::where('key', random_int($firstLanguageKey, $lastLanguageKey))->value('code');
            $project->project_address = $faker->address;
            $project->region = json_encode($faker->randomElements(
                $regionIds,
                random_int(1, 5)
            ));
            $project->start_time = $projectStartTimes[array_rand($projectStartTimes)];
            $project->number_of_offers = $faker->numberBetween(0, 1000);
            $project->author_id = $author_id;

            $project->save();

            DB::table('projects_project_subcategories')->insert(
                array(
                    'subcategory_id' => $subcategories[random_int(0, count($subcategories) - 1)]['subcategory_id'],
                    'project_id' => $i,
                )
            );
        }

        Project::createIndex($shards = null, $replicas = null);
        Project::putMapping($ignoreConflicts = true);
        Project::addAllToIndex();
    }
}
