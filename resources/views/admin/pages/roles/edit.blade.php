@extends('admin.layouts.main')

@section('heading_title', 'Dashboard')

@section('heading_breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('role.index') }}">Roles</a></li>
    <li class="breadcrumb-item active">Role: {{ $item->title }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="mt-0 header-title">Role</h4>
                    <form class="" action="{{ route('role.update', $item) }}" method="POST">
                        @csrf
                        @method('PUT')
                        @include('admin.pages.roles.__form')
                        <div class="form-group mb-0">
                            <div>
                                <button type="submit" class="btn btn-primary waves-effect waves-light mr-1">Submit</button>
                                <button type="reset" class="btn btn-secondary waves-effect">Cancel</button>
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
