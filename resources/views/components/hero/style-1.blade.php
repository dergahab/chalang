@props(['title', 'subtitle', 'description', 'buttonText', 'buttonUrl', 'image'])

<div class="banner banner-style-1">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7 col-xl-6">
                <div class="banner-content">
                    <div class="inner">
                        <span class="subtitle" data-sal="slide-up" data-sal-duration="1000" data-sal-delay="100">{{ $subtitle ?? 'Digital Agency' }}</span>
                        <h1 class="title" data-sal="slide-up" data-sal-duration="1000" data-sal-delay="200">{{ $title ?? 'Build your website with us.' }}</h1>
                        <p class="description" data-sal="slide-up" data-sal-duration="1000" data-sal-delay="300">{{ $description ?? '' }}</p>
                        <div class="banner-btn" data-sal="slide-up" data-sal-duration="1000" data-sal-delay="400">
                            <a href="{{ $buttonUrl ?? '#' }}" class="axil-btn btn-fill-white btn-large">{{ $buttonText ?? 'Get Started' }}</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 col-xl-6">
                <div class="banner-thumbnail">
                    <div class="large-thumb" data-sal="zoom-in" data-sal-duration="800" data-sal-delay="300">
                        @if(isset($image))
                            <img src="{{ $image }}" alt="Hero Image">
                        @else
                            <img src="{{ asset('assets/media/banner/banner-thumb-1.png') }}" alt="Banner Thumb">
                        @endif
                    </div>
                    <div class="large-thumb-2" data-sal="slide-left" data-sal-duration="800" data-sal-delay="800">
                        <img src="{{ asset('assets/media/banner/banner-thumb-2.png') }}" alt="Banner Thumb">
                    </div>
                    <ul class="list-unstyled shape-group">
                        <li class="shape shape-1" data-sal="slide-right" data-sal-duration="500" data-sal-delay="1000">
                            <img src="{{ asset('assets/media/banner/banner-shape-1.png') }}" alt="Shape">
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <ul class="list-unstyled shape-group-21">
        <li class="shape shape-1" data-sal="slide-down" data-sal-duration="500" data-sal-delay="100">
            <img src="{{ asset('assets/media/others/bubble-39.png') }}" alt="Bubble">
        </li>
        <li class="shape shape-2" data-sal="zoom-in" data-sal-duration="800" data-sal-delay="500">
            <img src="{{ asset('assets/media/others/bubble-38.png') }}" alt="Bubble">
        </li>
        <li class="shape shape-3" data-sal="slide-left" data-sal-duration="500" data-sal-delay="700">
            <img src="{{ asset('assets/media/others/bubble-14.png') }}" alt="Bubble">
        </li>
        <li class="shape shape-4" data-sal="slide-left" data-sal-duration="500" data-sal-delay="700">
            <img src="{{ asset('assets/media/others/bubble-14.png') }}" alt="Bubble">
        </li>
        <li class="shape shape-5" data-sal="slide-left" data-sal-duration="500" data-sal-delay="700">
            <img src="{{ asset('assets/media/others/bubble-14.png') }}" alt="Bubble">
        </li>
        <li class="shape shape-6" data-sal="slide-left" data-sal-duration="500" data-sal-delay="700">
            <img src="{{ asset('assets/media/others/bubble-40.png') }}" alt="Bubble">
        </li>
        <li class="shape shape-7" data-sal="slide-left" data-sal-duration="500" data-sal-delay="700">
            <img src="{{ asset('assets/media/others/bubble-41.png') }}" alt="Bubble">
        </li>
    </ul>
</div>
