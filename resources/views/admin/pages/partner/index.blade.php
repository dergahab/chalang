@extends('admin.layouts.main')
@section('heading_title', 'Partners')

@section('heading_buttons')
        <a href="{{route('admin.partner.create')}}" type="button"  class="btn btn-primary float-right arrow-none waves-effect waves-light create">
            <i class="fas fa-plus mr-2"></i> Əlavə et
        </a>
@endsection
@section('content')
<div class="row">

    <div class="col-lg-12">
        <div class="card">

            <div class="card-body">

                @include('admin.inc.dynamic_datatable', [
                    '__datatableName' => 'partner',
                    '__datatableId' => 'partner',
                    '__model' => 'App\Models\Partner',
                ])
            </div>
    </div>

</div>
@endsection
@push('js_stack')
<script>
    $(document).on('change','.is_active',function(){
        let id = $(this).data('id');

        $.get("{{route('admin.partner.is_active')}}", {id:id},
            function (data) {

            });
    })
</script>
@endpush
