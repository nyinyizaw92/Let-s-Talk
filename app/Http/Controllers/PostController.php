<?php

namespace App\Http\Controllers;

use App\Post;
use App\Category;
use App\Comment;
use Illuminate\Http\Request;
use App\Http\Requests\PostSaveRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Http\Resources\PostResource;
use App\Http\Resources\PostResourceCollection;
use App\UserLikePost;
use Faker\Provider\ar_JO\Person;
use Illuminate\Support\Facades\Auth;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::paginate(10);
        // return new PostResourceCollection(Post::paginate(10));
        return view('partials.post.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();

        return view('partials.post.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostSaveRequest $request)
    {
        $create = $request->except('image');
        $image = $request->file('image');
        $post_create = new Post();
        if ($image) {
            $target_path = public_path('/uploads/');
            $files =  date('YmdHis') . "." . $image->getClientOriginalExtension();
            if ($image->move($target_path, $files)) {
                $create['image'] = $files;
            }
        }
        $post_create->create($create);
        return redirect('/')->with('success', 'Create post success.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post_detail = Post::find($id);
        $comments = Comment::where('post_id', $id)->with('user')->get();


        return view('partials.post.show', compact(['post_detail', 'comments']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        // dd($post);
        $categories = Category::all();
        return view('partials.post.edit', compact(['post', 'categories']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(PostUpdateRequest $request, Post $post)
    {
        $update = $request->except('image');
        $image = $request->file('image');
        if ($image) {
            $target_path = public_path('/uploads/');
            $files =  date('YmdHis') . "." . $image->getClientOriginalExtension();
            if ($image->move($target_path, $files)) {
                $update['image'] = $files;
            }
        }
        $post->update($update);
        return redirect('/')->with('success', 'success update post');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        // $post_id = $post->id;
        // if (is_array($post_id) || is_object($post_id)) {
        //     foreach ($post_id as $id) {
        //         $comment = Comment::where('post_id', $id)->delete();
        //     }

        //     foreach ($post_id as $id) {
        //         $like = UserLikePost::where('post_id', $id)->delete();
        //     }
        // }
        $post->delete();
        return redirect('/')->with('errors', 'post delete');
    }
}
