<style>
    /* Breadcrumb Component Styles */
    .breadcrumb-list {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        padding: 0;
        margin: 0;
        list-style: none;
        gap: 8px;
    }
    .breadcrumb-list li {
        display: inline-flex;
        align-items: center;
        font-size: 14px;
        font-weight: 500;
        color: rgba(255, 255, 255, 0.6); /* Default for dark/glass theme */
    }
    .breadcrumb-list li a {
        color: #fff;
        text-decoration: none;
        transition: color 0.3s ease;
    }
    .breadcrumb-list li a:hover {
        color: var(--color-primary);
    }
    .breadcrumb-list li.separator {
        margin: 0 4px;
        opacity: 0.5;
        font-size: 12px;
    }
    .breadcrumb-list li.active {
        color: var(--color-primary); /* Active item color */
        font-weight: 600;
    }
    /* Adjustments for light theme pages if needed, can use .bg-color-light parent check */
    .bg-color-light .breadcrumb-list li {
        color: var(--color-text-sub);
    }
    .bg-color-light .breadcrumb-list li a {
        color: var(--color-text-main);
    }
</style>
<div class="breadcrum-area breadcrumb-banner">
    <div class="container">
        <div class="section-heading heading-left">
            <h1 class="title h2">{{ $title }}</h1>
            <ul class="breadcrumb-list breadcrumb-style-1" itemscope itemtype="https://schema.org/BreadcrumbList">
                <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <a itemprop="item" href="{{ request()->is('preview*') ? route('preview') : route('/') }}">
                        <span itemprop="name">{{ __('front.home') }}</span>
                    </a>
                    <meta itemprop="position" content="1" />
                </li>
                <li class="separator">/</li>
                @php $position = 2; @endphp
                @foreach($items as $label => $url)
                    @if(!$loop->last)
                        <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                            <a itemprop="item" href="{{ $url }}">
                                <span itemprop="name">{{ $label }}</span>
                            </a>
                            <meta itemprop="position" content="{{ $position++ }}" />
                        </li>
                        <li class="separator">/</li>
                    @else
                        <li class="active" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                            <span itemprop="name">{{ $label }}</span>
                            <meta itemprop="position" content="{{ $position++ }}" />
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
    <ul class="shape-group-8 list-unstyled">
        <li class="shape shape-1 sal-animate" data-sal="slide-right" data-sal-duration="500" data-sal-delay="100">
            <img src="{{ asset('assets/media/others/bubble-9.png') }}" alt="Bubble">
        </li>
        <li class="shape shape-2 sal-animate" data-sal="slide-left" data-sal-duration="500" data-sal-delay="200">
            <img src="{{ asset('assets/media/others/bubble-21.png') }}" alt="Bubble">
        </li>
        <li class="shape shape-3 sal-animate" data-sal="slide-up" data-sal-duration="500" data-sal-delay="300">
            <img src="{{ asset('assets/media/others/line-4.png') }}" alt="Line">
        </li>
    </ul>
</div>
