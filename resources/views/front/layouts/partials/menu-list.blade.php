@php
    $items = ($menuCollection ?? collect())->count() ? $menuCollection : collect($fallbackMenu ?? []);
@endphp

<ul class="{{ $listClass ?? '' }}">
    @foreach ($items as $item)
        @php
            $route = $item['route'] ?? $item['url'] ?? '#';
            $label = $item['label'] ?? $item['title'] ?? '';
            $icon = $item['icon'] ?? null;
            $href = $item['url']
                ?? (\Illuminate\Support\Facades\Route::has($route) ? route($route) : url($route));
            $active = request()->routeIs($route) || request()->is(trim($route, '/').'/*') || request()->is(trim($route, '/'));
        @endphp
        <li class="{{ $active ? 'active' : '' }}">
            <a href="{{ $href }}">
                @if ($icon)
                    <i class="{{ $icon }}"></i>
                @endif
                <span>{{ $label }}</span>
            </a>
        </li>
    @endforeach
</ul>
