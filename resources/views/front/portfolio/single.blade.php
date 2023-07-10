@extends('front.layouts.main')

@section('content')
<div class="breadcrum-area breadcrumb-banner">
    <div class="container">
        <div class="section-heading heading-left" data-sal="slide-right" data-sal-duration="1000" data-sal-delay="300">
            <h1 class="title h2">{{$portfolio->title}}</h1>
            <p>{{$portfolio->description}}</p>
        </div>
        <div class="banner-thumbnail" data-sal="slide-up" data-sal-duration="1000" data-sal-delay="400">
            <img class="paralax-image" src="{{asset(Storage::url($portfolio->image))}}" alt="Illustration">
        </div>
    </div>
    <ul class="shape-group-8 list-unstyled">
        <li class="shape shape-1" data-sal="slide-right" data-sal-duration="500" data-sal-delay="100">
            <img src="{{asset('assets/media/others/bubble-9.png')}}" alt="Bubble">
        </li>
        <li class="shape shape-2" data-sal="slide-left" data-sal-duration="500" data-sal-delay="200">
            <img src="{{asset('assets/media/others/bubble-21.png')}}" alt="Bubble">
        </li>
        <li class="shape shape-3" data-sal="slide-up" data-sal-duration="500" data-sal-delay="300">
            <img src="{{asset('assets/media/others/line-4.png')}}" alt="Line">
        </li>
    </ul>
</div>

<div class="breadcrum-area breadcrumb-banner single-breadcrumb">
    <div class="container">
        <div class="row align-items-center">
            @foreach ($images as $image)
            <div class="col-md-4">
                <a  data-fancybox="gallery"  href="{{asset('storage/' . $image->url) }}">
                    <img src="{{asset('storage/' . $image->url) }}" alt="" />
                  </a>
               </div>     
            @endforeach
           
        </div>
    </div>
   
</div>
<script>
    Fancybox.bind('[data-fancybox="gallery"]', {
      //
    });    
  </script>
@endsection
