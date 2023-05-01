@if (Auth::user()->hasAnyRole(['admin', 'super-admin']))
<a class="btn btn-success" href="{{ route('user.edit', $item) }}" data-toggle="tooltip" data-placement="top" title="Məlumata düzəliş et">
    <i class="fas fa-edit"></i>
</a>
    <button data-delete-id="{{ $item->id . 'delForm' }}" type="button" class="btn btn-danger delete-button"
        data-toggle="tooltip" data-placement="top" title="Məlumatı sil">
        <i class="fas fa-trash"></i>
    </button>
    <form action="{{ route('user.destroy', $item->id) }}" id="{{ $item->id . 'delForm' }}" method="POST">
        @method('DELETE')
        @csrf
    </form>
@endif
