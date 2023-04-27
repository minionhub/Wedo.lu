<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectStartTimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('project_start_times')->insert(['key' => -1, 'text' => 'Pas de date fixée']);
        DB::table('project_start_times')->insert(['key' => 0, 'text' => 'Au plus vite']);
        DB::table('project_start_times')->insert(['key' => 30, 'text' => 'Dans moins d\'un mois']);
        DB::table('project_start_times')->insert(['key' => 60, 'text' => 'Dans moins de deux mois']);
        DB::table('project_start_times')->insert(['key' => 90, 'text' => 'Dans moins de trois mois']);
        DB::table('project_start_times')->insert(['key' => 120, 'text' => 'Dans moins de quatre mois']);
        DB::table('project_start_times')->insert(['key' => 150, 'text' => 'Dans moins de cinq mois']);
        DB::table('project_start_times')->insert(['key' => 180, 'text' => 'Dans moins de six mois']);
        DB::table('project_start_times')->insert(['key' => 365, 'text' => 'Dans l\'année']);
    }
}
