@foreach ($files as $file)
<div class="border rounded border-dashed p-2" id="file-box-{{$file->id}}">
    <div class="d-flex align-items-center">
        <div class="flex-shrink-0 me-3">
            <div class="avatar-sm">
                <div class="avatar-title bg-light text-secondary rounded fs-24">
                    <i class="ri-file-ppt-2-line"></i>
                </div>
            </div>
        </div>
        <div class="flex-grow-1 overflow-hidden">
            <h5 class="fs-13 mb-1"><a href="javascript:void(0);"
                    class="text-body text-truncate d-block">{{$file->name}}</a></h5>
            <div>Tip: {{$file->type}}</div>
        </div>
        <div class="flex-shrink-0 ms-2">
            <div class="d-flex gap-1">
                <a href="{{$file->path}}" type="button"
                    class="btn btn-icon text-muted btn-sm fs-18"><i
                        class="ri-download-2-line"></i></a>

                <div class="dropdown">
                    <button class="btn btn-icon text-muted btn-sm fs-18 dropdown"
                        type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="ri-more-fill"></i>
                    </button>
                    <ul class="dropdown-menu">
                     
                        <li><a class="dropdown-item" id="file-delete"
                                data-id="{{$file->id}}" data-task="{{$item}}"
                                route="{{route('task.file_delete','destroy')}}"
                                href="javascript:void(0);"><i
                                    class="ri-delete-bin-fill align-bottom me-2 text-muted "></i>
                                Sil</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach