<ul class="navbar-right list-inline float-right mb-0">
    <li class="dropdown notification-list list-inline-item d-none d-md-inline-block search-batches">
        <form role="search" class="app-search" id="batchSearchForm">
            <div class="form-group mb-0">
                <input type="text" class="form-control" id="searchBatch" route="{{route('admin.batch.search')}}" placeholder="Bağlama axtarışı...">
                <button type="submit"><i class="fa fa-search"></i></button>
            </div>
        </form>
        <div class="search-list search-list-batches">
            <div class="search-list-body">
                <ul id="searchBatchesListBody">
                    {{-- <li>
                        <span>
                            <a href="">
                                7330000660889844 trendyol
                            </a>
                        </span>
                    </li> --}}
                    <!-- <li class="not-found-data">
                        <span>
                            <i class="fas fa-ban"></i>
                            Heç bir nəticə tapılmadı....
                        </span>
                    </li> -->
                    <!-- <li>
                        <span>
                            <i class="fa fa-spinner fa-spin"></i>
                            Axtarılır...
                        </span>
                    </li> -->
                </ul>
            </div>
        </div>
    </li>
    <li class="dropdown notification-list list-inline-item d-none d-md-inline-block search-users">
        <form role="search" class="app-search" id="searchUserForm">
            <div class="form-group mb-0">
                <input type="text" class="form-control" id="searchUser" route="{{route('admin.users.search')}}" placeholder="Müştəri axtarışı...">
                <button type="submit"><i class="fa fa-search"></i></button>
            </div>
        </form>
        <div class="search-list search-list-user">
            <div class="search-list-body">
                <ul id="searchUserListBody">
                    <!-- <li>
                        <span>
                            <a href="">
                                Oruc seyidov
                            </a>
                        </span>
                        <span class="search-button-list">
                            <a class="btn btn-sm btn-primary" href="">
                                <i class="fas fa-info"></i>
                            </a>
                            <a class="btn btn-sm btn-warning" href="">
                                <i class="fas fa-money-bill"></i>
                            </a>
                        </span>
                    </li> -->
                    <!-- <li class="not-found-data">
                        <span>
                            <i class="fas fa-ban"></i>
                            Heç bir nəticə tapılmadı....
                        </span>
                    </li> -->
                    <!-- <li>
                        <span>
                            <i class="fa fa-spinner fa-spin"></i>
                            Axtarılır...
                        </span>
                    </li> -->
                </ul>
            </div>
        </div>
    </li>
    <!-- full screen -->
    <li class="dropdown notification-list list-inline-item d-none d-md-inline-block"><a class="nav-link waves-effect" href="#" id="btn-fullscreen"><i class="mdi mdi-fullscreen noti-icon"></i></a></li>
    <li class="dropdown notification-list list-inline-item d-none d-md-inline-block">
        <a class="nav-link waves-effect" href="#" data-toggle="modal" data-target="#globalDeclareBatch">
            <i class="mdi mdi-inbox-multiple-outline"></i>
            Bəyan et
        </a>
    </li>
    <!-- notification -->
    <li class="dropdown notification-list list-inline-item"><a class="nav-link dropdown-toggle arrow-none waves-effect" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false"><i class="mdi mdi-bell-outline noti-icon"></i> <span class="badge badge-pill badge-danger noti-icon-badge">0</span></a>
        @include('admin.inc.header_bar_notification')
    </li>
    <li class="dropdown notification-list list-inline-item">
        <div class="dropdown notification-list nav-pro-img">
            <a class="dropdown-toggle nav-link arrow-none waves-effect nav-user" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false"><img src="{{ asset('admin/assets/images/users/user-4.jpg') }}" alt="user" class="rounded-circle"></a>
            <div class="dropdown-menu dropdown-menu-right profile-dropdown">
                <!-- item-->
                <a class="dropdown-item" href="#"><i class="mdi mdi-account-circle m-r-5"></i> Profilim</a>
                <!-- <a class="dropdown-item" href="#"><i class="mdi mdi-wallet m-r-5"></i> My Wallet</a>
                <a class="dropdown-item d-block" href="#"><span class="badge badge-success float-right">11</span><i class="mdi mdi-settings m-r-5"></i> Settings</a>
                <a class="dropdown-item" href="#"><i class="mdi mdi-lock-open-outline m-r-5"></i> Lock screen</a> -->
                <div class="dropdown-divider"></div>
                <a href="{{ route('logout') }}" class="dropdown-item text-danger"
                    onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                    <i class="mdi mdi-power text-danger"></i> Çıxış</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>
    </li>
</ul>
<ul class="list-inline menu-left mb-0">
    <li class="float-left">
        <button class="button-menu-mobile open-left waves-effect"><i class="mdi mdi-menu"></i></button>
    </li>
    {{-- <li class="d-none d-sm-block">
        <div class="dropdown pt-3 d-inline-block">
            <a class="btn btn-light dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Keçidlər</a>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                <a class="dropdown-item" href="#">
                    <i class="fas fa-box-open"></i>
                    Bəyan et
                </a>
                <a class="dropdown-item" href="#">
                    <i class="fas fa-link"></i>
                    Link Yarat
                </a>
                <a class="dropdown-item" href="#">
                    <i class="fas fa-money-bill"></i>
                    Balans Artır
                </a>
                <!-- <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">Separated link</a> -->
            </div>
        </div>
    </li> --}}
</ul>
