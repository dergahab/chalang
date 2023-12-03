@extends('admin.layouts.main')

@section('heading_title', 'Banner')

@section('heading_buttons')
    @can('category.create')
        @if (!\App\Models\Banner::first())
            <a href="{{ route('admin.banner.create') }}"
                class="btn btn-primary dropdown-toggle arrow-none waves-effect waves-light">
                <i class="fas fa-layer-group mr-2"></i> Əlavə et
            </a>
        @endif
    @endcan
@endsection

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="mt-0 header-title">Banner List</h4>
                    @include('admin.inc.dynamic_datatable', [
                        '__datatableName' => 'banner',
                        '__datatableId' => 'datatable-category',
                    ])

                </div>
            </div>
        </div>
    @endsection
    @push('js_stack')
        <!-- Parsley js -->
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
        <script>
            $(document).ready(function() {

                $("#sortables").sortable({
                    cancel: 'thead',
                    stop: () => {
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
            $(document).on('change', '.in_main', function() {
                let id = $(this).data('id');

                $.get("{{ route('admin.service.in_main') }}", {
                        id: id
                    },
                    function(data) {

                    });
            })
        </script>
    @endpush
