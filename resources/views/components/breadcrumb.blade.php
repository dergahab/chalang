@props(['breadcrumbs' => []])

@if(count($breadcrumbs) > 0)
    <nav aria-label="breadcrumb" class="breadcrumb-container">
        <ol class="breadcrumb" itemscope itemtype="https://schema.org/BreadcrumbList">
            @foreach($breadcrumbs as $index => $breadcrumb)
                <li class="breadcrumb-item {{ $loop->last ? 'active' : '' }}" 
                    itemprop="itemListElement" 
                    itemscope 
                    itemtype="https://schema.org/ListItem"
                    {{ $loop->last ? 'aria-current="page"' : '' }}>
                    
                    @if(isset($breadcrumb['url']) && !$loop->last)
                        <a itemprop="item" href="{{ $breadcrumb['url'] }}" class="breadcrumb-link">
                            <span itemprop="name">{{ $breadcrumb['name'] }}</span>
                        </a>
                    @else
                        <span itemprop="name" class="breadcrumb-current">{{ $breadcrumb['name'] }}</span>
                    @endif
                    <meta itemprop="position" content="{{ $index + 1 }}" />
                </li>
            @endforeach
        </ol>
    </nav>

    <style>
        .breadcrumb-container {
            margin-bottom: 20px;
            font-size: 0.9rem;
        }
        .breadcrumb {
            background: transparent;
            padding: 0;
            margin: 0;
            display: flex;
            list-style: none;
            align-items: center;
            flex-wrap: wrap;
        }
        .breadcrumb-item {
            display: inline-flex;
            align-items: center;
        }
        .breadcrumb-item + .breadcrumb-item::before {
            content: "›";
            padding: 0 10px;
            color: var(--brand-secondary, #6c757d);
        }
        .breadcrumb-link {
            color: var(--brand-primary, #4b0082);
            text-decoration: none;
            transition: opacity 0.2s ease;
        }
        .breadcrumb-link:hover {
            opacity: 0.8;
            text-decoration: underline;
        }
        .breadcrumb-current {
            color: #6c757d;
        }
    </style>
@endif
