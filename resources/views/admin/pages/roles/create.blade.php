@extends('admin.layouts.main')

@section('heading_title', 'Dashboard')

@section('heading_breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('role.index') }}">İcazələr</a></li>
    <li class="breadcrumb-item active">İcazə yarat</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="mt-0 header-title">İcazə</h4>
                    <form action="{{ route('role.store') }}" method="POST">
                        @csrf
                        @include('admin.pages.roles.__form')
                        <div class="form-group mb-0">
                            <div>
                                <button type="submit" class="btn btn-success waves-effect waves-light mr-1">Əlavə et</button>
                                <button type="reset" class="btn btn-danger waves-effect">İmtina et</button>
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
    <!-- Parsley js -->
    <script src="{{ asset('admin/plugins/parsleyjs/parsley.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('form').parsley();
        });
    </script>
@endpush
