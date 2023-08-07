<button class='btn btn-danger destroy' title='Sil' data-id="{{ $item->id }}"
    route="{{ route('customer-type.destroy', 'destroy') }}"><i class=' ri-delete-bin-2-line'></i></button>
<button class='btn btn-info edit' title='Düzənlə' data-id="{{ $item->id }}"><i class='fas fa-pen'></i></button>


<button class='btn btn-danger destroy' title='Sil' >
    <i class=' ri-delete-bin-2-line'></i>
</button>
<form action="{{route('admin.customer-type.destroy',['customer-type' => $item->id])}}" method="POST" id="deleteForm">
    @method('DELTE')
    @csrf
</form>
