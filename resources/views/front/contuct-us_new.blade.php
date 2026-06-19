@extends('front.layouts.main_new')
@section('content')
    <div class="breadcrum-area">
        <div class="container">
            <div class="breadcrumb">
                <ul class="list-unstyled">
                    <li><a href="{{ request()->is('preview*') ? route('preview') : route('/') }}">{{ __('front.home') }}</a></li>
                    <li class="active">{{ __('contact') }}</li>
                </ul>
                <h1 class="title h2">{{ __('contact') }}</h1>
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
    <section class="section section-padding">
        <div class="container">
            <div class="row g-4">
                <div class="col-xl-4 col-lg-6">
                    <div class="contact-form-box shadow-box mb--30 glass-card" style="background: var(--card-bg); border: 1px solid var(--card-border); border-radius: 24px; padding: 40px; box-shadow: var(--card-shadow);">
                        <h3 class="title" style="font-family: var(--font-heading); color: var(--color-text-main); margin-bottom: 16px;">{{ __('front.contact.get_in_touch') }}</h3>
                        <form method="POST" action="{{ route('contact.submit') }}">
                            @csrf
                            <input type="text" name="hp" style="display:none">
                            <div class="form-group">
                                <label style="color: var(--color-text-main); font-weight: 500; margin-bottom: 8px;">{{ __('front.contact.name') }}</label>
                                <input type="text" class="form-control" name="full_name" placeholder="John Smith" style="background: rgba(255, 255, 255, 0.08); border: 1px solid var(--card-border); color: var(--color-text-main); border-radius: 12px; padding: 12px 16px;" required>
                            </div>
                            <div class="form-group">
                                <label style="color: var(--color-text-main); font-weight: 500; margin-bottom: 8px;">{{ __('front.contact.email') }}</label>
                                <input type="email" class="form-control" name="email" placeholder="example@mail.com" style="background: rgba(255, 255, 255, 0.08); border: 1px solid var(--card-border); color: var(--color-text-main); border-radius: 12px; padding: 12px 16px;" required>
                            </div>
                            <div class="form-group">
                                <label style="color: var(--color-text-main); font-weight: 500; margin-bottom: 8px;">{{ __('front.contact.phone') }}</label>
                                <input type="text" class="form-control" name="phone" placeholder="+123456789" style="background: rgba(255, 255, 255, 0.08); border: 1px solid var(--card-border); color: var(--color-text-main); border-radius: 12px; padding: 12px 16px;" required>
                            </div>
                            <div class="form-group mb--24">
                                <label style="color: var(--color-text-main); font-weight: 500; margin-bottom: 8px;">{{ __('front.contact.message') }}</label>
                                <textarea name="message" id="contact-message" class="form-control textarea" cols="30" rows="4" style="background: rgba(255, 255, 255, 0.08); border: 1px solid var(--card-border); color: var(--color-text-main); border-radius: 12px; padding: 12px 16px;" required></textarea>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn-primary-custom" style="width: 100%;" name="submit-btn">{{ __('front.contact.get_it_now') }}</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-6">
                    <div class="contact-form-box shadow-box mb--30 glass-card" style="background: var(--card-bg); border: 1px solid var(--card-border); border-radius: 24px; padding: 40px; box-shadow: var(--card-shadow);">
                        <h3 class="title" style="font-family: var(--font-heading); color: var(--color-text-main); margin-bottom: 16px;">{{ __('front.order_now') }}</h3>
                        <form method="POST" action="{{ route('order.submit') }}">
                            @csrf
                            <input type="text" name="hp" style="display:none">
                            <input type="hidden" name="utm_source" value="{{ request('utm_source') }}">
                            <input type="hidden" name="utm_medium" value="{{ request('utm_medium') }}">
                            <input type="hidden" name="utm_campaign" value="{{ request('utm_campaign') }}">
                            <div class="form-group">
                                <label style="color: var(--color-text-main); font-weight: 500; margin-bottom: 8px;">{{ __('front.contact.name') }}</label>
                                <input type="text" class="form-control" name="full_name" placeholder="John Smith" style="background: rgba(255, 255, 255, 0.08); border: 1px solid var(--card-border); color: var(--color-text-main); border-radius: 12px; padding: 12px 16px;" required>
                            </div>
                            <div class="form-group">
                                <label style="color: var(--color-text-main); font-weight: 500; margin-bottom: 8px;">{{ __('front.contact.email') }}</label>
                                <input type="email" class="form-control" name="email" placeholder="example@mail.com" style="background: rgba(255, 255, 255, 0.08); border: 1px solid var(--card-border); color: var(--color-text-main); border-radius: 12px; padding: 12px 16px;" required>
                            </div>
                            <div class="form-group">
                                <label style="color: var(--color-text-main); font-weight: 500; margin-bottom: 8px;">{{ __('front.contact.phone') }}</label>
                                <input type="text" class="form-control" name="phone" placeholder="+123456789" style="background: rgba(255, 255, 255, 0.08); border: 1px solid var(--card-border); color: var(--color-text-main); border-radius: 12px; padding: 12px 16px;" required>
                            </div>
                            <div class="form-group">
                                <label style="color: var(--color-text-main); font-weight: 500; margin-bottom: 8px;">{{ __('services') }}</label>
                                <select name="service_id" class="form-control" style="background: rgba(255, 255, 255, 0.08); border: 1px solid var(--card-border); color: var(--color-text-main); border-radius: 12px; padding: 12px 16px;" required>
                                    <option value="">{{ __('front.choose_service') }}</option>
                                    @foreach(($services ?? $main_services ?? collect()) as $service)
                                        @php
                                            $rawName = $service->name;
                                            $flat = \Illuminate\Support\Arr::flatten((array) $rawName);
                                            $serviceName = implode(' / ', array_filter($flat, 'strlen'));
                                        @endphp
                                        <option value="{{ $service->id }}">{{ $serviceName }}</option>
                                        @foreach(($service->childs ?? collect()) as $child)
                                            @php
                                                $childRawName = $child->name;
                                                $childFlat = \Illuminate\Support\Arr::flatten((array) $childRawName);
                                                $childName = implode(' / ', array_filter($childFlat, 'strlen'));
                                            @endphp
                                            <option value="{{ $child->id }}">-- {{ $childName }}</option>
                                        @endforeach
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb--24">
                                <label style="color: var(--color-text-main); font-weight: 500; margin-bottom: 8px;">{{ __('front.contact.message') }}</label>
                                <textarea name="message" class="form-control textarea" rows="3" style="background: rgba(255, 255, 255, 0.08); border: 1px solid var(--card-border); color: var(--color-text-main); border-radius: 12px; padding: 12px 16px;" required></textarea>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn-primary-custom" style="width: 100%;">{{ __('front.contact.get_it_now') }}</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-12">
                    <div class="contact-form-box shadow-box mb--30 glass-card" style="background: var(--card-bg); border: 1px solid var(--card-border); border-radius: 24px; padding: 40px; box-shadow: var(--card-shadow);">
                        <h3 class="title" style="font-family: var(--font-heading); color: var(--color-text-main); margin-bottom: 16px;">{{ __('front.book_a_call') }}</h3>
                        <form method="POST" action="{{ route('call.submit') }}">
                            @csrf
                            <input type="text" name="hp" style="display:none">
                            <input type="hidden" name="utm_source" value="{{ request('utm_source') }}">
                            <input type="hidden" name="utm_medium" value="{{ request('utm_medium') }}">
                            <input type="hidden" name="utm_campaign" value="{{ request('utm_campaign') }}">
                            <div class="form-group">
                                <label style="color: var(--color-text-main); font-weight: 500; margin-bottom: 8px;">{{ __('front.contact.name') }}</label>
                                <input type="text" class="form-control" name="full_name" placeholder="John Smith" style="background: rgba(255, 255, 255, 0.08); border: 1px solid var(--card-border); color: var(--color-text-main); border-radius: 12px; padding: 12px 16px;" required>
                            </div>
                            <div class="form-group">
                                <label style="color: var(--color-text-main); font-weight: 500; margin-bottom: 8px;">{{ __('front.contact.email') }}</label>
                                <input type="email" class="form-control" name="email" placeholder="example@mail.com" style="background: rgba(255, 255, 255, 0.08); border: 1px solid var(--card-border); color: var(--color-text-main); border-radius: 12px; padding: 12px 16px;" required>
                            </div>
                            <div class="form-group">
                                <label style="color: var(--color-text-main); font-weight: 500; margin-bottom: 8px;">{{ __('front.contact.phone') }}</label>
                                <input type="text" class="form-control" name="phone" placeholder="+123456789" style="background: rgba(255, 255, 255, 0.08); border: 1px solid var(--card-border); color: var(--color-text-main); border-radius: 12px; padding: 12px 16px;" required>
                            </div>
                            <div class="form-group">
                                <label style="color: var(--color-text-main); font-weight: 500; margin-bottom: 8px;">{{ __('front.call_slot') }}</label>
                                <input type="datetime-local" class="form-control" name="slot" style="background: rgba(255, 255, 255, 0.08); border: 1px solid var(--card-border); color: var(--color-text-main); border-radius: 12px; padding: 12px 16px;" required>
                            </div>
                            <div class="form-group mb--24">
                                <label style="color: var(--color-text-main); font-weight: 500; margin-bottom: 8px;">{{ __('front.contact.message') }}</label>
                                <textarea name="message" class="form-control textarea" rows="3" style="background: rgba(255, 255, 255, 0.08); border: 1px solid var(--card-border); color: var(--color-text-main); border-radius: 12px; padding: 12px 16px;"></textarea>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn-primary-custom" style="width: 100%;">{{ __('front.contact.get_it_now') }}</button>
                            </div>
                            <p style="font-size: 12px; color: var(--color-text-secondary); margin-top: 8px;">{{ __('front.call_embed_hint') }}</p>
                        </form>
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

    <section class="section section-padding bg-color-dark overflow-hidden">
        <div class="container">
            <div class="section-heading heading-light-left">
                <span class="subtitle">{{ __('front.contact.find_us') }}</span>
                <h2 class="title">{{ __('front.contact.location') }}</h2>
            </div>
            <div class="row">
                <div class="col-lg-3 col-sm-6">
                    <div class="office-location">
                        <div class="thumbnail">
                            <img src="{{ asset('assets/media/others/location-1.png') }}" alt="Office">
                        </div>
                        <div class="content">
                            <h4 class="title">Bakı Baş Ofis</h4>
                            <p>Cəfər Cabbarlı küç. 44, Caspian Plaza <br> Bakı, Azərbaycan</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="office-location">
                        <div class="thumbnail">
                            <img src="{{ asset('assets/media/others/location-2.png') }}" alt="Office">
                        </div>
                        <div class="content">
                            <h4 class="title">Gəncə Ofisi</h4>
                            <p>Atatürk prospekti 12 <br> Gəncə, Azərbaycan</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="office-location">
                        <div class="thumbnail">
                            <img src="{{ asset('assets/media/others/location-3.png') }}" alt="Office">
                        </div>
                        <div class="content">
                            <h4 class="title">Rəqəmsal Dəstək</h4>
                            <p>7/24 Onlayn Xidmət <br> support@chalang.az</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="office-location">
                        <div class="thumbnail">
                            <img src="{{ asset('assets/media/others/location-4.png') }}" alt="Office">
                        </div>
                        <div class="content">
                            <h4 class="title">Qlobal Dəstək</h4>
                            <p>info@chalang.az <br> Beynəlxalq Əməkdaşlıq</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <ul class="shape-group-11 list-unstyled">
            <li class="shape shape-1"><img src="{{ asset('assets/media/others/line-6.png') }}" alt="line"></li>
            <li class="shape shape-2"><img src="{{ asset('assets/media/others/circle-3.png') }}" alt="line"></li>
        </ul>
    </section>
@endsection

