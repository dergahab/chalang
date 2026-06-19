@php
    $isPreview = request()->is('preview*');
@endphp
<div class="axil-isotope-wrapper">
    <div class="isotope-button isotope-project-btn" style="margin-bottom: 40px; display: flex; gap: 10px; flex-wrap: wrap; justify-content: center;">
        <button data-filter="*" class="is-checked filter-button" style="padding: 10px 24px; border-radius: 25px; transition: all 0.3s; font-weight: 500;"><span class="filter-text">{{ __('front.portfolio.all') }}</span></button>

        @foreach ($portfolio_categories as $pcategory)
            <button data-filter=".{{ Str::slug($pcategory->name, '') }}" class="filter-button" style="padding: 10px 24px; border-radius: 25px; transition: all 0.3s; font-weight: 500;"><span
                    class="filter-text">{{ $pcategory->name }}</span></button>
        @endforeach
    </div>
    <div class="row isotope-list">
        @foreach ($portfolios as $portfolio)
            @php
                $itemClasses = "col-xl-3 col-lg-4 col-md-6 project filter";
                foreach ($portfolio->pcategories as $cat) {
                    $itemClasses .= " " . Str::slug($cat->name, '');
                }
                $portfolioSlug = is_string($portfolio->slug) ? $portfolio->slug : null;
                $portfolioUrl = $portfolioSlug
                    ? route($isPreview ? 'preview.portfolio.single' : 'portfolio.single', $portfolioSlug)
                    : '#';
            @endphp
            <div class="{{ $itemClasses }}">
                <div class="project-grid glass-card" style="background: var(--card-bg); border: 1px solid var(--card-border); border-radius: 20px; overflow: hidden; box-shadow: var(--card-shadow); transition: transform 0.3s ease, box-shadow 0.3s ease; margin-bottom: 30px;">
                    <div class="thumbnail" style="position: relative; overflow: hidden;">
                        <a href="{{ $portfolioUrl }}">
                            @php
                                $img = $portfolio->image;
                                $imgUrl = null;
                                if ($img) {
                                    if (\Illuminate\Support\Str::startsWith($img, ['http://', 'https://'])) {
                                        $imgUrl = $img;
                                    } elseif (\Illuminate\Support\Facades\Storage::disk('public')->exists($img)) {
                                        $imgUrl = \Illuminate\Support\Facades\Storage::url($img);
                                    } elseif (file_exists(public_path($img))) {
                                        $imgUrl = asset($img);
                                    }
                                }
                                $imgUrl = $imgUrl ?? asset('assets/media/portfolio/portfolio-1.png');
                            @endphp
                            <img src="{{ $imgUrl }}" class="image" alt="project" style="width: 100%; height: 260px; object-fit: cover; transition: transform 0.3s;">
                            <div class="middle" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(var(--brand-primary-rgb, 75, 0, 130), 0.85); opacity: 0; transition: opacity 0.3s; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-eye" style="color: white; font-size: 2rem;"></i>
                            </div>
                        </a>
                    </div>
                    <div class="content" style="padding: 20px;">
                        <h5 class="title" style="font-family: var(--font-heading); color: var(--color-text-main); margin-bottom: 8px;"><a
                                href="{{ $portfolioUrl }}" style="color: inherit;">{{ $portfolio->title }}</a>
                        </h5>
                        <span class="subtitle" style="color: var(--color-text-sub); font-size: 0.9rem;">
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
    <div class="more-project-btn" style="text-align: center; margin-top: 40px;">
        <a href="{{ route($isPreview ? 'preview.portfolio' : 'portfolio') }}" class="btn-primary-custom">{{__('front.more')}}</a>
    </div>
</div>

<style>
    .filter-button {
        background: rgba(var(--brand-primary-rgb, 75, 0, 130), 0.05);
        color: var(--brand-primary);
        border: 1px solid var(--brand-primary) !important;
    }
    .filter-button.is-checked {
        background: var(--brand-primary) !important;
        color: white !important;
    }
    .filter-button:hover {
        background: var(--brand-primary);
        color: white;
    }
</style>
