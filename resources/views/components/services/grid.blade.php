@props(['services'])

<div class="section section-padding">
    <div class="container">
        <div class="section-heading heading-left mb--20 mb_sm--10">
            <span class="subtitle">What We Can Do For You</span>
            <h2 class="title">Services we can <br> help you with</h2>
        </div>
        <div class="row">
            @forelse($services as $service)
            <div class="col-lg-4 col-md-6" data-sal="slide-up" data-sal-duration="800" data-sal-delay="100">
                <div class="services-grid service-style-2">
                    <div class="thumbnail">
                        @if($service->icon)
                            <img src="{{ asset('storage/' . $service->icon) }}" alt="{{ $service->name }}">
                        @else
                            <img src="{{ asset('assets/media/icon/icon-1.png') }}" alt="icon">
                        @endif
                    </div>
                    <div class="content">
                        <h5 class="title"> <a href="{{ route('service.single', $service->slug) }}">{{ $service->name }}</a></h5>
                        <p>{{ Str::limit($service->content, 100) }}</p>
                        <a href="{{ route('service.single', $service->slug) }}" class="more-btn">Find out more</a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <p>No services found.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
