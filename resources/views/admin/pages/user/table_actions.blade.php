@if (Auth::user()->hasAnyRole(['admin', 'super-admin']))
<a class="btn btn-success" href="{{ route('admin.user.edit', $item) }}" data-toggle="tooltip" data-placement="top" title="Məlumata düzəliş et">
    <i class="fas fa-edit"></i>
</a>
    @if ($item->id != 1)
        
    <button data-delete-id="{{ $item->id . 'delForm' }}" type="button" class="btn btn-danger delete-button"
        data-toggle="tooltip" data-placement="top" title="Məlumatı sil">
        <i class="fas fa-trash"></i>
    </button>
    <form action="{{ route('admin.user.destroy', $item->id) }}" id="{{ $item->id . 'delForm' }}" method="POST">
        @method('DELETE')
        @csrf
    </form>
        
    @endif
@endif
