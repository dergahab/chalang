@extends('admin.layouts.main')
@section('heading_title', 'Blog ')
t
@section('heading_buttons')
        <a href="{{route('admin.blog.create')}}" type="button"  class="btn btn-primary float-right arrow-none waves-effect waves-light create">
            <i class="fas fa-plus mr-2"></i> Əlavə et
        </a>
@endsection
@section('content')
<div class="row">

    <div class="col-lg-12">
        <div class="card">

            <div class="card-body">

                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Başlıq</th>
                            <th>Yaradılma Tarixi</th>
                            <th>Əməliyyatlar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $blog)
                            <tr>
                                <td>{{ $blog->id }}</td>
                                <td>{{ $blog->title }}</td>
                                <td>
                                    <a href="{{ route('admin.blog.edit', $blog->id) }}" class="btn btn-sm btn-warning">Redaktə et</a>
                                    <form action="{{ route('admin.blog.destroy', $blog->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Silmək istədiyinizə əminsiniz?')">Sil</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
    </div>

</div>
@endsection
@push('js_stack')

@endpush
