<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Post;
use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;
use App\Http\Requests\CommentUpdateRequest;
use App\ReplyComment;
use App\Services\UserPostLikeService;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CommentRequest $request,UserPostLikeService $postcomment)
    {
        
        $create = $request->except('image');
        $image = $request->file('image');

        $user_comment_count = $postcomment->user_comment_inc_dec($request->user_id, "increment");

        $comment = new Comment();

        if ($image) {
            $target_path = public_path('/comments/');
            $files =  date('YmdHis') . "." . $image->getClientOriginalExtension();
            if ($image->move($target_path, $files)) {

                $create['image'] = $files;
            }
        }

        $comment->create($create);

        $post_comment = Post::findOrFail($request->post_id);
        $post_comment->increment('comment_count');
        $post_comment->update();

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(CommentUpdateRequest $request, Comment $comment)
    {
        $update = $request->except('image');
        $image = $request->file('image');

        if ($image) {
            $target_path = public_path('/comments/');
            $files =  date('YmdHis') . "." . $image->getClientOriginalExtension();
            if ($image->move($target_path, $files)) {
                $update['image'] = $files;
            }
        }

        $comment->update($update);

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment, UserPostLikeService $postcomment)
    {
        $comment = Comment::findOrFail($comment->id);
        $user_comment_count = $postcomment->user_comment_inc_dec($comment->user_id, "decrement");

        if ($comment->has_reply == 1) {
            $reply_comment = ReplyComment::where('comment_id', $comment->id)->get();
            foreach ($reply_comment as $rpl_cmt) {
                $rpl_cmt->delete();
                $comment_count_inc_dec = $postcomment->post_comment_inc_dec($comment->post_id, "decrement");
                $user_comment_count = $postcomment->user_comment_inc_dec($comment->user_id, "decrement");
            }

            $comment_count_inc_dec = $postcomment->post_comment_inc_dec($comment->post_id, "decrement");
            $comment->delete();
        } elseif ($comment->has_reply == 0) {
            $comment_count_inc_dec = $postcomment->post_comment_inc_dec($comment->post_id, "decrement");
            
            $comment->delete();
        }

        return back();
    }
}
