@extends('front.layouts.main_new')
@section('title', 'Komandamız - Chalang')

@section('content')
<section class="section" style="padding-top: 120px;">
    <h1 class="section-title">Komandamız</h1>
    <p class="section-subtitle">Yaradıcı beyinlər</p>
    <div class="grid">
        @foreach($team_members as $member)
            <div class="team-card">
                @if($member->image)
                    <img src="{{ asset('storage/' . $member->image) }}" alt="{{ $member->name }}" class="team-img">
                @endif
                <div class="team-info">
                    <h3>{{ $member->name }}</h3>
                    <p style="color:var(--brand-primary); font-weight:600">{{ $member->position }}</p>
                    <p>{{ $member->bio }}</p>
                    @if($member->specialties)
                        <div style="margin: 10px 0;">
                            @foreach($member->specialties as $specialty)
                                <span class="service-pill" style="font-size: 0.7rem; margin: 2px;">{{ $specialty }}</span>
                            @endforeach
                        </div>
                    @endif
                    @if($member->social_links)
                        <div class="social-links">
                            @foreach($member->social_links as $platform => $link)
                                <a href="{{ $link }}" class="social-link" target="_blank">{{ substr($platform, 0, 1) }}</a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</section>
@endsection
