<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('source')->nullable();
            $table->string('main_keyword')->nullable();
            $table->string('job_title')->nullable();
            $table->string('position_tags')->nullable();
            $table->string('remote_tags')->nullable();
            $table->string('tech_tags')->nullable();
            $table->string('formatted_title')->nullable();
            $table->string('company')->nullable();
            $table->string('budget')->nullable();
            $table->longText('job_html')->nullable();
            $table->string('contact_link')->nullable();
            $table->string('contact_text')->nullable();
            $table->string('status')->nullable();
            $table->string('emails')->nullable();
            $table->string('filename')->nullable();
            $table->string('scrape_status')->nullable();
            $table->string('url')->nullable();
            $table->string('post_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jobs');
    }
}
