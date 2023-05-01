@extends('admin.layouts.main')
@section('heading_title', 'Tapşırıqlar')

@section('heading_buttons')
    @can('position.create')
        <button type="button"  class="btn mb-3 btn-primary display-b float-right arrow-none waves-effect waves-light create">
            <i class="fas fa-plus mr-2"></i> Əlavə et
        </button>
    @endcan
@endsection
@section('content')
    @include('admin.pages.task.inc.task-statistic')
    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="tasksList">
                <div class="card-header border-0">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">Task list</h5>
                    </div>
                </div>
               
                <!--end card-body-->
                <div class="card-body pt-1">
                    @include('admin.pages.task.inc.filter')
                    <div class="table-responsive table-card mb-4">
                        @include('admin.inc.dynamic_datatable', [
                            '__datatableName' => 'task',
                            '__datatableId' => 'tasks',
                        ])

                    </div>
                </div>
                <!--end crd-body-->
            </div>
            <!--end card-->
        </div>
        <!--end col-->
    </div>
    <!--end row-->


    @include('admin.pages.task.inc.modals')
    @include('admin.pages.task.inc.task_detale')
@endsection
@push('js_stack')
<script>
     pageLoader(true);

     $(document).ready(function() {
        pageLoader(false);
     })
</script>
@endpush
