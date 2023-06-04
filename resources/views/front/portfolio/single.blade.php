@extends('front.layouts.main')

@section('content')
<div class="breadcrum-area breadcrumb-banner single-breadcrumb">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="section-heading heading-left sal-animate" data-sal="slide-right" data-sal-duration="1000" data-sal-delay="300">
                    <h1 class="title h2">Creative Agency</h1>
                    <p>A quick view of industry specific problems solved with design by the awesome team at Keystroke.</p>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="banner-thumbnail sal-animate" data-sal="slide-up" data-sal-duration="1000" data-sal-delay="400">
                    <img class="paralax-image" src="assets/media/project/project-2.png" alt="Illustration">
                </div>
            </div>
        </div>
    </div>
    <ul class="shape-group-8 list-unstyled">
        <li class="shape shape-1 sal-animate" data-sal="slide-right" data-sal-duration="500" data-sal-delay="100">
            <img src="assets/media/others/bubble-9.png" alt="Bubble">
        </li>
        <li class="shape shape-2 sal-animate" data-sal="slide-left" data-sal-duration="500" data-sal-delay="200">
            <img src="assets/media/others/bubble-20.png" alt="Bubble">
        </li>
        <li class="shape shape-3 sal-animate" data-sal="slide-up" data-sal-duration="500" data-sal-delay="300">
            <img src="assets/media/others/line-4.png" alt="Line">
        </li>
    </ul>
</div>

@endsection