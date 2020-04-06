@extends('layouts.app')

@section('content')
<div class="post-create">
    <form action="{{route('post.update',$post->id)}}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')   
        <div class="post-title">
            <label for="title">Title</label>
            <input type="text" 
            name="title" 
            id="title" 
            value="{{$post->title}}"/>
        </div>

        <div class="post-content">
            <label for="content">Content</label>
            <textarea 
            name="content" 
            id="content" cols="30" rows="10" 
            >{{$post->content}}</textarea>
        </div>

        <select name="category" id="category" required>
            <option value="{{$post->category->id}}">{{$post->category->title}}</option>
        @foreach($categories as $category)
            <option value="{{$category->id}}">{{$category->title}}</option>
        @endforeach
        </select>


        @if($post->image !== 'null')
            <img src="/uploads/{{$post->image}}" alt="image">
        @endif
        <div class="post-image">
            <label for="file">Update Images</label>
            <input type="file" name="file" id="file">
        </div>

        <div class="post-save">
            <div class="cancle">
                <a href="{{URL::to('/')}}">Cancle</a>
            </div> 
            <div class="save">
                <input type="submit" value="Post"/>
            </div> 
        </div>
    </form>
</div>
@endsection
