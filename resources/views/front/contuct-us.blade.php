@extends('front.layouts.main')
@section('content')
    <!--=====================================-->
    <!--=       Breadcrumb Area Start       =-->
    <!--=====================================-->
    <div class="breadcrum-area">
        <div class="container">
            <div class="breadcrumb">
                <ul class="list-unstyled">
                    <li><a href="{{ route('home') }}">{{ __('front.navigation.home') }}</a></li>
                    <li class="active">{{ __('front.navigation.contact') }}</li>
                </ul>
                <h1 class="title h2">{{ __('front.contact.title') }}</h1>
            </div>
        </div>
        <ul class="shape-group-8 list-unstyled">
            <li class="shape shape-1" data-sal="slide-right" data-sal-duration="500" data-sal-delay="100">
                <img src="assets/media/others/bubble-9.png" alt="Bubble">
            </li>
            <li class="shape shape-2" data-sal="slide-left" data-sal-duration="500" data-sal-delay="200">
                <img src="assets/media/others/bubble-17.png" alt="Bubble">
            </li>
            <li class="shape shape-3" data-sal="slide-up" data-sal-duration="500" data-sal-delay="300">
                <img src="assets/media/others/line-4.png" alt="Line">
            </li>
        </ul>
    </div>
    <!--=====================================-->
    <!--=       Contact  Area Start        =-->
    <!--=====================================-->
    <section class="section section-padding">
        <div class="container">
            <div class="row">
                <div class="col-xl-5 col-lg-6">
                    <div class="contact-form-box shadow-box mb--30">
                        <h3 class="title">{{ __('front.contact.quote_title') }}</h3>
                        @include('front.inc.form', ['type' => 'contact'])
                    </div>
                </div>
                <div class="col-xl-5 col-lg-6 offset-xl-1">
                    <div class="contact-info mb--30 mb_md--30 mt_md--0 ">
                        <h4 class="title">{{ __('front.contact.phone') }}</h4>
                        <p>{{ __('front.contact.phone_hours') }}</p>
                        <h4 class="phone-number"><a href="tel:{{ $contact?->phone ?? '' }}">{{ $contact?->phone ?? '' }}</a></h4>
                    </div>
                    <div class="contact-info mb--30">
                        <h4 class="title">{{ __('front.contact.email') }}</h4>
                        <p>{{ __('front.contact.email_hours') }}</p>
                        <h4 class="phone-number"><a href="mailto:{{ $contact?->mail ?? '' }}">{{ $contact?->mail ?? '' }}</a></h4>
                    </div>
                    <div class="contact-info mb--30">
                        <h4 class="title">{{ __('front.contact.address') }}</h4>
                        <p>{{ __('front.contact.address_hours') }}</p>
                        <h4 class="phone-number"><a href="{{ $contact?->address ?? '#' }}">{{ $contact?->address ?? '' }}</a></h4>
                    </div>
                </div>
            </div>
        </div>
        <ul class="list-unstyled shape-group-12">
            <li class="shape shape-1"><img src="{{ asset('assets/media/others/bubble-2.png') }}" alt="Bubble"></li>
            <li class="shape shape-2"><img src="{{ asset('assets/media/others/bubble-1.png') }}" alt="Bubble"></li>
            <li class="shape shape-3"><img src="{{ asset('assets/media/others/circle-3.png') }}" alt="Circle"></li>
        </ul>
    </section>
    <section class="section">
        <div class="container-fluid">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d189.99795226331292!2d49.833003389274!3d40.36525083113342!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sru!2saz!4v1690659637725!5m2!1sru!2saz"
                width="100%" height="450px" style="border:0;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </section>
@endsection
