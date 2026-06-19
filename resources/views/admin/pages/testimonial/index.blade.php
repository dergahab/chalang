@extends('admin.layouts.main')
@section('heading_title', 'Testimonials')

@section('heading_buttons')
        <a href="{{route('admin.testimonial.create')}}" type="button"  class="btn btn-primary float-right arrow-none waves-effect waves-light create">
            <i class="fas fa-plus mr-2"></i> Əlavə et
        </a>
@endsection
@section('content')
<div class="row">

    <div class="col-lg-12">
        <div class="card">

            <div class="card-body">

                @include('admin.inc.dynamic_datatable', [
                    '__datatableName' => 'testimonial',
                    '__datatableId' => 'testimonial',
                    '__model' => 'App\Models\Testimonial',
                ])
            </div>
    </div>

</div>
@endsection
@push('js_stack')
<script>
    $(document).on('change','.is_active',function(){
        let id = $(this).data('id');

        $.get("{{route('admin.testimonial.is_active')}}", {id:id},
            function (data) {

            });
    })
</script>
@endpush
