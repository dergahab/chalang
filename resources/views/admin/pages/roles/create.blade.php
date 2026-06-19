@extends('admin.layouts.main')

@section('heading_title', 'Yeni Rol')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('role.store') }}" method="POST">
                        @csrf
                        @include('admin.pages.roles.__form')
                        <div class="mt-4">
                            <button type="submit" class="btn btn-success waves-effect waves-light me-1">Yadda saxla</button>
                            <a href="{{ route('role.index') }}" class="btn btn-secondary waves-effect">Geri</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
