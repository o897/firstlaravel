<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\Facades\Image;


class ProfilesController extends Controller
{
    //$gives us the id of that username
    public function index(User $user)
    {
        // Grabbed our user as $user
        // $user = User::findOrFail($user);
        //Search how compact function works
        //The authenticated users 'following' does that contain the user that passed in
        $follows = (auth()->user()) ? auth()->user()->following->contains($user->id) : false;
       
        $postCount = Cache::remember(
            'count.posts.' . $user->id,
             now()->addSeconds(30),
             function () use ($user){
                return $user->posts->count();            
        });

        $followersCount = Cache::remember(
            'count.followers.' . $user->id,
            now()->addSeconds(30),
            function () use ($user) {
                return $user->profile->followers->count();
            
        });

        $followingCount = Cache::remember(
            'count.following.' . $user->id,
             now()->addSeconds(30),
            function () use ($user) {
            return $user->following->count();
            
        });
        return view('profiles.index', compact('user', 'followingCount','followersCount' ,'postCount' , 'follows'));
    }

    //This will give us our user $user
    public function edit(User $user)
    {
        //Authorizing an update all it needs is a profile
        $this->authorize('update', $user->profile);

        return view('profiles.edit', compact('user'));
    }

    public function update(User $user){

        $this->authorize('update', $user->profile);

        //When the method is required validate these fields
        $data = request()->validate([
            'title' => 'required',
            'description' => 'required',
            'url' => 'url',
            'image' => '',
        ]);

    

        //if the request has an image
        if(request('image')) {
        
        //Well store the images inside profile, inside public driver
        $imagePath = request('image')->store('profile','public');

        //Storage  is what well have inside the public path
        $image = Image::make(public_path("storage/{$imagePath}"))->fit(1000,1000);   
        $image->save();

        $imageArray = ['image' => $imagePath];

        }



        //only grabbing the authenticated user
        //if image arr not set lets default to an empty arr || will not overrite anything in our data
         auth()->user()->profile->update(array_merge($data,
         $imageArray ?? []  
        ));

        return redirect("/profile/{$user->id}");

       
    }
}
