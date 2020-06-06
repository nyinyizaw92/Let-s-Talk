<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserSavePost extends Model
{
    protected $table = "user_save_posts";
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
