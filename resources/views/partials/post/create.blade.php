@extends('layouts.app')
@section('styles')
<style>
    .error{
        border-color:red;
    }
</style> 
@endsection
@section('content')

    <create-post :categories="{{$categories}}" :user = {{$user}}></create-post>

{{-- <div class="post-create">

    <h3>Add Post</h3>
   
    <form action="{{route('post.store')}}" method="POST" enctype="multipart/form-data">
        @csrf   
        <input type="hidden" value="{{Auth::user()->id}}" name="user_id">
        <div class="post-title">
            <label for="title">Title</label>
            <input type="text" name="title" 
            value="{{old('title')}}"
             id="title" placeholder="enter title"/>
            
        </div>
        @if ($errors->has('title'))
            <span class="text-danger">{{ $errors->first('title') }}</span>
        @endif

        <div class="post-content">
            <label for="content">Content</label>
            <textarea name="content" id="content" 
            value="{{old('content')}}"
            cols="30" rows="10" placeholder="enter content"></textarea>
        </div>
        @if ($errors->has('content'))
            <span class="text-danger">{{ $errors->first('content') }}</span>
        @endif

        <div class="post-category">
            <label for="category">Category</label>
            <select name="category_id" id="category" 
            value="{{old('category')}}">
                <option value="">Please Select One</option>
            @foreach($categories as $category)
                <option value="{{$category->id}}">{{$category->title}}</option>
            @endforeach
            </select>
        </div>
        @if ($errors->has('category_id'))
            <span class="text-danger">{{ $errors->first('category_id') }}</span>
        @endif
       

        <div class="post-image">
            <label for="image">Images</label>
            <input type="file" name="image" id="image" onchange="preview_image(event)">

            <div class="add-image">
                <img id="add-image"/>
            </div>
        </div>

        <div class="post-save">
            <div class="cancle">
                <input type="reset" value="Cancel" class="remove_preview"/>
            </div> 
            <div class="save">
                <input type="submit" value="Post"/>
            </div> 
        </div>
    </form>
</div> --}}
@endsection
@section('scripts')
<script>
function preview_image(event) 
 {
  var reader = new FileReader();
  reader.onload = function()
  {
   var output = document.getElementById('add-image');
   $('.add-image').css("display","block");
   output.src = reader.result;
  }
  reader.readAsDataURL(event.target.files[0]);
}

</script>
<script>
    $(document).ready(function(){
        $('.remove_preview').click(function(){
            $('.add-image').css("display","none");
        })
    })
</script>
@endsection
