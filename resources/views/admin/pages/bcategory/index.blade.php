@extends('admin.layouts.main')
@section('heading_title', 'Blog kategoriya')

@section('heading_buttons')
        <a type="button" href="{{route('admin.bcategory.create')}}" class="btn btn-primary float-right arrow-none waves-effect waves-light ">
            <i class="fas fa-plus mr-2"></i> Əlavə et
        </a>
@endsection
@section('content')
<div class="row">

    <div class="col-lg-12">
        <div class="card">

            <div class="card-body">

                <table class="table table-bordered" id="bcategory">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Adı</th>
                            <th>Əməliyyatlar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $bcategory)
                            <tr>
                                <td>{{ $bcategory->id }}</td>
                                <td>{{ $bcategory->name }}</td>
                                <td>
                                    <a href="{{ route('admin.bcategory.edit', $bcategory->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i> Redaktə et
                                    </a>
                                    <form action="{{ route('admin.bcategory.destroy', $bcategory->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Silmək istədiyinizə əminsiniz?')">
                                            <i class="fas fa-trash"></i> Sil
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
    </div>
    <!-- end col -->
</div>
@endsection
