@extends('admin.layouts.main')
@section('heading_title', 'Submissions')

@section('content')
<div class="row">

    <div class="col-lg-12">
        <div class="card">

            <div class="card-body">

                @include('admin.inc.dynamic_datatable', [
                    '__datatableName' => 'submission',
                    '__datatableId' => 'submission',
                ])
            </div>
    </div>

</div>
@endsection
