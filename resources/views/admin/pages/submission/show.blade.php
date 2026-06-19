@extends('admin.layouts.main')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="mt-0 header-title">Submission Detalları</h4>
                    
                    <table class="table table-bordered mt-4">
                        <tr>
                            <th>ID</th>
                            <td>{{ $item->id }}</td>
                        </tr>
                        <tr>
                            <th>Növ</th>
                            <td>{{ $item->type }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>{{ $item->status }}</td>
                        </tr>
                        <tr>
                            <th>IP Address</th>
                            <td>{{ $item->ip_address }}</td>
                        </tr>
                        <tr>
                            <th>Tarix</th>
                            <td>{{ $item->created_at }}</td>
                        </tr>
                        <tr>
                            <th>Məlumatlar</th>
                            <td>
                                <ul>
                                @if($item->data)
                                    @foreach($item->data as $key => $value)
                                        <li><strong>{{ $key }}:</strong> {{ is_array($value) ? json_encode($value) : $value }}</li>
                                    @endforeach
                                @endif
                                </ul>
                            </td>
                        </tr>
                    </table>

                    <div class="mt-3">
                        <a href="{{ route('admin.submission.index') }}" class="btn btn-secondary">Geri</a>
                        <form action="{{ route('admin.submission.destroy', $item->id) }}" method="POST" class="d-inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Silmək istədiyinizə əminsiniz?')">Sil</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
