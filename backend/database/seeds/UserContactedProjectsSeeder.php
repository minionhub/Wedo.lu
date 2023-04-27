<?php

use App\Models\User;
use App\Models\Project;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserContactedProjectsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $firstUser = User::all()->first()->id;
        $lastUser = User::all()->last()->id;

        $firstProject = Project::all()->first()->project_id;
        $lastProject = Project::all()->last()->project_id;

        for ($usersCounter = 3; $usersCounter <= 4; $usersCounter++) {
            for ($projectsCounter = $firstProject; $projectsCounter <= $lastProject; $projectsCounter++) {
                if (random_int(0, 9) === 7)
                    DB::table('user_contacted_projects')->insert([
                        'user_id' => $usersCounter,
                        'project_id' => $projectsCounter,
                        'has_contacted' => true
                    ]);
            }
        }
    }
}
