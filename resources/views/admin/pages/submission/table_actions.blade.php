<a href="{{ route('admin.submission.show', $id) }}" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
<form action="{{ route('admin.submission.destroy', $id) }}" method="POST" class="d-inline-block">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Silmək istədiyinizə əminsiniz?')"><i class="fas fa-trash"></i></button>
</form>
