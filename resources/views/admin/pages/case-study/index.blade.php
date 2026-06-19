@extends('admin.layouts.main')
@section('heading_title', 'Case Studies')

@section('heading_buttons')
        <a href="{{route('admin.case-study.create')}}" type="button"  class="btn btn-primary float-right arrow-none waves-effect waves-light create">
            <i class="fas fa-plus mr-2"></i> Əlavə et
        </a>
@endsection
@section('content')
<div class="row">

    <div class="col-lg-12">
        <div class="card">

            <div class="card-body">

                @include('admin.inc.dynamic_datatable', [
                    '__datatableName' => 'case-study',
                    '__datatableId' => 'case-study',
                    '__model' => 'App\Models\CaseStudy',
                ])
            </div>
    </div>

</div>
@endsection
@push('js_stack')
<script>
    $(document).on('change','.in_main',function(){
        let id = $(this).data('id');

        $.get("{{route('admin.case-study.in_main')}}", {id:id},
            function (data) {

            });
    })
</script>
@endpush
