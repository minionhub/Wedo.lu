<?php

use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(LanguagesSeeder::class);
        $this->call(CountriesTableSeeder::class);
        $this->call(TimezonesTableSeeder::class);
        $this->call(RegionsTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(ProjectCategoriesTableSeeder::class);
        $this->call(ProjectSubCategoriesTableSeeder::class);
        $this->call(ProjectStartTimeSeeder::class);
        $this->call(ProjectsTableSeeder::class);
        $this->call(ServicesTableSeeder::class);
        $this->call(CompanyTableSeeder::class);
        $this->call(JobOfferTableSeeder::class);
        $this->call(EventTableSeeder::class);
        $this->call(PromotionTableSeeder::class);
        $this->call(TagsTableSeeder::class);
        $this->call(PostsTableSeeder::class);
        $this->call(ProductTypesTableSeeder::class);
        $this->call(PaymentMethodsTableSeeder::class);
        $this->call(ProductsTableSeeder::class);
        $this->call(OrdersTableSeeder::class);
        $this->call(PagesTableSeeder::class);
        $this->call(UserContactedProjectsSeeder::class);
        $this->call(ProjectsNotificationsSeeder::class);
        $this->call(UserActiveProductsSeeder::class);
    }
}
