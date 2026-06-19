@extends('admin.layouts.main')

@section('heading_title', 'Xidmətlər')

@section('heading_buttons')
        <a href="{{ route('admin.service.create') }}" class="btn btn-primary dropdown-toggle arrow-none waves-effect waves-light">
            <i class="fas fa-layer-group mr-2"></i> Əlavə et
        </a>
@endsection

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex align-items-center gap-2">
                            @if(request('parent'))
                                <a href="{{ route('admin.service.index') }}" class="btn btn-outline-secondary me-2">
                                    <i class="ri-arrow-left-line"></i> Geri
                                </a>
                            @endif
                            <h4 class="mt-0 header-title mb-0">Xidmətlər List {{ request('parent') ? '(Alt Xidmətlər)' : '' }}</h4>
                        </div>
                        <button id="bulk-delete-btn" class="btn btn-danger" style="display: none;" data-model="App\Models\Service">
                            <i class="ri-delete-bin-line"></i> Seçilənləri Sil (<span class="count">0</span>)
                        </button>
                    </div>
                    
                    <table class="table table-bordered" id="categories">
                        <thead>
                          <tr>
                            <th width="40">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="select-all">
                                    <label class="form-check-label" for="select-all"></label>
                                </div>
                            </th>
                            <th scope="col">ID</th>
                            <th scope="col">Ad</th>
                            @if( !Request::get('parent'))
                                <th scope="col">Alt xidmət</th>
                            @endif
                            <th>Əsas Səhifədə</th>
                            <th scope="col">Əməliyyat</th>
                          </tr>
                        </thead>
                        <tbody id="sortables">
                            @forelse ($items as $item)

                            <tr class="sortable" data-id="{{ $item->id }}">
                                <td>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input bulk-item" value="{{ $item->id }}">
                                        <label class="form-check-label"></label>
                                    </div>
                                </td>
                                <th scope="row" >{{$loop->iteration}}</th>
                                <td>{{$item->name}}</td>
                                @if( !Request::get('parent'))
                                <td><a class="btn btn-sm btn-info" href="?parent={{$item->id}}">Alt servis ({{$item->children()->count()}})</a></td>
                                @endif
                                <td>@include('admin.pages.service.in_main')</td>
                                <td>@include('admin.pages.service.table_actions')</td>
                              </tr>

                            @empty
                              <p>Xidmət yoxdu</p>
                          @endforelse

                        </tbody>
                      </table>

                    </div>
            </div>
        </div>
        <!-- end col -->
    </div>
@endsection
@push('js_stack')
    <script src="{{ asset('admin_assets/assets/js/bulk-actions.js') }}"></script>
    <!-- Parsley js -->
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script>
        $(document).ready(function() {

        $( "#sortables" ).sortable({
              cancel: 'thead',
              stop:() => {
                  let order = {}
                  $('.sortable').each(function() {
                        order[$(this).data('id')] = $(this).index();
                    });

                    // $.post("{{ route('admin.service.index') }}", {
                    //     order:order,
                    //     token: "csrf_token()"
                    // },function(response) {
                    //     console.log(response.data);
                    // });


              }
          });
      });
    </script>
    <script>
        $(document).on('change','.in_main',function(){
            let id = $(this).data('id');

            $.get("{{route('admin.service.in_main')}}", {id:id},
                function (data) {

                });
        })
    </script>
@endpush

