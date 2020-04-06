<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div class="add-category">
        <a href="{{route('category.create')}}">Add Category</a>
    </div>
   @if($categories)
   <ul>
        @foreach($categories as $category)

            <li>{{$category->title}}</li>
            <div class="edit">
                <a href="{{ URL::to('category/' . $category->id . '/edit')}}">Edit</a>
            </div>
            <div class="delete">
                <form action="{{URL::to('category/'.$category->id)}}" method="POST">
                @method('DELETE')
                @csrf
                <input type="submit" value="Delete">
            </form>
            </div>
        @endforeach
   </ul>
   @endif
</body>
</html>