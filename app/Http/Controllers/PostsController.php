<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class PostsController extends Controller
{

    //Every single route in here will require authorisation
   public function __construct()
   {
        $this->middleware('auth');
   }

   public function index()
   {
    //Authenticated user please give me the people youre folloing dont forget their id :) thank you
    $users = auth()->user()->following()->pluck('profiles.user_id'); //the user_id in the profiles table
    
    //We going to pass an array of data where
    // the users_id is in that list of users we just grabbed
    $posts = Post::whereIn('user_id', $users)->with('user')->latest()->paginate(5);

    return view('posts.index', compact('posts'));
   }

    public function create()
    {
        //post directory,view called create same as the function
        return view('posts.create');
    }

    public function store()
    {
        //Through the request validate that request and give me back all the validated data
        $data = request()->validate([
            'caption' => 'required',
            'image' => 'required',
        ]);

        //Laravel knows about the relationship user has with posts
        //give me the auhenticated user and on that user call posts
        $imagePath = request('image')->store('uploads','public');

        $image = Image::make(public_path("storage/{$imagePath}"))->fit(1200,1200);   
        $image->save();
        auth()->user()->posts()->create([
            'caption' => $data['caption'],
            'image' => $imagePath,
        ]);
    

        //dial dump gives us everything 'info
        // dd(request()->all());

        return redirect('/profile/' . auth()->user()->id);

    }

    public function show(\App\Post $post)
    {
        return view('posts.show', compact('post'));
    }
}
