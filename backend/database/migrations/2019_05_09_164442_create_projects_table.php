<?php

use App\Models\Project;
use App\Enums\ProjectStatus;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->bigIncrements('project_id');
            $table->string('title');
            $table->string('slug');
            $table->string('website_language');
            $table->date('publish_date');
            $table->json('status', array(ProjectStatus::draft, ProjectStatus::published, ProjectStatus::archived, ProjectStatus::blocked));
            $table->string('description');
            $table->json('attached_files')->nullable()->default(null);
            $table->string('author_name');
            $table->string('author_email');
            $table->string('author_phone');
            $table->string('author_prefers_to_be_contacted_in');
            $table->string('project_address');
            $table->json('region');

            $table->smallInteger('start_time');

            $table->integer('number_of_offers');
            $table->timestamps();

            $table->unsignedBigInteger('author_id')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
        Project::deleteIndex();
    }
}
