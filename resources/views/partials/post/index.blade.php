@extends('layouts.app')

@section('content')
@include('partials.navbar.secondnav')

    <div class="infinite-scroll"> 
        @foreach ($posts as $post)
            <div class="post">
                <div class="user-profile">
                    @if($post->user->profile == null)
                    <img src="/icons/icons8-male-user-50.png" alt="profile">
                    @else 
                        <img src="/profile/{{$post->user->profile}}" alt="profile">
                    @endif
                </div>
                <div class="post-list">
                    <a href="{{URL::to('post/show/'.$post->id)}}">
                        <div class="post-header">
                            <h3>{{$post->title}}</h3>
                            <p>{{substr($post->content, 0,35)}}.....</p>
                        </div>
                    </a>
                </div>
            </div>
        @endforeach
        
    </div>
    {{ $posts->links() }}


@endsection
{{-- <script
    src="https://code.jquery.com/jquery-3.4.1.js"
    integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
    crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jscroll/2.4.1/jquery.jscroll.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jscroll/2.4.1/jquery.jscroll.min.js"></script> --}}
    {{-- @section('scripts') --}}
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script> --}}
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jscroll/2.3.7/jquery.jscroll.min.js"></script>

<script>
    
        $('ul.pagination').hide();
    $(function() {
        $('.infinite-scroll').jscroll({
            autoTrigger: true,
            loadingHtml: '<img class="center-block" src="/icons/icons8-male-user-50.png" alt="Loading..." />',
            padding: 0,
            nextSelector: '.pagination li.active + li a',
            contentSelector: 'div.infinite-scroll',
            callback: function() {
                $('ul.pagination').remove();
            }
        });
    });
     
  
</script>
@endsection --}}