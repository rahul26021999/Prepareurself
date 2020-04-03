<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLiveQuizzesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('live_quizzes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->longText('quiz_title');
            $table->longText('quiz_desc')->nullable();
            $table->smallInteger('no_of_ques');
            $table->timestamp('start_time');
            $table->smallInteger('ques_time_span');
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
        Schema::dropIfExists('live_quizzes');
    }
}
