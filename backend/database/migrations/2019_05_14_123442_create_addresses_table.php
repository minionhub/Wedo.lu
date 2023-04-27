<?php

use App\Enums\AddressType;
use App\Enums\Country;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('country_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('street_name');
            $table->string('house_number')->nullable();
            $table->string('city');
            $table->string('zip');
            $table->string('phone');
            $table->string('email');
            $table->boolean('is_primary');

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('company_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('addresses');
    }
}
