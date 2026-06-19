@props(['diff'])

<ul class="list-unstyled mb-0 ms-2 border-start pl-2" style="border-color: rgba(255,255,255,0.1); padding-left: 10px;">
    @foreach($diff as $key => $item)
        <li class="mb-1">
            @if($item['status'] === 'recursive')
                <div class="d-flex align-items-center gap-1">
                    <i class="ri-folder-open-line text-info opacity-75"></i>
                    <span class="font-monospace fw-bold text-muted">{{ $key }}:</span>
                </div>
                <x-activity-log.diff-tree :diff="$item['children']" />
            @elseif($item['status'] === 'modified')
                 <div class="d-flex flex-wrap gap-1 align-items-center font-monospace fs-11">
                    <span class="fw-bold text-muted">{{ $key }}:</span>
                    <span class="text-danger text-decoration-line-through bg-soft-danger px-1 rounded">{{ is_array($item['old']) ? json_encode($item['old']) : $item['old'] }}</span>
                    <i class="ri-arrow-right-line text-muted opacity-50" style="font-size: 10px;"></i>
                    <span class="text-success bg-soft-success px-1 rounded">{{ is_array($item['new']) ? json_encode($item['new']) : $item['new'] }}</span>
                </div>
            @elseif($item['status'] === 'added')
                <div class="d-flex align-items-center gap-1 font-monospace fs-11 text-success">
                    <span class="fw-bold opacity-75">{{ $key }}:</span>
                    <span class="bg-soft-success px-1 rounded">{{ is_array($item['new']) ? json_encode($item['new']) : $item['new'] }}</span>
                    <i class="ri-add-circle-line" title="Added"></i>
                </div>
            @elseif($item['status'] === 'removed')
                <div class="d-flex align-items-center gap-1 font-monospace fs-11 text-danger">
                    <span class="fw-bold opacity-75">{{ $key }}:</span>
                    <span class="text-decoration-line-through bg-soft-danger px-1 rounded">{{ is_array($item['old']) ? json_encode($item['old']) : $item['old'] }}</span>
                    <i class="ri-subtract-line" title="Removed"></i>
                </div>
            @endif
        </li>
    @endforeach
</ul>
