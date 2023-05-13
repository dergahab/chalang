@extends('front.layouts.main')
@section('content')
 <!--=====================================-->
        <!--=       Why Choose Area Start       =-->
        <!--=====================================-->
        <section class="section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="why-choose-us">
                            <div class="section-heading heading-left">
                                <span class="subtitle">About Us</span>
                                <h3 class="title">Why branding matters?</h3>
                                <p>Ut condimentum enim nec diam convallis mollis. Sed felis quam, semper dapibus purus sed, rhoncus ullamcorper lacus.</p>
                            </div>
                            <div class="accordion" id="choose-accordion">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            <i class="far fa-compress"></i> Strategy
                                        </button>
                                    </h2>
                                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#choose-accordion">
                                        <div class="accordion-body">
                                            Aenean hendrerit laoreet vehicula. Nullam convallis augue at enim gravida pellentesque.
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingTwo">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                            <i class="far fa-code"></i>Design
                                        </button>
                                    </h2>
                                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#choose-accordion">
                                        <div class="accordion-body">
                                            Aenean hendrerit laoreet vehicula. Nullam convallis augue at enim gravida pellentesque.
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingThree">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                            <i class="fal fa-globe"></i>Development
                                        </button>
                                    </h2>
                                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#choose-accordion">
                                        <div class="accordion-body">
                                            Aenean hendrerit laoreet vehicula. Nullam convallis augue at enim gravida pellentesque.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-5 col-lg-6 offset-xl-1">
                        <div class="contact-form-box shadow-box mb--30">
                            <h3 class="title">Get a free Keystroke quote now</h3>
                            <form>
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" class="form-control" name="name" placeholder="John Smith">
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" class="form-control" name="name" placeholder="example@mail.com">
                                </div>
                                <div class="form-group mb--40">
                                    <label>Phone</label>
                                    <input type="tel" class="form-control" name="Phone" placeholder="+123456789">
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="axil-btn btn-fill-primary btn-fluid" name="submit-btn">Get Pricing Now</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="section section-padding-equal bg-color-light pb--70">
            <div class="container">
                <div class="section-heading">
                    <span class="subtitle">What's Going On</span>
                    <h2 class="title">benzer servisler</h2>
                    <p>News From Abstrak And Around The World Of Web Design And Complete Solution of Online Digital Marketing </p>
                </div>
                <div class="row g-0">
                    <div class="slick-slider recent-post-slide" data-slick='{"infinite": true, "autoplay": true, "arrows": false, "dots": false, "slidesToShow": 2,
                    "responsive": [
                        {
                            "breakpoint": 1199,
                            "settings": {
                                "slidesToShow": 1
                            }
                        }
                    ]
                    }'>
                                <div class="slick-slide">
                                    <div class="services-grid active">
                                        <div class="thumbnail">
                                            <img src="assets/media/icon/icon-1.png" alt="icon">
                                        </div>
                                        <div class="content">
                                            <h5 class="title"> <a href="service-design.html">Design</a></h5>
                                            <p>Simply drag and drop photos and videos into your workspace to automatically add them to your Collab Cloud library.</p>
                                            <a href="service-design.html" class="more-btn">Find out more</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="slick-slide">
                                    <div class="services-grid active">
                                        <div class="thumbnail">
                                            <img src="assets/media/icon/icon-1.png" alt="icon">
                                        </div>
                                        <div class="content">
                                            <h5 class="title"> <a href="service-design.html">Design</a></h5>
                                            <p>Simply drag and drop photos and videos into your workspace to automatically add them to your Collab Cloud library.</p>
                                            <a href="service-design.html" class="more-btn">Find out more</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="slick-slide">
                                    <div class="services-grid active">
                                        <div class="thumbnail">
                                            <img src="assets/media/icon/icon-1.png" alt="icon">
                                        </div>
                                        <div class="content">
                                            <h5 class="title"> <a href="service-design.html">Design</a></h5>
                                            <p>Simply drag and drop photos and videos into your workspace to automatically add them to your Collab Cloud library.</p>
                                            <a href="service-design.html" class="more-btn">Find out more</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                </div>
            </div>
            <ul class="shape-group-1 list-unstyled">
                <li class="shape shape-1"><img src="{{asset('assets/media/others/bubble-1.png')}}" alt="bubble"></li>
                <li class="shape shape-2"><img src="{{asset('assets/media/others/line-1.png')}}" alt="bubble"></li>
                <li class="shape shape-3"><img src="{{asset('assets/media/others/line-2.png')}}" alt="bubble"></li>
                <li class="shape shape-4"><img src="assets/media/others/bubble-2.png" alt="bubble"></li>
            </ul>

        </section>
        @include('front.inc.worck_togather')
@endsection