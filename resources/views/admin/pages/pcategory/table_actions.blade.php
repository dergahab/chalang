<a href="{{route('admin.pcategory.edit',$item->id)}}" class='btn btn-info ' title='Düzənlə' data-route="" ><i class='fas fa-pen'></i></a>

<button class='btn btn-danger destroy' title='Sil' >
    <i class=' ri-delete-bin-2-line'></i>
</button>
<form action="{{route('admin.pcategory.destroy',['pcategory' => $item->id])}}" method="POST" id="deleteForm">
    @method('DELTE')
    @csrf
</form>
