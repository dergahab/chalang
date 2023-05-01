<button class='btn btn-danger destroy' title='Sil' data-id="{{$item->id}}" route="{{route('admin.blog.destroy','destroy')}}"><i class=' ri-delete-bin-2-line'></i></button>
<a href="{{route('admin.blog.edit',$item->id)}}" class='btn btn-info ' title='Düzənlə' data-route="" ><i class='fas fa-pen'></i></a>
                                 