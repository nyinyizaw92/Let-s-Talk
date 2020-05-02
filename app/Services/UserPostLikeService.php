<?php

namespace App\Services;

use App\Post;

class UserPostLikeService
{
    function post_inc_dec($id, $text)
    {
        $like_count_inc_dec = Post::findOrFail($id);
        if ($text == "increment") {
            $like_count_inc_dec->increment('like_count');
        } elseif ($text == "decrement") {
            $like_count_inc_dec->decrement('like_count');
        }
        return $like_count_inc_dec;
    }

    function post_comment_inc_dec($id, $text)
    {
        $comment_count_inc_dec = Post::findOrFail($id);
        if ($text == "increment") {
            $comment_count_inc_dec->increment('comment_count');
        } elseif ($text == "decrement") {
            $comment_count_inc_dec->decrement('comment_count');
        }
        return $comment_count_inc_dec;
    }
}
