<div class="axil-isotope-wrapper">
    <div class="isotope-button isotope-project-btn">
        <button data-filter="all" class="is-checked filter-button"><span class="filter-text">Hamısı</span></button>

        @foreach ($portfolio_categories as $pcategory)
            <button data-filter="{{ Str::slug($pcategory->name, '') }}" class="filter-button"><span
                    class="filter-text">{{ $pcategory->name }}</span></button>
        @endforeach
    </div>
    <div class="row isotope-list">
        @foreach ($portfolios as $portfolio)
            <div
                class="col-xl-3 col-lg-4 col-md-6 filter @foreach ($portfolio->pcategories as $subtitle) {{ Str::slug($subtitle->name, '') }} @endforeach">
                <div class="project-grid">
                    <div class="thumbnail">
                        <a href="{{ route('portfolio.single', $portfolio->slug) }}">
                            <img src="{{ asset(Storage::url($portfolio->image)) }}" class="image" alt="project">
                            <div class="middle">
                                <i class="fas fa-eaye"></i>
                            </div>
                        </a>
                    </div>
                    <div class="content">
                        <h5 class="title"><a
                                href="{{ route('portfolio.single', $portfolio->slug) }}">{{ $portfolio->title }}</a>
                        </h5>
                        <span class="subtitle">
                            @foreach ($portfolio->pcategories as $subtitle)
                                {{ $subtitle->name }}
                                @if (!$loop->last)
                                    ,
                                @endif
                            @endforeach
                        </span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="more-project-btn">
        <a href="{{ route('portfolio') }}" class="axil-btn btn-fill-primary">Ətraflı</a>
    </div>
</div>
