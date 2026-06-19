@extends('admin.layouts.main')
@section('heading_title', 'Pricing Plans')

@section('heading_buttons')
        <a href="{{route('admin.pricing-plan.create')}}" type="button"  class="btn btn-primary float-right arrow-none waves-effect waves-light create">
            <i class="fas fa-plus mr-2"></i> Əlavə et
        </a>
@endsection
@section('content')
<div class="row">

    <div class="col-lg-12">
        <div class="card glass-card">
            
            <div class="card-body p-0">

                @include('admin.inc.dynamic_datatable', [
                    '__datatableName' => 'pricing-plan',
                    '__datatableId' => 'pricing-plan',
                    '__table_class' => 'table table-hover table-nowrap align-middle mb-0'
                ])
            </div>
    </div>
    <!-- Styles moved to datatables-dark.css -->
</div>
@endsection
@push('js_stack')
<script>
    $(document).on('change','.is_active',function(){
        let id = $(this).data('id');

        $.get("{{route('admin.pricing-plan.is_active')}}", {id:id},
            function (data) {

            });
    })
</script>
@endpush
