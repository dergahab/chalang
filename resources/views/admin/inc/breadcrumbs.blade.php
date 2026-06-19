<div class="page-header-bar">
    <div class="page-title-wrap">
        <h5 class="page-title">@yield('heading_title')</h5>
    </div>
    <div class="page-title-right">
        <ol class="breadcrumb m-0 bg-transparent p-0">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.home') }}" class="text-muted">
                    <i class="ri-home-5-line"></i>
                </a>
            </li>
            @php
                $segments = Request::segments();
                $url = '';
                if(isset($segments[0]) && $segments[0] == 'admin') {
                    array_shift($segments);
                }
            @endphp
            
            @foreach($segments as $segment)
                @php 
                    $url .= '/'.$segment;
                    $label = ucwords(str_replace('-', ' ', $segment));
                    $translations = [
                        'Service' => 'Xidmətlər',
                        'Portfolio' => 'Layihələr',
                        'Blog' => 'Bloqlar',
                        'User' => 'İstifadəçilər',
                        'Create' => 'Yeni',
                        'Edit' => 'Redaktə',
                        'Message' => 'Mesajlar',
                        'Settings' => 'Tənzimləmələr',
                        'Profile' => 'Profil',
                        'Case Study' => 'Case Studies',
                        'Testimonial' => 'Rəylər',
                        'Partner' => 'Tərəfdaşlar',
                        'Team Member' => 'Komanda',
                        'Faq' => 'FAQ',
                        'About' => 'Haqqımızda',
                        'Contact' => 'Əlaqə',
                        'Social Media' => 'Sosial Media',
                        'Submission' => 'Müraciətlər'
                    ];
                    $label = $translations[$label] ?? $label;
                @endphp
                @if($loop->last)
                    <li class="breadcrumb-item active text-primary" aria-current="page">{{ $label }}</li>
                @else
                    <li class="breadcrumb-item"><a href="#" class="text-muted">{{ $label }}</a></li>
                @endif
            @endforeach
        </ol>
    </div>
</div>
