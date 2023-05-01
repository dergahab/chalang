@foreach ($item->files as $file)
    <a href="{{ $file->path }}" target="_blanck" class="" title="{{ $file->name }}">
        <i class="fas fa-file-contract fa-2x"></i>
    </a>
@endforeach
