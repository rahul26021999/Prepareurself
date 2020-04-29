<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserEmailVerification extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
    protected $link;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($link,$user)
    {
        $this->user=$user;
        $this->link=$link;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('noreply@prepareurself.in')
                    ->subject('Verify Your Email')
                    ->markdown('emails.user.email-verify')
                    ->with('url',$this->link)
                    ->with('user',$this->user);
    }
}
