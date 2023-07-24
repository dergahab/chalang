@extends('admin.layouts.main')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="mt-0 header-title"> Yeni Banner</h4>
                    <form class="" action="{{ route('admin.banner.store') }}" method="POST" id="createForm" enctype="multipart/form-data">
                        @csrf
                        @include('admin.pages.banner._form')
                        <div class="form-group mb-0 mt-3">
                            <div>
                                <button type="submit" class="btn btn-success waves-effect waves-light mr-1 createBtn">Əlavə et</button>
                                <button type="reset" class="btn btn-danger waves-effect">Imtina</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->
@endsection
@push('js_stack')
<script>
$(document).on('submit', '#createForm', function(e) {
    e.preventDefault();
    
    let form = $(this);
    let url = form.attr('action');
    let data =   new FormData($(this)[0]);

    $.ajax({
        url: url,
        type: 'POST',
        data: data,
        processData: false,
        contentType: false,
        success: function(response) {
            console.log(response);
            window.location.href  = '/dashboard/banner'
        },
        error: function(errors) {

            let errorMessages = errors.responseJSON;
            for (let key in errorMessages) {
                if (errorMessages.hasOwnProperty(key)) {
                    toastr["error"](errorMessages[key]);
                }
            }
        }
    });
});

</script>
@endpush
