@extends('admin.layouts.main')

@section('heading_title', 'Home Sections')

@section('heading_breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Home Sections</li>
@endsection

@section('content')
    <div class="row">
        @foreach($sections as $section)
            <div class="col-md-6 col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="mt-0">{{ $section['title'] }}</h5>
                        @if(!empty($section['description']))
                            <p class="text-muted small mb-3">{{ $section['description'] }}</p>
                        @endif
                        <a class="btn btn-primary btn-sm"
                           href="{{ route('admin.home-sections.edit', ['section' => $section['id']]) }}">
                            Edit
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
