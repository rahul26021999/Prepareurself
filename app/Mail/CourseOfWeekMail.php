<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CourseOfWeekMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $views;

    public function __construct($views)
    {
        $this->views=$views;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Weekly Updates')
                    ->from('contact@prepareurself.in','Team Prepareurself')
                    ->view('emails.course.course_of_week');
    }
}
