<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Category extends Model
{
    protected $table = 'categories';

    protected $fillable = ['title'];

    public function post()
    {
        return $this->hasMany(Post::class);
    }

    // public function getSearchResult(): SearchResult
    // {
    //     $url = route('category.show', $this->id);

    //     return new SearchResult(
    //         $this,
    //         $this->title,
    //         $url
    //     );
    // }
}
