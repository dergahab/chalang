<ul class="list-unstyled vstack gap-3 mb-0">
    @foreach ($item->users as $person)

    <li id="task-peron-{{$person->id}}">
        <div class="d-flex align-items-center">
            <div class="flex-shrink-0">
                <img src="{{ asset($person->image) }}"
                    alt="" class="avatar-xs rounded-circle">
            </div>
            <div class="flex-grow-1 ms-2">
                <h6 class="mb-1"><a href="javascript:void(0);">{{$person?->full_name}}</a>
                </h6>
            </div>
            <div class="flex-shrink-0">
                <div class="dropdown">
                    <button
                        class="btn btn-icon btn-sm fs-16 text-muted dropdown"
                        type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="ri-more-fill"></i>
                    </button>
                    <ul class="dropdown-menu" style="">
                        {{-- <li><a class="dropdown-item"
                                href="javascript:void(0);"><i
                                    class="ri-eye-fill text-muted me-2 align-bottom"></i>View</a>
                        </li>
                        <li><a class="dropdown-item"
                                href="javascript:void(0);"><i
                                    class="ri-star-fill text-muted me-2 align-bottom"></i>Favourite</a>
                        </li> --}}
                        <li><a class="dropdown-item atendent_delete"
                                href="javascript:void(0);" data-id="{{$person->id}}" data-task="{{$item->id}}" route="{{route('task.atendent_delete')}}">
                                <i class="ri-delete-bin-5-fill text-muted me-2 align-bottom">
                                </i>Təhkim olunalardan çıxar</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </li>
    @endforeach

</ul>