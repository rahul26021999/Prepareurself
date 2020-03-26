<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('username');
            $table->string('phone_number');
            $table->string('android_token');
            $table->timestamp('last_login_at')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}

// php artisan migrate --path=/database/migrations/2014_10_12_000000_create_users_table.php
// php artisan migrate --path=/database/migrations/2020_03_26_132122_create_questions_banks_table.php
// php artisan migrate --path=/database/migrations/2020_03_26_132030_create_live_quizes_table.php
// php artisan migrate
