<?php

use App\Models\Company;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->bigIncrements('listing_id');
            $table->string('logo_img');
            $table->string('cover_img')->nullable();
            $table->text('full_description');
            $table->string('slug');
            $table->string('contact_email');
            $table->json('region')->nullable();

            //////////////subclass attributes/////////////////

            $table->string('company_name');
            $table->string('short_desc')->nullable();
            $table->string('street')->nullable();
            $table->string('houseNbr')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('city')->nullable();
            $table->double('map_longitude');
            $table->double('map_latitude');
            $table->string('location');
            $table->json('set_of_images')->nullable();
            $table->string('phone')->nullable();
            $table->string('website_url')->nullable();
            $table->string('fax')->nullable();
            $table->string('e_commerce')->nullable();
            $table->json('social_networks')->nullable();
            $table->string('codeNace')->nullable();
            $table->string('commercialRegisterCode')->nullable();
            $table->string('internationalTVAnbr')->nullable();
            $table->string('nationalTVAnbr')->nullable();
            $table->string('revenue')->nullable();
            $table->string('shareCapital')->nullable();
            $table->string('employeeNbr');
            $table->string('foundationDate')->nullable();
            $table->string('additionalDetails')->nullable();
            $table->json('brands')->nullable();
            $table->json('opening_hours')->nullable();
            $table->json('accepted_payment_methods')->nullable();
            $table->json('spoken_languages')->nullable();
            $table->json('certifications')->nullable();
            $table->json('facilities')->nullable();
            $table->boolean('is_premium_listing')->default(false);
            $table->timestamps();

            // foreign keys //

            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('timezone_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies');
        Company::deleteIndex();
    }
}
