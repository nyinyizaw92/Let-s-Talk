<?php

namespace App\Http\Controllers;

use App\Post;
use App\Category;
use App\Comment;
use Illuminate\Http\Request;
use App\Http\Requests\PostSaveRequest;
use App\UserLikePost;
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
        $posts = Post::all();


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
        $image = $request->file('image');

        $post_create = new Post();
        $post_create->user_id = $request->user_id;
        $post_create->title = $request->title;
        $post_create->content = $request->content;
        $post_create->category_id = $request->category_id;

        if ($image) {
            $target_path = public_path('/uploads/');
            $files =  date('YmdHis') . "." . $image->getClientOriginalExtension();
            if ($image->move($target_path, $files)) {

                $post_create->image = $files;
                $post_create->save();
            }
        } else {
            $post_create->create($request->all());
        }


        return redirect('/')->with('success', 'post save');
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
    public function update(Request $request, Post $post)
    {
        $post_update = Post::find($post->id);
        $image = $request->file('file');
        $post_update->title = $request['title'];
        $post_update->content = $request['content'];
        $post_update->category_id = $request['category'];

        if ($image) {
            $target_path = public_path('/uploads/');
            $files =  date('YmdHis') . "." . $image->getClientOriginalExtension();
            if ($image->move($target_path, $files)) {
                $post_update->image = $files;
            }
        }
        $post_update->save();
        return redirect('/')->with('success', 'post save');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post_id = $post->id;
        if (is_array($post_id) || is_object($post_id)) {
            foreach ($post_id as $id) {
                $comment = Comment::where('post_id', $id)->delete();
            }

            foreach ($post_id as $id) {
                $like = UserLikePost::where('post_id', $id)->delete();
            }
        }
        $post_delete = Post::find($post->id)->delete();
        return redirect('/')->with('errors', 'post delete');
    }
}
