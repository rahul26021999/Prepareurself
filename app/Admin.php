<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Mail\ResetPassword;
use Illuminate\Support\Facades\Log;
use App\Mail\PasswordChangedSuccessfull;
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

    public function getNameAttribute($value)
    {
       return ucfirst($this->first_name) . ' ' . ucfirst($this->last_name);
    }

    function getAvatarAttribute()
    {
        return "/defaults/admin/".$this->profile_image;
    }
    
    function getSuperAttribute()
    {
        return $this->user_role=='superAdmin'?true:false;
    }

    public function sendForgotPasswordMail()
    {
        $link=$this->getResetPasswordLink();
        Mail::to($this)->send(new ResetPassword($link,$this));
    }

    public function getResetPasswordLink()
    {
        return URL::temporarySignedRoute(
                'showResetPassword', now()->addHour(), ['id' => base64_encode($this->id),'type'=>base64_encode('Admin')]
            );
    }
    public function sendPasswordUpdateMail()
    {
        Mail::to($this)->send(new PasswordChangedSuccessfull($this));
    }

    public function Email()
    {
        return $this->hasMany('App\Models\Email');
    }
}
