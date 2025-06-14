@extends('admin.layouts.main')

@section('heading_title', 'Xidmətlər')

@section('heading_buttons')
        <a href="{{ route('admin.step.create') }}" class="btn btn-primary dropdown-toggle arrow-none waves-effect waves-light">
            <i class="fas fa-layer-group mr-2"></i> Əlavə et
        </a>
@endsection

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="mt-0 header-title">Xidmətlər List</h4>
                    {{-- @include('admin.inc.dynamic_datatable', ['__datatableName' => 'category', '__datatableId' => 'datatable-category']) --}}
                    <table class="table table-bordered" id="categories">
                        <thead>
                          <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Step</th>
                            <th scope="col">Title</th>
                            <th scope="col">Əməliyyat</th>
                          </tr>
                        </thead>
                        <tbody id="sortables">
                            @forelse ($items as $item)

                            <tr class="sortable" data-id="{{ $item->id }}">
                                <th scope="row" >{{$loop->iteration}}</th>
                                <td>{{$item->step}}</td>
                                <td>{{$item->title}}</td>
                                <td>@include('admin.pages.step.table_actions')</td>
                              </tr>

                            @empty
                              <p>Step yoxdu</p>
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

