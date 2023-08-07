
<a href="{{route('admin.portfolio.edit',$item->id)}}" class='btn btn-info ' title='Düzənlə' data-route="" ><i class='fas fa-pen'></i></a>
                                 
<form action="{{route('admin.portfolio.destroy', ['portfolio' => $item->id])}}" method="POST" id="deleteForm">
    @method('DELTE')
    @csrf
</form>
<button class='btn btn-danger destroy' title='Sil'>
    <i class=' ri-delete-bin-2-line'></i>
</button>
