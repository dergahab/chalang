@extends('front.layouts.main')
@section('content')
    @include('front.index.banner')
    @include('front.index.services')
    @include('front.index.about')

    <section class="section section-padding-2 bg-reb">
        <div class="container">
            <div class="section-heading heading-left mb--40">
                <span class="subtitle">Layihələr</span>
                <h2 class="title">Our Project</h2>
            </div>
            @include('front.inc.portfolio')
        </div>
        <ul class="shape-group-7 list-unstyled">
            <li class="shape shape-1"><img src="{{ asset('assets/media/others/circle-2.png') }}" alt="circle"></li>
            <li class="shape shape-2"><img src="{{ asset('assets/media/others/bubble-2.png') }}" alt="Line"></li>
            <li class="shape shape-3"><img src="{{ asset('assets/media/others/bubble-1.png') }}" alt="Line"></li>
        </ul>
    </section>


    @include('front.index.clients')
    @include('front.index.posts')
    @include('front.inc.worck_togather')
@endsection
