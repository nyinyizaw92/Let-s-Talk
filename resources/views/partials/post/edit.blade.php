@extends('layouts.app')

@section('content')
<div class="post-edit">
    <form action="{{route('post.update',$post->id)}}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')   
        <div class="post-title">
            <label for="title">Title</label><br/>
            <input type="text" 
            name="title" 
            id="title" 
            value="{{$post->title}}"/>
        </div>

        <div class="post-content">
            <label for="content">Content</label><br/>

            <textarea 
            name="content" 
            id="content" cols="30" rows="10" 
            >{{$post->content}}</textarea>
        </div>

        <div class="old-category">
            <label for="category_id">Category</label><br/>

            <select name="category_id" id="category_id" required>
                <option value="{{$post->category->id}}">{{$post->category->title}}</option>
            @foreach($categories as $category)
                <option value="{{$category->id}}">{{$category->title}}</option>
            @endforeach
            </select>
        </div>

        <div class="old-img">
            @if($post->image !== null)
            <img src="/uploads/{{$post->image}}" alt="image">
            @else 
                <label for="image">
                    <img src="/icons/icons8-upload-100.png" alt="image">
                </label>
           
            @endif

            <div class="post-image">
                {{-- <label for="file">Update Images</label> --}}
                <input type="file" name="image" id="image">
            </div>
        </div>
      

        <div class="post-save">
            <div class="cancle">
                <a href="javascript:history.go(-1)">Cancle</a>
            </div> 
            <div class="save">
                <input type="submit" value="Post"/>
            </div> 
        </div>
    </form>
</div>
@endsection
