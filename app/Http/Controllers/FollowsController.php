<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class FollowsController extends Controller
{
   
    public function __construct()
    {
        $this->middleware('auth');
    }

    //What kind of route should we have in our follows controller [storing a following]
    //Well accept the user we passing it in our route
    public function store(User $user)
    {
        return auth()->user()->following()->toggle($user->profile);
    }
}
