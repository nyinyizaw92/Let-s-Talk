@extends('layouts.app')

@section('content')
@include('partials.navbar.secondnav')
<post-detail :postdetail="{{$post_detail}}" :user = {{$user}} :comments="{{$comments}}"></post-detail>
@endsection
@section('scripts')
<script>

$(document).ready(function(){
        $('.edit-btn').click(function(){
        var id = $(this).data('id');
            $('#'+id+'').toggle();

            $(".close").click(function(){
                $('#'+id+'').hide();
            })
        });

        $('.reply-img').click(function(){
            var id = $(this).data('id');
            $('.'+id+'').toggle();
        });

        $('.preview_image').change(function(e){
        var image_id = $(this).data('id');
        console.log(image_id);

        var reader = new FileReader();
        reader.onload = function()
        {        
            var output = document.getElementById('output_image'+image_id);
            $('#showimage'+image_id+'').css("display","block");
            output.src = reader.result;
        }
            reader.readAsDataURL(e.target.files[0]);
        
        })

        $('.preview_reply_image').change(function(e){
        var image_id = $(this).data('id');
        console.log(image_id);

        var reader = new FileReader();
        reader.onload = function()
        {        
            var output = document.getElementById('output_reply_image'+image_id);
            $('#show_reply_image'+image_id+'').css("display","block");
            output.src = reader.result;
        }
            reader.readAsDataURL(e.target.files[0]);
        
        })
    });
    
</script>
{{-- <script>
function loadPreview(input) {
   // id = id || '#preview_img';
    if (input.files && input.files[0]) {

        var image_holder = $("#preview_img");
        image_holder.empty();

        var reader = new FileReader();

        reader.onload = function (e) {
            // $(id)
            //         .attr('src', e.target.result)
            //         .width(200)
            //         .height(150);
             $("<img />", {
                    "src": e.target.result,
                    "class": "thumb-image"
                }).appendTo(image_holder);
        };
         image_holder.show();

        reader.readAsDataURL(input.files[0]);
    }
}
</script> --}}
@endsection
