<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('source_id');
            $table->string('source_title');
            $table->string('title')->nullable();
            $table->longText('description')->nullable();
            $table->string('link')->nullable();
            $table->string('post_date')->nullable();
            $table->string('comments')->nullable();
            $table->string('category')->nullable();
            $table->string('author')->nullable();
            $table->string('guid')->nullable();
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
        Schema::dropIfExists('items');
    }
}
