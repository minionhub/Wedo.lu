<?php

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\ProjectSubCategory;
use App\Models\ProjectNotification;

class ProjectsNotificationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        $subcatsIds = ProjectSubCategory::all()->pluck('subcategory_id')->toArray();

        foreach ($users as $user)
            if ($user->role == 'Pro' || $user->role == 'Administrator') {
                foreach ($subcatsIds as $subcatId) {
                    if (random_int(0, 2) == 1) {
                        $notification = new ProjectNotification;
                        $notification->user_id = $user->id;
                        $notification->subcat_id = $subcatId;
                        $notification->notify = true;

                        $notification->save();
                    }
                }
            }
    }
}
