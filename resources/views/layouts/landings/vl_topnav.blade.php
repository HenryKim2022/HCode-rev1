<!-- ========== Horizontal Menu Start ========== -->
<div class="topnav">
    <div class="container-fluid">
        <nav class="navbar navbar-expand-lg">
            <div class="collapse navbar-collapse" id="topnav-menu-content">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="{{ route('root') }}" id="topnav-dashboards"
                            role="button" aria-haspopup="true" aria-expanded="false">
                            {{-- <i class="mdi mdi-home"></i>Home --}}
                            <i class="mdi mdi-home"></i>{{ trans('language.vl_menu_home') }}
                        </a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-layouts" role="button"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="mdi mdi-newspaper"></i>{{ trans('language.vl_menu_news') }}
                        </a>

                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-categories"
                            role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="mdi mdi-tag-multiple-outline"></i>{{ trans('language.vl_menu_cat') }} <div
                                class="arrow-down"></div>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="topnav-categories">
                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-cat-1"
                                    role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Categories A <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-cat-1">
                                    <a href="auth-login.html" class="dropdown-item">A1</a>
                                    <a href="auth-register.html" class="dropdown-item">A2</a>
                                    <a href="auth-logout.html" class="dropdown-item">A3</a>
                                </div>
                            </div>
                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-cat-1"
                                    role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Categories B <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-cat-2">
                                    <a href="error-404.html" class="dropdown-item">B1</a>
                                    <a href="error-404-alt.html" class="dropdown-item">B2</a>
                                    <a href="error-500.html" class="dropdown-item">B3</a>
                                </div>
                            </div>

                        </div>
                    </li>



                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-layouts" role="button"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="mdi mdi-lifebuoy"></i>{{ trans('language.vl_menu_supports') }} <div
                                class="arrow-down"></div>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="topnav-layouts">
                            <a data-bs-toggle="modal" data-bs-target="#aboutus_modal" class="dropdown-item"
                                target="_blank">{{ trans('language.vl_menu_aboutus') }}</a>
                            <a data-bs-toggle="modal" data-bs-target="#contactus_modal" class="dropdown-item"
                                target="_blank">{{ trans('language.vl_menu_contactus') }}</a>
                        </div>
                        {{-- @include('v_res.landings.modals.v_aboutus_modal')
                        @include('v_res.landings.modals.v_contactus_modal') --}}
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>
<!-- ========== Horizontal Menu End ========== -->
