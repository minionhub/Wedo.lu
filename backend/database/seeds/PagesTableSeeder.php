<?php

use Illuminate\Database\Seeder;

class PagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pages')
            ->insert([
                'name' => 'faq',
                'content' => file_get_contents(public_path('pages/faq.html'))
            ]);

        DB::table('pages')
            ->insert([
                'name' => 'mentions-legales',
                'content' => file_get_contents(public_path('pages/mentions-legales.html'))
            ]);

        DB::table('pages')
            ->insert([
                'name' => 'conditions-1',
                'content' => file_get_contents(public_path('pages/conditions-1.html'))
            ]);

        DB::table('pages')
            ->insert([
                'name' => 'conditions-2',
                'content' => file_get_contents(public_path('pages/conditions-2.html'))
            ]);
    }
}
