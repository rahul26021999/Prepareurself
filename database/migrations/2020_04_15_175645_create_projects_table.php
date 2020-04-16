<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->bigIncrements('id');
            $table->longText('name');
            $table->longText('description')->nullable();
            $table->enum('type',['theory','video']);
            $table->enum('level',['easy','medium','hard']);
            $table->longText('image_url')->nullable();
            $table->longText('link');
            $table->string('playlist')->nullable();
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('admin_id');
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
        Schema::dropIfExists('projects');
    }
}
