@extends('admin.layouts.main')

@section('heading_title', 'Rollar')

@section('heading_buttons')
    @can('role.create')
    <a href="{{ route('role.create') }}" class="btn btn-primary waves-effect waves-light"><i class="ri-add-line align-middle me-1"></i> Yeni Rol</a>
    @endcan
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Ad</th>
                                <th>İcazə sayı</th>
                                <th>Yaradılma tarixi</th>
                                <th>Əməliyyatlar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->title }}</td>
                                <td><span class="badge bg-info">{{ $item->permissions_count }}</span></td>
                                <td>{{ $item->created_at->format('d.m.Y H:i') }}</td>
                                <td>
                                    @can('role.edit')
                                    <a href="{{ route('role.edit', $item->id) }}" class="btn btn-sm btn-soft-primary"><i class="ri-pencil-line"></i></a>
                                    @endcan
                                    
                                    @if($item->name !== 'super-admin')
                                        @can('role.destroy')
                                        <form action="{{ route('role.destroy', $item->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Bu rolu silmək istədiyinizə əminsiniz?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-soft-danger"><i class="ri-delete-bin-line"></i></button>
                                        </form>
                                        @endcan
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $items->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
