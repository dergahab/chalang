@extends('admin.layouts.main')

@section('heading_title', 'Statik text')

@section('heading_breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.content-text.index') }}">Statik text</a></li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="mt-0 header-title">Statik text</h4>
                    <form class="" action="{{ route('admin.content-text.update', $item) }}" method="POST"  enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        @include('admin.pages.content_text.__form')
                        <div class="form-group mb-0">
                            <div>
                                <button type="submit" class="btn btn-primary waves-effect waves-light mr-1">Düzənlə</button>
                                <button type="reset" class="btn btn-danger waves-effect">İmtina</button>
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
