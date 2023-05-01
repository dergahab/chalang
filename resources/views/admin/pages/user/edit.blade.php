@extends('admin.layouts.main')

@section('heading_title', 'User')

@section('heading_breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('user.index') }}">Əməkdaşlar</a></li>
    <li class="breadcrumb-item active">Əməkdaş: {{ $item->full_name }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="mt-0 header-title">Əməkdaş</h4>
                    <form class="" action="{{ route('user.update', $item) }}" method="POST">
                        @csrf
                        @method('PUT')
                        @include('admin.pages.user.__form')
                        <div class="form-group mb-0 pt-3">
                            <div>
                                <button type="submit" class="btn btn-success waves-effect waves-light mr-1">Düzəliş et</button>
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
