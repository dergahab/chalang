@extends('front.layouts.main_new')
@section('content')
    @php
        $isPreview = request()->is('preview*');
        $portfolioRoute = $isPreview ? route('preview.portfolio') : route('portfolio');
        $categoryName = $portfolio->pcategories->first()->name ?? '';
    @endphp

    @push('schema_json')
        {!! App\Helpers\SchemaHelper::breadcrumb([
            __('portfolio') => $portfolioRoute,
            $portfolio->title => ''
        ]) !!}
    @endpush

    @include('front.layouts.partials.breadcrumb', [
        'title' => $portfolio->title,
        'items' => [
            __('portfolio') => $portfolioRoute,
            $portfolio->title => ''
        ]
    ])

    <section class="section-padding single-portfolio-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-5">
                    <div class="section-heading heading-left mb-0">
                        <span class="subtitle">{{ $categoryName }}</span>
                        <h3 class="title">{{ $portfolio->title }}</h3>
                    </div>
                    {!! $portfolio->body !!}
                    <a href="{{ $portfolio->link }}" class="axil-btn btn-fill-primary">Get it Now</a>
                </div>
                <div class="col-lg-6 offset-xl-1">
                    <div class="why-choose-us">
                        <div class="section-heading heading-left">
                            <h3 class="title">We delivered</h3>
                            <p>Nulla facilisi. Nullam in magna id dolor blandit rutrum eget vulputate augue sed eu leo eget
                                risus imperdiet.</p>
                        </div>
                        <div class="accordion" id="choose-accordion">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        <i class="far fa-compress"></i> Strategy
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                                    data-bs-parent="#choose-accordion">
                                    <div class="accordion-body">
                                        Aenean hendrerit laoreet vehicula. Nullam convallis augue at enim gravida
                                        pellentesque.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingTwo">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        <i class="far fa-code"></i> Design
                                    </button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                                    data-bs-parent="#choose-accordion">
                                    <div class="accordion-body">
                                        Aenean hendrerit laoreet vehicula. Nullam convallis augue at enim gravida
                                        pellentesque.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingThree">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseThree" aria-expanded="false"
                                        aria-controls="collapseThree">
                                        <i class="far fa-globe"></i> Development
                                    </button>
                                </h2>
                                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                                    data-bs-parent="#choose-accordion">
                                    <div class="accordion-body">
                                        Aenean hendrerit laoreet vehicula. Nullam convallis augue at enim gravida
                                        pellentesque.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section-padding bg-color-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="section-heading heading-left mb--40">
                        <h3 class="title">Gallery</h3>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach ($images as $image)
                    <div class="col-md-6">
                        <div class="project-grid">
                            <div class="thumbnail">
                                <img src="{{ asset(Storage::url($image->image)) }}" alt="project">
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </section>

    @include('front.inc.worck_togather')
@endsection
