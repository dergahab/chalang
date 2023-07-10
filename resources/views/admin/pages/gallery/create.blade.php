@extends('admin.layouts.main')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="mt-0 header-title">Bloq Kateqoriya</h4>
                    <form class="" action="{{route('admin.file.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                       <input type="file" name="files[]" class="form-control filestyle file" multiple>
                       <input type="hidden" name="id" value="{{$id}}">
                      @if ($images->count() > 0)
                      <div class="row p-5" id="sortable">
                       
                            @foreach ($images as $image)
                            <div class="col-md-4 mt-4 sortable" data-id="{{$image->id}}">
                                <img src="{{asset('storage/' . $image->url) }}" width="300px" height="200px" style="cursor: ew-resize;">
                                <button class="btn btn-danger trash" type="button"
                                data-id="{{$image->id}}"
                                style="position: absolute;
                                right: -10px;
                                top: -16px;">
                                    <i class="fas fa-trash" ></i>
                                </button>
                            </div>
                            @endforeach
                       </div>
                      @endif
                        <div class="form-group mb-0 mt-3">
                            <div>
                                <button type="submit" class="btn btn-success waves-effect waves-light mr-1">Düzənlə</button>
                                <button type="reset" class="btn btn-danger waves-effect">Imtina</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->
@endsection

@push('js_stack')
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

    <script>
        $("#sortable").sortable({
            revert: true,
            cancel: 'thead',
              stop:() => {
                  let order = {}
                  $('.sortable').each(function() {
                        order[$(this).data('id')] = $(this).index();
                    });
                 
                    $.post("{{ route('admin.image.order') }}", {
                        order:order,
                        token: "csrf_token()"
                    },function(response) {
                        console.log(response);
                    });  
              }
        }); 
    </script>
    <script>
       $(".trash").click(function(e) {
    e.preventDefault();
    var $element = $(this); // Store the reference to the clicked element
    
    let url = "{{ route('admin.file.destroy', 'trash') }}";
    url = url.replace('trash', $(this).data('id'));

    $.ajax({
        type: "DELETE",
        url: url,
        success: function(response) {
            if (response.code == 200) {
                $element.parent().remove(); // Use the stored reference to remove the parent element
            }
        }
    });
});

    </script>
@endpush
