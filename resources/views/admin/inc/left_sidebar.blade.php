 <div class="app-menu navbar-menu">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <!-- Dark Logo-->
                <a href="{{route('/')}}" class="logo logo-dark">
                     <img src="{{ asset('admin/assets/images/logo-dark.png') }}" alt=""
                            height="22">
                    <span class="logo-sm">
                        <img src="{{ asset('admin/assets/images/logo-dark.png') }}" alt=""
                            height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('admin/assets/images/logo-white.png') }}" alt=""
                            height="17">
                    </span>
                </a>
                <!-- Light Logo-->
                <a href="/" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{ asset('admin/assets/images/logo-sm.png') }}" alt=""
                            height="22">
                    </span>
                    <span class="logo-lg">
                        {{-- logo place --}}
                        <img src="{{ asset('admin/assets/images/logo-white.png') }}" alt=""
                            height="17">
                    </span>
                </a>
                <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
                    id="vertical-hover">
                    <i class="ri-record-circle-line"></i>
                </button>
            </div>

            <div id="scrollbar">
                <div class="container-fluid">

                    <div id="two-column-menu">
                    </div>
                    <ul class="navbar-nav" id="navbar-nav">
                        @foreach ($sidebarItems as $item)
                        @if(!auth()->user()?->can($item->get('can') ?? '*'))
                            @php continue; @endphp
                        @endif

                        @if(isset($item['showFlag']) && !$item['showFlag'])
                            @php
                                continue;
                            @endphp
                        @endif
                      
                        @if(!$item->get('route') and ($item->get('inner') === null))
                            <li class="menu-title"><span data-key="t-menu">{{ $item->get('title') }}</span></li>
                        @elseif($item->get('route') and !is_array($item->get('inner')))
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="{{ route($item->get('route'), $item->get('params') ?? []) }}" 
                                 aria-expanded="false" aria-controls="sidebarDashboards{{$loop->iteration}}">
                                 {!! $item->get('icon') !!}<span>{{ $item->get('title') }}</span>      
                            </a>
                        </li>
                        @else
                        <li class="nav-item">
                            <a class="nav-link menu-link @if($item->get('is_active_route') ) active @endif" href="#sidebarDashboards{{$loop->iteration}}" data-bs-toggle="collapse"
                                role="button" aria-expanded="false" aria-controls="sidebarDashboards{{$loop->iteration}}">
                                {!! $item->get('icon') !!} <span data-key="t-dashboards"> {{ $item->get('title') }}</span>
                            </a>
                            <div class="collapse menu-dropdown" id="sidebarDashboards{{$loop->iteration}}">
                                <ul class="nav nav-sm flex-column">
                                    @foreach($item->get('inner') as $inner)
                                    @if(!auth()->user()->can($inner->get('can') ?? '*'))
                                        @php continue; @endphp
                                    @endif
                                        <li class="nav-item">
                                            <a href="{{ route($inner->get('route'), $inner->get('params') ?? []) }}" class="nav-link active @if($item->get('is_active_route') ) active @endif" data-key="t-analytics">
                                                {!! $inner->get('icon') !!} <span>{{ $inner->get('title') }}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </li> 
                        @endif
                        @endforeach
                    </ul>
                </div>
                <!-- Sidebar -->
            </div>

            <div class="sidebar-background"></div>
        </div>