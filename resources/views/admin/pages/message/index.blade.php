@extends('admin.layouts.main')
@section('heading_buttons')

@endsection


@section('heading_title', 'İsmarıclar')
@section('content')

    <div class="row">
        <div class="col-lg-12">
            {{-- 
        {{ Breadcrumbs::render('user') }} --}}
        </div>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="mt-0 header-title">İsmarıclar</h4>
                        <button id="bulk-delete-btn" class="btn btn-danger" style="display: none;" data-model="App\Models\Message">
                            <i class="ri-delete-bin-line"></i> Seçilənləri Sil (<span class="count">0</span>)
                        </button>
                    </div>

                    <table class="table">
                        <thead>
                            <tr>
                                <th width="40">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="select-all">
                                        <label class="form-check-label" for="select-all"></label>
                                    </div>
                                </th>
                                <th scope="col">#</th>
                                <th scope="col">Ad Soyad</th>
                                <th scope="col">Email</th>
                                <th scope="col">Telofon</th>
                                <th scope="col">Tip</th>
                                <th scope="col">İsmarıc</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($messages as $item)
                                <tr data-id="{{ $item->id }}">
                                    <td>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input bulk-item" value="{{ $item->id }}">
                                            <label class="form-check-label"></label>
                                        </div>
                                    </td>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $item->full_name }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>{{ $item->phone }}</td>
                                    <td>{{ $item->type }}</td>
                                    <td>{{ $item->message }}</td>
                                </tr>
                            @endforeach


                        </tbody>
                    </table>
                </div>
            </div>
            <!-- end col -->

        </div>
    @endsection


    @push('js_stack')
        <script src="{{ asset('admin_assets/assets/js/bulk-actions.js') }}"></script>
        <script></script>
    @endpush
