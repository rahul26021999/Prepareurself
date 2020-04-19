<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Mail\ResetPassword;
use Illuminate\Support\Facades\URL;
use Mail;


class Admin extends Authenticatable
{
    use Notifiable;

    protected $guard = 'admin';

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name','last_name', 'email', 'password','profile_image'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    function getAvatarAttribute()
    {
        return "/defaults/admin/".$this->profile_image;
    }
    function getSuperAttribute()
    {
        return $this->user_role=='superAdmin'?true:false;
    }

    function sendForgotPasswordMail()
    {
        $link=$this->getResetPasswordLink();
        Mail::to($this)->send(new ResetPassword($link));
    }

    function getResetPasswordLink()
    {
        return URL::temporarySignedRoute(
                'admin.showResetPassword', now()->addHour(), ['id' => base64_encode($this->id)]
            );
    }

}
