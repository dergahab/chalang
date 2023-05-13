
<button @if($item->childs()->count() > 0) disabled  @endif class=' btn btn-danger destroy ' title='Sil' data-id="{{$item->id}}" route="{{route('admin.service.destroy','destroy')}}"><i class=' ri-delete-bin-2-line'></i></button>
<a href="{{route('admin.service.edit',$item->id)}}" class='btn btn-info ' title='Düzənlə' data-route="" ><i class='fas fa-pen'></i></a>
                                 