<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordChangedSuccessfull extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
    protected $contact_us;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user=$user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('noreply@prepareurself.in')
                ->subject('Password Changed Successfully')
                ->markdown('emails.user.password-changed')
                ->with('user',$this->user);
    }
}
