@extends('admin.layouts.main')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="mt-0 header-title">Pricing Plan Düzənlə</h4>
                    <form class="" action="{{ route('admin.pricing-plan.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        @include('admin.pages.pricing-plan._form')
                        <div class="form-group mb-0 mt-3">
                            <div>
                                <button type="submit" class="btn btn-success waves-effect waves-light mr-1">Yadda saxla</button>
                                <a href="{{ route('admin.pricing-plan.index') }}" class="btn btn-danger waves-effect">Imtina</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
