<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomEmail extends Mailable
{
    use Queueable, SerializesModels;


    public $user;
    public $subject;
    public $body;

    // protected $theme = 'promotion-theme';
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user,$subject,$body)
    {
        $this->user=$user;
        $this->subject=$subject;
        $this->body=$body;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subject)
                    ->view('emails.custom');
    }
}
