@extends('front.layouts.main_new')
@section('content')
    <div class="breadcrum-area">
        <div class="container">
            <div class="breadcrumb">
                <ul class="list-unstyled">
                    <li><a href="{{ request()->is('preview*') ? route('preview') : route('/') }}">{{ __('front.home') }}</a></li>
                    <li class="active">{{ __('portfolio') }}</li>
                </ul>
                <h1 class="title h2">{{ __('portfolio') }}</h1>
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
    <section class="section section-padding-2">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-heading heading-left mb--40">
                        <span class="subtitle">{{ __('front.portfolio.portfolio_description') }}</span>
                        <h2 class="title">{{ __('front.portfolio.our_projects') }}</h2>
                    </div>
                </div>
            </div>
            @include('front.inc.portfolio')
        </div>
        <ul class="shape-group-7 list-unstyled">
            <li class="shape shape-1"><img src="{{ asset('assets/media/others/circle-2.png') }}" alt="circle"></li>
            <li class="shape shape-2"><img src="{{ asset('assets/media/others/bubble-2.png') }}" alt="Line"></li>
            <li class="shape shape-3"><img src="{{ asset('assets/media/others/bubble-1.png') }}" alt="Line"></li>
        </ul>
    </section>

    @include('front.inc.worck_togather')
@endsection
