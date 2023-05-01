{{-- <div class="modal-header">
    <h5 class="modal-title" id="detaleModalLabel">Tapşırığın detalları</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div> --}}
<div class="modal-body" id="deatil-response">
    <div class="row">
        <div class="col-md-8">
            <h3><b>{{strip_tags($item?->title)}}</b></h3>



            @if ($item?->description)
            <hr>
            <p><strong>Açıqlama:</strong> {{$item?->description}}</p>
            @endif
            <div class="row">
                <hr>
                <div class="col-md-12">
                    <div class="card-body">
                        <ul class="nav nav-tabs mb-3" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" data-bs-toggle="tab" href="#check-list-tab" role="tab"
                                    aria-selected="false" tabindex="-1">
                                    Çeklist
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link " data-bs-toggle="tab" href="#comments-tab" role="tab"
                                    aria-selected="false" tabindex="-1">
                                    Şərhlər
                                </a>
                            </li>
                            <li class="nav-item " role="presentation">
                                <a class="nav-link" data-bs-toggle="tab" href="#activity-tab" role="tab"
                                    aria-selected="false" tabindex="-1">
                                    Aktivliklər
                                </a>
                            </li>
                            <li class="nav-item " role="presentation">
                                <a class="nav-link task-users" data-bs-toggle="tab" href="#task-users" role="tab"
                                    aria-selected="false" tabindex="-1">
                                    Təhkim olunanalar
                                </a>
                            </li>
                            <li class="nav-item " role="presentation">
                                <a class="nav-link product1" data-bs-toggle="tab" href="#product1" role="tab"
                                    aria-selected="false" tabindex="-1">
                                    Fayllar
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content  text-muted">
                            <div class="tab-pane active show" id="check-list-tab" role="tabpanel">
                                <div data-simplebar="init" class="px-3 mx-n3 mb-2">
                                    <div class="simplebar-wrapper" style="margin: 0px -16px;">
                                        {{-- <div class="simplebar-height-auto-observer-wrapper">
                                            <div class="simplebar-height-auto-observer"></div>
                                        </div> --}}
                                        <div class="simplebar-mask">
                                            <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                                                <div class="simplebar-content-wrapper" id="scrollable" tabindex="0"
                                                    role="region" aria-label="scrollable content"
                                                    style="height: 100%; overflow: hidden scroll;">
                                                    @if($item->checklist->count())
                                                    <div class="d-flex align-items-center pb-2 pt-4" style="padding: 0px 16px;">
                                                        <div class="flex-grow-1">
                                                            <div class="progress animated-progress custom-progress progress-label">
                                                                <div class="progress-bar bg-primary" role="progressbar" style="width: {{$item->checklist[0]->prograce}}%" aria-valuenow="{{$item->checklist[0]->prograce}}" aria-valuemin="0" aria-valuemax="100"><div class="label">{{$item->checklist[0]->prograce}}%</div></div>
                                                            </div>
                                                        </div>
                                                       
                                                    </div>
                                                    <div class="d-flex align-items-center pb-2 pt-1" style="padding: 0px 16px;">
                                                        <div class="flex-grow-1">
                                                            <input  class="form-check-input "  type="checkbox" id="complated"> 
                                                            <label class="form-check-label" for="complated"><strong>Tamamlanmışları gizlə</strong></label>

                                                        </div>
                                                    </div>
                                                    @endif
                                                    <div class="simplebar-content" style="padding: 0px 16px;"
                                                        id="check-list-box">
                                                        
                                                      
                                                        <ul class="list-group list-group-flush" id="checklist-list">
                                                            @include('admin.pages.task.inc.render_checklist');
                                                          </ul>
                                                           @if(!$item->isCloseToDeadline()) 
                                                          <div class="row">
                                                            <form class="mt-4" id="todo-form">
                                                                <input type="hidden" name="task_id" id="task-id" value="{{$item->id}}">
                                                                @csrf
                                                                <div class="row g-3">
                                                                    <div class="col-lg-12">
                                                                       <input type="text" class="form-control bg-light border-light" name="content" placeholder="Yoxlama siyahısı əlavə et" required>
                                                                    </div>
                                                                    <!--end col-->
                                                                   
                                                                        <div class="col-12 text-start">
                                                                            <a href="javascript:void(0);" id="chechlist-add" class="btn  btn-sm btn-success">Əlavə et</a>
                                                                            <a href="javascript:void(0);" type="reset" class="btn  btn-sm btn-danger">İmtina et</a>
                                                                        </div>
                                                                   
                                                                </div>
                                                                <!--end row-->
                                                            </form>
                                                        </div>
                                                        @endif
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <div class="simplebar-placeholder" style="width: auto; height: 404px;">
                                        </div>
                                        
                                    </div>
                                
                                </div>
                            
                               
                            </div>
                            <div class="tab-pane" id="comments-tab" role="tabpanel">
                                <div data-simplebar="init" class="px-3 mx-n3 mb-2">
                                    <div class="simplebar-wrapper" style="margin: 0px -16px;">
                                        <div class="simplebar-height-auto-observer-wrapper">
                                            <div class="simplebar-height-auto-observer"></div>
                                        </div>
                                        <div class="simplebar-mask">
                                            <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                                                <div class="simplebar-content-wrapper" id="scrollable" tabindex="0"
                                                    role="region" aria-label="scrollable content"
                                                    style="height: 100%; overflow: hidden scroll;">
                                                    <div class="simplebar-content" style="padding: 0px 16px;"
                                                        id="comments-box">
                                                        @foreach($item->commnets as $comment)
                                                        <div class="d-flex mb-4">
                                                            <div class="flex-shrink-0">
                                                                <img src="{{asset($comment->user->image)}}"
                                                                    alt="" class="avatar-xs rounded-circle">
                                                            </div>
                                                            <div class="flex-grow-1 ms-3">
                                                                <h5 class="fs-13"><a
                                                                        href="pages-profile.html">{{$comment->user->full_name}}</a>
                                                                    <small
                                                                        class="text-muted">{{$comment->created_at}}</small>
                                                                </h5>
                                                                <p class="text-muted">{{$comment->content}}</p>

                                                            </div>
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="simplebar-placeholder" style="width: auto; height: 350px;">
                                        </div>
                                    </div>
                                    <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
                                        <div class="simplebar-scrollbar" style="width: 0px; display: none;">
                                        </div>
                                    </div>
                                    <div class="simplebar-track simplebar-vertical" style="visibility: visible;">
                                        <div class="simplebar-scrollbar"
                                            style="height: 449px; transform: translate3d(0px, 0px, 0px); display: block;">
                                        </div>
                                    </div>
                                </div>
                                <form class="mt-4" id="comment-form">
                                    <div class="row g-3">
                                        <div class="col-lg-12">
                                            <label for="exampleFormControlTextarea1" class="form-label">Şərh yaz</label>
                                            <textarea class="form-control bg-light border-light" id="coment-text"
                                                id="exampleFormControlTextarea1" rows="3"
                                                placeholder="Şərh yaz..."></textarea>
                                        </div>
                                        <!--end col-->
                                        <div class="col-12 text-end">
                                            <a href="javascript:void(0);" id="comment" class="btn btn-success">Şərh
                                                yaz</a>
                                        </div>
                                    </div>
                                    <!--end row-->
                                </form>
                                <input type="hidden" id="task-id" value="{{$item->id}}">
                            </div>
                            <div class="tab-pane" id="activity-tab" role="tabpanel">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Activities</h5>
                                        <div class="acitivity-timeline py-3">
                                            @foreach ($item->activities as $activity)
                                                
                                           
                                            <div class="acitivity-item d-flex">
                                                <div class="flex-shrink-0">
                                                    <img src="{{asset($activity->user->image)}}" alt=""
                                                        class="avatar-xs rounded-circle acitivity-avatar" />
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h6 class="mb-1">{{$activity->full_name}}<span
                                                            class="badge bg-soft-primary text-primary align-middle">Yeni</span>
                                                    </h6>
                                                    <small class="mb-0 text-muted">{{$activity->date}} {{$activity->tile}}</small>
                                                    <p class="text-muted mb-2">{{$activity->action}}
                                                        {{-- @if ($activity->other_data->count() > 0) --}}
                                                        @foreach (json_decode($activity->other_data,true) as $other_data)
                                                        <ul>
                                                            <li><a href="{{$other_data['path']}}"></a>{{$other_data['name']}}</li>
                                                           
                                                        </ul>
                                                        @endforeach
                                                     
                                                        {{-- @endif --}}
                                                    </p>
                                                </div>
                                            </div>
                                            @endforeach
                                            {{-- <div class="acitivity-item py-3 d-flex">
                                                <div class="flex-shrink-0 avatar-xs acitivity-avatar">
                                                    <div
                                                        class="avatar-title bg-soft-success text-success rounded-circle">
                                                        D
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h6 class="mb-1">{{$activity->full_name}}<span
                                                        class="badge bg-soft-primary text-primary align-middle">Yeni</span>
                                                     </h6>
                                                    <small class="mb-0 text-muted">Dünən 01.10.2023 14:00:58</small>
                                                    <p class="text-muted mb-2">
                                                        <i class="ri-file-text-line align-middle ms-2"></i>
                                                        Bu tapşırıqa iki qoşma əlavə etdi
                                                   
                                                    </p>
                                                </div>
                                            </div> --}}
                                        </div>
                                    </div>
                                    <!--end card-body-->
                                </div>
                            </div>
                            <div class="tab-pane task_users" id="task-users" role="tabpanel">
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
                                                        @if(!$item->isCloseToDeadline()) 
                                                        <li><a class="dropdown-item atendent_delete"
                                                                href="javascript:void(0);" data-id="{{$person->id}}" data-task="{{$item->id}}" route="{{route('task.atendent_delete')}}">
                                                                <i class="ri-delete-bin-5-fill text-muted me-2 align-bottom">
                                                                </i>Təhkim olunalardan çıxar</a>
                                                        </li>
                                                        @endif
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    @endforeach
                               
                                </ul>
                            </div>
                            <div class="tab-pane" id="product1" role="tabpanel">
                                <div class="vstack gap-2" id="task-files">
                                    @foreach ($item->files as $file)
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
                                                    <a href="{{$file->path}}" type="button" target="_blank"
                                                        class="btn btn-icon text-muted btn-sm fs-18"><i
                                                            class="ri-download-2-line"></i></a>

                                                    <div class="dropdown">
                                                        <button class="btn btn-icon text-muted btn-sm fs-18 dropdown"
                                                            type="button" data-bs-toggle="dropdown"
                                                            aria-expanded="false">
                                                            <i class="ri-more-fill"></i>
                                                        </button>
                                                        @if(!$item->isCloseToDeadline()) 
                                                        <ul class="dropdown-menu">
                                                            {{-- <li><a class="dropdown-item"
                                                                    href="javascript:void(0);"><i
                                                                        class="ri-pencil-fill align-bottom me-2 text-muted"></i>
                                                                    Rename</a></li> --}}
                                                                    @if(!$item->isCloseToDeadline()) 
                                                                        <li  ><a  class="dropdown-item" id="file-delete"
                                                                            data-id="{{$file->id}}" data-task="{{$item->id}}"
                                                                            route="{{route('task.file_delete','destroy')}}"
                                                                            href="javascript:void(0);"><i
                                                                                class="ri-delete-bin-fill align-bottom me-2 text-muted "></i>
                                                                            Sil</a>
                                                                        </li>
                                                                    @endif
                                                        </ul>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="row">
                <div class="col-md-12">
                    <div class="card-body">
                        <div class="d-flex mb-4 align-items-center">
                            <div class="flex-shrink-0">
                                <img src="{{asset($item->user?->image)}}" alt="" class="rounded-circle avatar-md">
                            </div>
                            <div class="flex-grow-1 ms-2">
                                <h5 class="card-title mb-1">{{$item->user?->full_name}}</h5>
                                {{-- <p class="text-muted mb-0">Design</p> --}}
                                {{-- <a href="#" class="badge badge-outline-primary" style="color:{{$item->status->color}}">{{$item->status->name}}</a>
                                --}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                       
                            <div class="table-card">
                                <input type="hidden" id="task_id" value="{{$item->id}}">
                                <ul class="list-group list-group-flush ">
                                    <li class="list-group-item ">
                                        <label for="statuses"><strong>Status</strong></label>
                                        <select class="form-control" name="status_id" @if($item->isCloseToDeadline()) disabled @endif  id="statuses" >
                                        <option value="">Vaciblik</option>
                                        @foreach ($statuses as $status)
                                           <option value="{{$status->id}}" @if ($item->status_id == $status->id) selected        @endif>{{$status->name}}</option>                                  
                                        @endforeach
                                      
                                    </select>
                                    </li>
                                    <li class="list-group-item">
                                            <div class="btn-group dropend d-block">
                                                <button data-bs-toggle="dropdown" @if($item->isCloseToDeadline()) disabled @endif aria-expanded="false" type="button" class="btn btn-primary  btn-label btn-block waves-effect right waves-light">
                                                    <i class="ri-user-add-fill label-icon align-middle fs-16 ms-2"></i>Təhkim et
                                                </button>
                                                <ul class="dropdown-menu p-1 " id="myUL">
                                                    <input type="text" class="form-control" id="myInput"
                                                        onkeyup="myFunction()" placeholder="Personal axdar..."
                                                        title="Type in a name">
                                                    @foreach($users as $user)

                                                    @if (in_array($user->id,$item->user_ids))
                                                    @continue
                                                    @endif
                                                    <li data-user="{{$user->id}}" data-task="{{$item->id}}" class="assine-user @if ($loop->iteration == 5) d-none @endif" style="cursor: pointer">
                                                        <div class="dropdown-item">
                                                            <img src="{{ asset($user->image) }}" alt=""
                                                                class="rounded-circle avatar-xs">
                                                            <span class="fullname">{{$user->full_name }}</span>
                                                        </div>
                                                    </li>
                                                    @endforeach
                                                    @if ($user->count > 5)
                                                    <li  class="" style="cursor: pointer">
                                                        <div class="dropdown-item">
                                                            
                                                            <span class="fullname">Personal 5+</span>
                                                        </div>
                                                    </li>
                                                    @endif
                                                </ul>
                                            </div>
                                    </li>
                                   @if($item->customer)
                                    <li class="list-group-item">
                                        <b>Müştəri:</b> {{($item->customer->fullname)}}
                                    </li>
                                   @endif
                                    <li class="list-group-item">
                                        <b>Start tarixi:</b> {{$item->start}}
                                    </li>
                                    <li class="list-group-item"><b>Son Möhlət:</b> {{$item->deadline}} {!!$item->son!!}</li>
                                    <li class="list-group-item">
                                        <b>Prioritet:</b>
                                        <span class="badge badge-label bg-{{ $item->priority->color }}"><i
                                                class="mdi mdi-circle-medium"></i> {{ $item->priority->name }}</span>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Status:</b>
                                        <span class="badge badge-label bg-{{ $item->status->color }}"><i
                                                class="mdi mdi-circle-medium"></i> {{ $item->status->name }}</span>
                                    </li>
                                    <li class="list-group-item">
                                        <button type="button" @if($item->isCloseToDeadline()) disabled @endif  class="btn btn-primary btn-label btn-block waves-effect right waves-light add-files" >
                                            <i class="las la-paperclip label-icon align-middle fs-16 ms-2"></i> Qoşma əlavə edin
                                        </button>
                                        <input type="file" name="file[]"  style="display: none" data-task="{{$item->id}}" id="file-input" multiple>
                                        <input type="hidden" value="{{$item->id}}" >
                                    </li>
                                </ul>
                                <!--end table-->
                            </div>
                        </div>
                    </div>
                </div>
               
            </div>
        </div>
    </div>
  
</div>
<div class="modal-footer border-top">
    <button type="button"  class="btn btn-outline-secondary waves-effect waves-light" data-bs-dismiss="modal"> <i
            class="fas fa-x"></i> Bağla </button>
            @can('task.edit')
    <button class="btn btn-outline-secondary waves-effect waves-light edit" @if($item->isCloseToDeadline()) disabled @endif  title='Düzənlə' data-id="{{ $item->id }}"
        data-bs-dismiss="modal"> <i class="fas fa-pen"></i> Düzəliş et </button>
        @endcan
        @can('task.destroy')
        <button class='btn btn-outline-danger waves-effect waves-light destroy' @if($item->isCloseToDeadline()) disabled @endif  title='Sil' data-id="{{ $item->id }}"
            route="{{ route('task.destroy', 'destroy') }}"><i class=' ri-delete-bin-2-line'></i> Sil</button>
        @endcan
</div>