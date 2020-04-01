<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->longText('question');
            $table->longText('option1');
            $table->longText('option2');
            $table->longText('option3')->nullable();
            $table->longText('option4')->nullable();
            $table->integer('answer');
            $table->string('ques_type')->nullable();
            $table->enum('ques_level', ['easy','medium','hard'])->nullable();    
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
        Schema::dropIfExists('questions');
    }
}
