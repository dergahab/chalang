@extends('admin.layouts.main')

@section('heading_title', 'Xidmətlər')

@section('heading_buttons')
        <a href="{{ route('admin.service.create') }}" class="btn btn-primary dropdown-toggle arrow-none waves-effect waves-light">
            <i class="fas fa-layer-group mr-2"></i> Əlavə et
        </a>
@endsection

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="mt-0 header-title">Xidmətlər List</h4>
                    {{-- @include('admin.inc.dynamic_datatable', ['__datatableName' => 'category', '__datatableId' => 'datatable-category']) --}}
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Ad</th>
                                @if(!Request::get('parent'))
                                    <th>Alt xidmət</th>
                                @endif
                                <th>Əsas Səhifədə</th>
                                <th>Əməliyyat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($items as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->name }}</td>
                                    @if(!Request::get('parent'))
                                        <td>
                                            <a class="btn btn-sm btn-info" href="?parent={{ $item->id }}">
                                                Alt servis ({{ $item->childs()->count() }})
                                            </a>
                                        </td>
                                    @endif
                                    <td>
                                        @if ($item->in_main)
                                            <i class="fas fa-check text-success"></i>
                                        @else
                                            <i class="fas fa-times text-danger"></i>
                                        @endif
                                    </td>
                                    <td>@include('admin.pages.service.table_actions')</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Xidmət yoxdu</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
            </div>
        </div>
        <!-- end col -->
    </div>
@endsection


