<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use App\Mail\PasswordChangedSuccessfull;
use App\Mail\UserEmailVerification;
use App\Mail\ResetPassword;
use App\Helpers\AndroidNotification;
use Mail;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name','last_name', 'email', 'password','phone_number','username','android_token','dob','prefrences','profile_image'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Determine if the user has verified their email address.
     *
     * @return bool
     */
    public function hasVerifiedEmail(){
        return ! is_null($this->email_verified_at);
    }

    /**
     * Mark the given user's email as verified.
     *
     * @return bool
     */
    public function markEmailAsVerified(){
        return $this->forceFill([
            'email_verified_at' => $this->freshTimestamp(),
        ])->save();
    }

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationMail(){
        $link=$this->getEmailVerificationLink();
        Mail::to($this)->send(new UserEmailVerification($link,$this));
    }

    /**
     * Get the email address that should be used for verification.
     *
     * @return string
     */
    public function getEmailForVerification(){
        return $this->email;
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function isAdmin()
    {
        return $this->role=='admin' ? true : false;
    }

    public function sendForgetPasswordMail()
    {
        $link=$this->getResetPasswordLink();
        Mail::to($this)->send(new ResetPassword($link,$this));
    }

    public function getResetPasswordLink()
    {
        return URL::temporarySignedRoute(
                'showResetPassword', now()->addHour(), ['id' => base64_encode($this->id),'type'=>base64_encode('user')]
            );
    }

    public function getEmailVerificationLink()
    {
        return URL::temporarySignedRoute(
                'showVerify', now()->addDay(), ['id' => base64_encode($this->id),'type'=>base64_encode('user')]
            );
    }

    public function sendPasswordUpdateMail()
    {
        Mail::to($this)->send(new PasswordChangedSuccessfull($this));
    }

    public function makeNotification()
    {
        return [
            'title'=>'ray chodu',
            'body' => 'ray sabko apne gand deta hai',
            'image' => 'http://www.prepareurself.tk/defaults/admin/superAdmin.jpg',
        ];
    }
    public function sendAndroidNotification()
    {
        $notification=$this->makeNotification();
        $a=new AndroidNotification();
        $a->send('d1RGfW5OfD8:APA91bGBeKrS2axJlzku3KAsmlvqVFoF3NcoAaBTmON6idjMr-IkhCzORhBXaEiR2-qD0UiTQWcme6SF1zfRxV-VTnCF7pQhSguiSQJRFOVkm-j50Wx2LkGclbf-4M4eyXqEUgg6dDkZ',$notification);
    }

}
