<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use Log;
use Mail;
use DB;
use App\Models\Course;
use App\Models\ResourceProjectViews;
use App\Mail\CourseOfWeekMail;

class CourseOfWeek extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'CourseOfWeek:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $views = DB::table('resource_project_views')
                     ->groupBy('course_id')
                     ->select(DB::raw('count(*) as views'),'course_id')
                     ->orderBy('views','desc')
                     ->first();

        Log::info(print_r($views));

        $emails=array('rahul26021999@gmail.com','rahul9650ray@gmail.com','tanyagarg2509@gmail.com','rimjhimvaish@gmail.com','riyagoel192@gmail.com');
        
        $users = User::whereIn('email',$emails)->get();

        // $users = User::where('email_verified_at','!=',null)->get()->toArray();

        Log::alert("Mail send to ".count($users)."Users");

        $view=ceil($views->views / 10) * 10;

        // $message = (new CourseOfWeekMail($view))
                // ->onQueue('course_of_week');

        // Mail::to($users)->queue($message);
        
        foreach ($users as $user) {
            Mail::to($user)->send(new CourseOfWeekMail($view));
        }

    }
}
