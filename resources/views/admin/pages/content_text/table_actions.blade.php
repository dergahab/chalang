<div class="manage">
    @can('content-text.edit')
    <a class="btn btn-success" href="{{ route('admin.content-text.edit', $item) }}" data-toggle="tooltip" data-placement="top" title="Məlumata düzəliş et">
        <i class="fas fa-edit"></i>
    </a>
    @endcan

    

</div>