<?php

use App\Enums\Region;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->bigIncrements('listing_id');
            $table->string('logo_img');
            $table->string('cover_img');
            $table->text('full_description');
            $table->string('slug');
            $table->string('contact_email');
            $table->json('region')->nullable();

            //////////////subclass attributes/////////////////

            $table->string('title');
            $table->string('tagLine');
            $table->json('set_of_images');
            $table->double('map_longitude');
            $table->double('map_latitude');
            $table->string('video_url');
            $table->string('contact_phone');
            $table->string('event_link');
            $table->string('address');
            $table->dateTime('date_and_time');
            $table->timestamps();

            // foreign keys //

            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
