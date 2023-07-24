<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    // A post belongs to a user
    // User this method to get owner of the post
    public function user(){
        return $this->belongsTo(User::class)->withTrashed();
    }

    # To get the categories under a post
    # hasMany() --> 1 to many
    public function categoryPost(){
        return $this->hasMany(CategoryPost::class);
    }

    #to get all the comments of a post
    public function comments(){
        return $this->hasMany(Comment::class);
    }

    #Use this method to get the like of the post
    public function likes(){
        return $this->hasMany(Like::class);
    }

    # Return true if the Auth user id liked the post
    public function isLiked(){
        return $this->likes()->where('user_id', Auth::user()->id)->exists();
    }


}