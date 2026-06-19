@extends('admin.layouts.main')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="mt-0 header-title">Team Member Əlavə et</h4>
                    <form class="" action="{{ route('admin.team-member.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @include('admin.pages.team-member._form')
                        <div class="form-group mb-0 mt-3">
                            <div>
                                <button type="submit" class="btn btn-success waves-effect waves-light mr-1">Yadda saxla</button>
                                <a href="{{ route('admin.team-member.index') }}" class="btn btn-danger waves-effect">Imtina</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
