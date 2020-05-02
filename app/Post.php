<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Post extends Model implements Searchable
{
    //
    protected $table = "posts";

    protected $fillable = [
        'title',
        'content',
        'category_id',
        'user_id',
        'image'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function comment()
    {
        return $this->hasMany(Comment::class);
    }



    public function userlike()
    {
        return $this->hasMany(UserLikePost::class);
    }

    public function getSearchResult(): SearchResult
    {
        $url = route('show', $this->id);

        return new SearchResult(
            $this,
            $this->title,
            $url
        );
    }
}
