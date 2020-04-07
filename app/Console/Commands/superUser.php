<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use App\Admin;

class superUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:superUser';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'It will make a super user in the Admin table';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $admin=Admin::create([
            'first_name'=>'Rahul',
            'last_name'=>'Gupta',
            'password'=>Hash::make('ohmygod'),
            'email'=>"rahul26021999@gmail.com",
            'profile_image'=>'superAdmin.jpg',
        ]);
        $admin->user_role='superAdmin';
        $admin->save();
    }
}
