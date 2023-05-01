@extends('admin.layouts.main')
@section('heading_title', 'Tapşırıqlar')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card" id="tasksList">
            <div class="card-header border-0">
                <div class="d-flex align-items-center">
                    <h5 class="card-title mb-0 flex-grow-1">Tapşırığın detalları</h5>
                </div>
            </div>
           
            <!--end card-body-->
            <div class="card-body pt-1">
                @include('admin.pages.task.inc.render')

            </div>
            <!--end crd-body-->
        </div>
        <!--end card-->
    </div>
    <!--end col-->
</div>
@endsection
@include('admin.pages.task.inc.script_task_detail')
@push('js_stack')
<script>
     pageLoader(true);

     $(document).ready(function() {
        pageLoader(false);
     })
</script>
@endpush
