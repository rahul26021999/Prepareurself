<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_responses', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('live_quiz_id');
            $table->unsignedBigInteger('question_id');
            $table->integer('selcted_option');
            $table->timestamp('response_time');
            $table->primary(['user_id', 'live_quiz_id','question_id']);
            $table->timestamps();
            // $table->foreign('user_id')->references('id')->on('users');
            // $table->foreign('live_quiz_id')->references('id')->on('live_quizes');
            // $table->foreign('question_id')->references('id')->on('questions_bank');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_responses');
    }
}
