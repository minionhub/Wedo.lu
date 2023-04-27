<?php

use App\Enums\Role;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('first_name')->nullable()->default(null);
            $table->string('last_name')->nullable()->default(null);
            $table->string('nickname')->nullable()->default(null);
            $table->string('display_name');
            $table->string('email');
            $table->string('email_project_notifications')->nullable();
            $table->string('password');
            $table->enum('role', array(Role::Regular, Role::Moderator, Role::Administrator));
            $table->boolean('is_pro_user')->default(false);
            $table->boolean('manages_companies')->default(false);
            $table->boolean('is_blocked')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
