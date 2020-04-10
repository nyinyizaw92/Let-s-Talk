<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserLikePost extends Model
{
    protected $table = "user_like_posts";
    protected $fillable = ['user_id', 'post_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
