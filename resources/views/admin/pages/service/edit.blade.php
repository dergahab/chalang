@extends('admin.layouts.main')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <a href="{{ route('admin.service.index') }}" class="btn btn-primary mb-3">
                Bütün Servislərə Qayıt
            </a>
            <div class="card">
                <div class="card-body">
                    <h4 class="mt-0 header-title">Servis</h4>
                    <form class="" action="{{ route('admin.service.update', $item) }}" method="POST"  enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        @include('admin.pages.service._form')
                        <div class="form-group mb-0 mt-3">
                            <div>
                                <button type="submit" class="btn btn-success waves-effect waves-light mr-1">Düzənlə</button>
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
