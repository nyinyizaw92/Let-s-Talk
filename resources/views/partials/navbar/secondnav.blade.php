<div class="second-nav">
    <div class="nav-list">
        <ul>
            <li>
                <a href="/">Lastest Posts</a>
            </li>
            <li>
                <a href="{{URL::to('post/index')}}">All Posts</a>
            </li>
            {{-- <li>
                <a href="#">Your Posts</a>
            </li> --}}
            <li>
            <a href="{{route('post.create')}}">Add Post</a>
            </li>
        </ul>
    </div>
</div>