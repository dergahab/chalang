<div class="d-flex mb-4">
    <div class="flex-shrink-0">
        <img src="{{asset('admin/assets/images/users/avatar-7.jpg')}}"
            alt="" class="avatar-xs rounded-circle">
    </div>
    <div class="flex-grow-1 ms-3">
        <h5 class="fs-13"><a
                href="pages-profile.html">{{$comment->user->name}}</a> <small class="text-muted">{{ $comment->created_at}}</small></h5>
        <p class="text-muted">{{$comment->content}}</p>

    </div>
</div>
