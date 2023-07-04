<button class='btn btn-danger destroy' title='Sil' data-id="{{$item->id}}" route="{{route('admin.company.destroy','destroy')}}"><i class=' ri-delete-bin-2-line'></i></button>
<button class='btn btn-info edit' title='Düzənlə' data-route="{{route('admin.tag.edit', ['tag' => $item->id])}}" ><i class='fas fa-pen'></i></button>
                                 