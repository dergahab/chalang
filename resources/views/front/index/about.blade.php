<section class="section section-padding-equal bg-color-light">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6" data-sal="slide-up" data-sal-duration="800">
                <div class="about-us">
                    <div class="section-heading heading-left mb-0">
                        <span class="subtitle">{{ __('front.about.subtitle') }}</span>
                        <h2 class="title mb--40">{{ __('front.about.title') }}</h2>
                        <p>{{ __('front.about.description_1') }}</p>
                        <p>{{ __('front.about.description_2') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-5 col-lg-6 offset-xl-1" data-sal="slide-up" data-sal-duration="800" data-sal-delay="100">
                <div class="contact-form-box">
                    <h3 class="title">{{ __('front.about.contact_title') }}</h3>
                    @include('front.inc.form', ['type' => 'main'])
                </div>
            </div>
        </div>
    </div>
    <ul class="shape-group-6 list-unstyled">
        <li class="shape shape-1"><img src="{{ asset('assets/media/others/bubble-7.png') }}" alt="Bubble"></li>
        <li class="shape shape-2"><img src="{{ asset('assets/media/others/line-4.png') }}" alt="line"></li>
        <li class="shape shape-3"><img src="{{ asset('assets/media/others/line-5.png') }}" alt="line"></li>
    </ul>
</section>
