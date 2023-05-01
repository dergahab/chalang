<button class='btn btn-danger destroy' title='Sil' data-id="{{ $item->id }}"
    route="{{ route('task.destroy', 'destroy') }}"><i class=' ri-delete-bin-2-line'></i></button>
<button class='btn btn-warning show-deatil' title='Bax' data-id="{{ $item->id }}"><i class='fas fa-eye'></i></button>
