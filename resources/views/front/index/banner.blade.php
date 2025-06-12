<section class="banner banner-style-4">
    <div class="container">
        <div class="banner-content">
            <h1 class="title" data-sal="slide-up" data-sal-duration="1000" data-sal-delay="100">{{ $banner?->title ?? '' }}</h1>
            <p data-sal="slide-up" data-sal-duration="1000">{!! $banner?->content ?? '' !!}</p>
            <div data-sal="slide-up" data-sal-duration="1000" data-sal-delay="200">
                @if($banner?->url)
                      <a href="{{ $banner?->url }}" class="axil-btn btn-fill-primary btn-large">{{ __('Contact') }}</a>
                @endif
            </div>
        </div>
        <div class="banner-thumbnail">
            <div class="large-thumb" data-sal="slide-left" data-sal-duration="800" data-sal-delay="400">
                <img class="paralax-image" src="{{ $banner?->image ? asset('storage/' . $banner->image) : '' }}" alt="Shape">
            </div>
        </div>
        <div class="banner-social" data-sal="slide-up" data-sal-duration="800">
            <div class="border-line"></div>
            <ul class="list-unstyled social-icon">
                @foreach ($socialmedia ?? [] as $media) 
                    <li><a href="{{ $media?->link ?? '#' }}"><i class="{{ $media?->icon ?? '' }}"></i> {{ $media?->name ?? '' }}</a></li>
                @endforeach
            </ul>
        </div>
    </div>

    <ul class="list-unstyled shape-group-19">
        <li class="shape shape-1" data-sal="slide-down" data-sal-duration="500" data-sal-delay="100">
            <img src="assets/media/others/bubble-29.png" alt="Bubble">
        </li>
        <li class="shape shape-2" data-sal="slide-left" data-sal-duration="500" data-sal-delay="200">
            <img src="assets/media/others/line-7.png" alt="Bubble">
        </li>
    </ul>
</section>