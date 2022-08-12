<?php

namespace App;
use App\Mail\NewUserWelcomeMail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Mail;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'username', 'password',
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


    //Boot method gets called when we are booting up this model
    public static function boot()
    {
        parent::boot();

        //this created event gets fired whenever a new user is created
        static::created(function($user) {
            $user->profile()->create([
                'title' => $user->username, //the username is our use default title
            ]);
                                             
            Mail::to($user->email)->send(new NewUserWelcomeMail());
        });
    }

    public function posts()
    { 
        //created at column was created for on the migration's {post->timestamp}
        return $this->hasMany(Post::class)->orderBy('created_at', 'DESC');
    }

    //A user can follow many profiles
    //In a case of a mnay to many relationship we have to create a pivit table
    public function following()
    {
        return $this->belongsToMany(Profile::class); //
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

   
}
