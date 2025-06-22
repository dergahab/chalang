@extends('admin.layouts.main')
@section('heading_title', 'Xidəmət kontent')

@section('heading_buttons')
        <a href="{{route('admin.service-content.create')}}" type="button"  class="btn btn-primary float-right arrow-none waves-effect waves-light create">
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
                            <th>#</th>
                            <th>Service</th>
                            <th>Başlıq</th>
                            <th>Açıqlama</th>
                            <th>Əməliyyatlar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($servicecontent as $servicecontent)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td> {{$servicecontent->service->translate('az')?->name}} </td>
                                <td>{{ $servicecontent->title }}</td>
                                <td>{!! $servicecontent->content !!}</td>
                                <td>
                                    <a href="{{ route('admin.service-content.edit', $servicecontent->id) }}" class="btn btn-sm btn-warning">Redaktə et</a>
                                    <form action="{{ route('admin.service-content.destroy', $servicecontent->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Silmək istədiyinizə əminsiniz?')">Sil</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        <!-- Daha çox sətir əlavə edə bilərsiniz -->
                    </tbody>
                </table>
            </div>
    </div>

</div>
@endsection
@push('js_stack')

@endpush
