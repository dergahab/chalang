<section class="section section-padding bg-color-dark">
    <div class="container">
        <div class="section-heading heading-light-left">
            <span class="subtitle">Müştərilər</span>
            <h2 class="title"> Clients</h2>
            <p>Design anything from simple icons to fully featured websites and applications.</p>
        </div>
        <div class="row">
            @foreach ($companies as $company)
                <div class="col-lg-3 col-6" data-sal="slide-up" data-sal-duration="500">
                    <div class="brand-grid active">
                        <img src="{{ $company->image }}" alt="{{ $company->name }}">
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <ul class="shape-group-2 list-unstyled">
        <li class="shape shape-1"><img src="{{ asset('assets/media/others/circle-1.png') }}" alt="circle"></li>
        <li class="shape shape-2"><img src="{{ asset('assets/media/others/line-3.png') }}" alt="circle"></li>
        <li class="shape shape-3"><img src="{{ asset('assets/media/others/bubble-3.png') }}" alt="circle"></li>
    </ul>
</section>
