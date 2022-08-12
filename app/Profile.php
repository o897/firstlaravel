<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{

    //disabling mass assignment we are being very particular about how we are receiving this fields {required}
    protected $guarded = [];

    public function profileImage()
    {
        $imagePath = ($this->image) ? $this->image : 'profile/no_profile_image.png';
        return '/storage/' . $imagePath ;
    }

    
    public function followers()
    {
        //A profile can have many followers
        return $this->belongsToMany(User::class); //belongs to many users
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
