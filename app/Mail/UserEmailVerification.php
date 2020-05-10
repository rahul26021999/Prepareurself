<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserEmailVerification extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $url;

    protected $theme = 'promotion-theme';
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($link,$user)
    {
        $this->user=$user;
        $this->url=$link;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Verify Your Email')
                    ->markdown('emails.user.email-verify');
    }
}
