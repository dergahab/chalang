<a href="{{ route('admin.faq.edit', $item->id) }}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
<form action="{{ route('admin.faq.destroy', $item->id) }}" method="POST" class="d-inline-block">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Silmək istədiyinizə əminsiniz?')"><i class="fas fa-trash"></i></button>
</form>
