<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserFeedbackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_feedback', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->enum('question1',['Very Good','Good','Fair','Bad']);
            $table->enum('question2',['Very Good','Good','Fair','Bad']);
            $table->enum('question3',['Very Good','Good','Fair','Bad']);
            $table->enum('question4',['Very Good','Good','Fair','Bad']);
            $table->longText('question5');
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
        Schema::dropIfExists('user_feedback');
    }
}
