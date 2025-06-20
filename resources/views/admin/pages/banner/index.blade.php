@extends('admin.layouts.main')

@section('heading_title', 'Banner')

@section('heading_buttons')
    @can('category.create')
        @if (!\App\Models\Banner::first())
            <a href="{{ route('admin.banner.create') }}"
                class="btn btn-primary dropdown-toggle arrow-none waves-effect waves-light">
                <i class="fas fa-layer-group mr-2"></i> Əlavə et
            </a>
        @endif
    @endcan
@endsection

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="mt-0 header-title">Banner List</h4>
                    <table class="table simple-tableS">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Image</th>  
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->title }}</td>
                                    <td><img src="{{ asset('storage/'.$item->image) }}" alt="" width="80"></td>
                                    <td>
                                        <a href="{{ route('admin.banner.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                        <form action="{{ route('admin.banner.destroy', $item->id) }}" method="POST" style="display:inline-block;">  
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
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
        <!-- Parsley js -->
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
        <script>
            $(document).ready(function() {

                $("#sortables").sortable({
                    cancel: 'thead',
                    stop: () => {
                        let order = {}
                        $('.sortable').each(function() {
                            order[$(this).data('id')] = $(this).index();
                        });

                        // $.post("{{ route('admin.service.index') }}", {
                        //     order:order,
                        //     token: "csrf_token()"
                        // },function(response) {
                        //     console.log(response.data);
                        // });  


                    }
                });
            });
        </script>
     
    @endpush
