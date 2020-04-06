@extends('layouts.app')
@section('styles')
<style>
    .error{
        border-color:red;
    }
</style> 
@endsection
@section('content')
<div class="post-create">
   
    {{-- @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
     @endif --}}


    <form action="{{route('post.store')}}" method="POST" enctype="multipart/form-data">
        @csrf   
        <input type="hidden" value="{{Auth::user()->id}}" name="user_id">
        <div class="post-title">
            <label for="title">Title</label>
            <input type="text" name="title" 
            value="{{old('title')}}"
             id="title" placeholder="enter title" />
        </div>

        <div class="post-content">
            <label for="content">Content</label>
            <textarea name="content" id="content" 
            value="{{old('content')}}"
            cols="30" rows="10" placeholder="enter content"></textarea>
        </div>

        <select name="category_id" id="category" 
        value="{{old('category')}}" required>
            <option value="">Please Select One</option>
        @foreach($categories as $category)
            <option value="{{$category->id}}">{{$category->title}}</option>
        @endforeach
        </select>

        <div class="post-image">
            <label for="image">Choose Images</label>
            <input type="file" name="image" id="image">
        </div>

        <div class="post-save">
            <div class="cancle">
                <input type="reset" value="Cancel"/>
            </div> 
            <div class="save">
                <input type="submit" value="Post"/>
            </div> 
        </div>
    </form>
</div>
@endsection
