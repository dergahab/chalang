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
                    <table class="table">
                        <thead>
                            <tr>
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
                                <tr>
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
        <script></script>
    @endpush
