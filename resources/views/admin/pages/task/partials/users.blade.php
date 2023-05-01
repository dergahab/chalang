@foreach ($item->users as $user)
    <a href="javascript: void(0);" class="avatar-group-item" style="margin-left:0px !important" data-img="avatar-3.jpg"
        data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="{{ $user->full_name }}">
        <img src="{{ asset($user->image) }}" alt="" class="rounded-circle avatar-xxs">
    </a>
@endforeach
