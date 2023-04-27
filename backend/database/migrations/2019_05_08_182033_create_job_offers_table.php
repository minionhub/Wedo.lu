<?php

use App\Models\JobOffer;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Enums\ContractType;
use App\Enums\LevelOfLanguageMastery;

class CreateJobOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_offers', function (Blueprint $table) {
            $table->bigIncrements('listing_id');
            $table->string('logo_img');
            $table->string('cover_img')->nullable();
            $table->text('full_description');
            $table->string('slug');
            $table->string('contact_email');
            $table->json('region')->nullable();
            //////////////subclass attributes/////////////////

            $table->string('job_title');
            $table->enum('contract_type', array(ContractType::CDI, ContractType::CDD, ContractType::Internship))->default('CDI');
            $table->string('pdf')->nullable(); // optional attachment, URL to static assets location (not CDN)
            $table->string('payment')->nullable();
            $table->string('website_url')->nullable();
            $table->string('phone')->nullable();
            $table->double('map_longitude')->nullable();
            $table->double('map_latitude')->nullable();
            $table->string('company_name');
            $table->string('company_social_security_number')->nullable();
            $table->string('contact_person')->nullable(); // currently we keep it just like that, contact person's name, nothing more
            $table->enum('level_of_luxembourgish', array(LevelOfLanguageMastery::NotRequired, LevelOfLanguageMastery::A1,
                LevelOfLanguageMastery::A2, LevelOfLanguageMastery::B1, LevelOfLanguageMastery::B2, LevelOfLanguageMastery::C1,
                LevelOfLanguageMastery::C2, LevelOfLanguageMastery::C3
            ))->default('NotRequired');

            $table->enum('level_of_german', array(LevelOfLanguageMastery::NotRequired, LevelOfLanguageMastery::A1,
                LevelOfLanguageMastery::A2, LevelOfLanguageMastery::B1, LevelOfLanguageMastery::B2, LevelOfLanguageMastery::C1,
                LevelOfLanguageMastery::C2, LevelOfLanguageMastery::C3
            ))->default('NotRequired');

            $table->enum('level_of_french', array(LevelOfLanguageMastery::NotRequired, LevelOfLanguageMastery::A1,
                LevelOfLanguageMastery::A2, LevelOfLanguageMastery::B1, LevelOfLanguageMastery::B2, LevelOfLanguageMastery::C1,
                LevelOfLanguageMastery::C2, LevelOfLanguageMastery::C3
            ))->default('NotRequired');

            $table->enum('level_of_english', array(LevelOfLanguageMastery::NotRequired, LevelOfLanguageMastery::A1,
                LevelOfLanguageMastery::A2, LevelOfLanguageMastery::B1, LevelOfLanguageMastery::B2, LevelOfLanguageMastery::C1,
                LevelOfLanguageMastery::C2, LevelOfLanguageMastery::C3
            ))->default('NotRequired');

            $table->timestamps();

            // foreign keys //
            $table->unsignedBigInteger('category_id');

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
        Schema::dropIfExists('job_offers');
        JobOffer::deleteIndex();
    }
}
