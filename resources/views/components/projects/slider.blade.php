@props(['projects'])

<div class="section section-padding-equal">
    <div class="container">
        <div class="section-heading heading-left">
            <span class="subtitle">Featured Work</span>
            <h2 class="title">Projects that <br> we are proud of</h2>
        </div>
        <div class="slick-slider slick-arrow-nav slick-dot-nav-top" data-slick='{"infinite": true, "slidesToShow": 1, "slidesToScroll": 1, "arrows": true, "dots": true}'>
            
            @forelse($projects as $project)
            <div class="slick-slide">
                <div class="case-study-featured" data-sal="slide-up" data-sal-duration="800" data-sal-delay="100">
                    <div class="row align-items-center">
                        <div class="col-xl-7 col-lg-6">
                            <div class="case-study-featured-thumb">
                                <img src="{{ asset('storage/' . $project->image) }}" alt="{{ $project->title }}">
                            </div>
                        </div>
                        <div class="col-xl-5 col-lg-6">
                            <div class="case-study-featured-content">
                                <div class="section-heading heading-left">
                                    <div class="subtitle">{{ $project->pcategories->first()->name ?? 'Project' }}</div>
                                    <h2 class="title"><a href="{{ route('portfolio.single', $project->slug) }}">{{ $project->title }}</a></h2>
                                    <p>{{ Str::limit(strip_tags($project->description), 150) }}</p>
                                    <a href="{{ route('portfolio.single', $project->slug) }}" class="axil-btn btn-fill-primary btn-large">Read Case Study</a>
                                </div>
                                <div class="case-study-counterup">
                                    <div class="single-counterup">
                                        <h2 class="count-number">
                                            <span class="number count" data-count="15">15</span>
                                            <span class="symbol">%</span>
                                        </h2>
                                        <span class="counter-title">ROI increase</span>
                                    </div>
                                    <div class="single-counterup">
                                        <h2 class="count-number">
                                            <span class="number count" data-count="60">60</span>
                                            <span class="symbol">k</span>
                                        </h2>
                                        <span class="counter-title">Monthly website visits</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="slick-slide">
                <p>No projects found.</p>
            </div>
            @endforelse

        </div>
    </div>
</div>
