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
            $table->smallInteger('sequence')->nullable();
            $table->enum('status',['publish','dev'])->default('dev');
            $table->longText('image_url')->nullable();
            $table->longText('link');
            $table->string('playlist')->nullable();
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('admin_id');
            $table->timestamps();
        });
        // ALTER TABLE `projects` ADD `sequence` SMALLINT NULL DEFAULT NULL AFTER `level`, ADD `status` ENUM('publish','dev') NOT NULL DEFAULT 'dev' AFTER `sequence`; 
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
