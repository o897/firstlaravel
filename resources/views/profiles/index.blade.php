@extends('layouts.app')

@section('content')
<div class="container">
   <div class="row">
    <div class="col-lg-3 col-sm-12 p-5">
        <img src="{{$user->profile->profileImage()}}" alt="" class="rounded-circle w-100">
    </div>
    <div class="col-lg-9 col-sm-12 pt-5">
        <div class="d-flex justify-content-between align-items-baseline">
            
            <div class="d-flex align-items-center pb-3">
                <div class="h4">{{$user->username}}</div>

                {{-- passing the users id --}}
                <follow-button user-id="{{ $user->id }}" follows="{{$follows}}"></follow-button>
               
            </div>
            @can('update', $user->profile)
            <a href="/p/create">Add New Post</a>
            @endcan
           
        </div>

        {{-- It will return truue or false is users profile is authenticated it will show (its using update method) --}}
        @can ('update', $user->profile)
        <a href="/profile/{{$user->id}}/edit">Edit Profile</a>
        @endcan

        <div class="d-flex">
            <!-- user post just get me the count -->
            <div class="pr-5"><strong>{{$postCount}}</strong> posts</div>
            <div class="pr-5"><strong>{{$followersCount}}</strong> followers</div>
            <div class="pr-5"><strong>{{$followingCount}}</strong> following</div>
        </div>
        <div class="pt-4 font-weight-bold">{{$user->profile->title}}</div>
        <div>{{$user->profile->description}}</div>
        <div><a href="#">{{$user->profile->url}}</a></div>
    </div>
   </div>
   <div class="row pt-5">
   @foreach($user->posts as $post)
    <div class="col-4 pb-4">
        <!-- Our post we need your image -->
        <a href="/p/{{$post->id}}">
            <img src="/storage/{{$post->image}}" class="w-100" alt="">
        </a>
    </div>
    @endforeach
   </div>
</div>
@endsection
