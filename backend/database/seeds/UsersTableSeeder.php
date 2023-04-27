<?php

use App\Enums\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use MikeMcLin\WpPassword\Facades\WpPassword;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $john = new User;
        $john->first_name = 'John';
        $john->last_name = 'Doe';
        $john->nickname = 'johndoe';
        $john->display_name = 'John Doe';
        $john->email = 'john@wedo.lu';
        $john->password = Hash::make('newSecret123');
        $john->role = Role::Regular;
        $john->save();

        $jane = new User;
        $jane->first_name = 'Jane';
        $jane->last_name = 'Doe';
        $jane->nickname = 'janedoe';
        $jane->display_name = 'Jane Doe';
        $jane->email = 'jane@wedo.lu';
        $jane->password = WpPassword::make('secret2');
        $jane->role = Role::Regular;
        $jane->save();

        $rudolphe = new User;
        $rudolphe->first_name = 'Rudolphe';
        $rudolphe->last_name = 'Aben';
        $rudolphe->nickname = 'Rudolphe';
        $rudolphe->display_name = 'Rudolphe Aben';
        $rudolphe->email = 'aben@windowslive.com';
        $rudolphe->email_project_notifications = 'info@wedo.lu';
        $rudolphe->password = '$P$BlUdmbqAKlBuZ2.QY5l3kNa91w.Mi60';
        $rudolphe->role = Role::Administrator;
        $rudolphe->save();

        $anton = new User;
        $anton->first_name = 'Anton';
        $anton->last_name = 'Nico';
        $anton->nickname = 'crazy geek';
        $anton->display_name = 'Anton Nico';
        $anton->email = 'me@anton.lu';
        $anton->email_project_notifications = 'anton@wedo.lu';
        $anton->password = '$P$B0.x3u.WaE87FzDphyVtMYLZyqhPHD/';
        $anton->role = Role::Regular;
        $anton->is_pro_user = true;
        $anton->save();

        $momo = new User;
        $momo->first_name = 'Mohamed';
        $momo->last_name = 'Kalia';
        $momo->nickname = 'momo';
        $momo->display_name = 'momo';
        $momo->email = 'me@momo.lu';
        $momo->password = '$P$B0.x3u.WaE87FzDphyVtMYLZyqhPHD/';
        $momo->role = Role::Regular;
        $momo->manages_companies = false;
        $momo->save();

        $momo = new User;
        $momo->first_name = 'Test';
        $momo->last_name = 'User';
        $momo->nickname = 'test';
        $momo->display_name = 'test user';
        $momo->email = 'test@user.com';
        $momo->password = '$P$B0.x3u.WaE87FzDphyVtMYLZyqhPHD/';
        $momo->role = Role::Regular;
        $momo->save();

        $oneCompanyUser = new User;
        $oneCompanyUser->first_name = 'One';
        $oneCompanyUser->last_name = 'Company';
        $oneCompanyUser->nickname = 'One Company Guy';
        $oneCompanyUser->display_name = 'One Company Guy';
        $oneCompanyUser->email = 'one@user.com';
        $oneCompanyUser->password = '$P$B0.x3u.WaE87FzDphyVtMYLZyqhPHD/';
        $oneCompanyUser->role = Role::Regular;
        $oneCompanyUser->is_pro_user = true;
        $oneCompanyUser->save();
    }
}
