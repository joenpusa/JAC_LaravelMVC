<nav class="collapse navbar-collapse justify-content-between">
    <div class="navbar-logo w-100">
        <a class="btn navbar-toggler navbar-toggler-humburger-icon hover-bg-transparent"
            href="{{ Auth::check() ? url('/home') : url('/') }}">
            <span class="navbar-toggle-icon"><span class="toggle-line"></span></span>
        </a>
        <a class="navbar-brand me-1 me-sm-3" href="{{ Auth::check() ? url('/home') : url('/') }}">
            <div class="d-flex align-items-center">
                <div class="d-flex align-items-center">
                    <img src="{{ asset($appConfig->logo) }}" alt="JUNTAS NDS" width="100" />
                    <h5 class="logo-text ms-2 d-none d-sm-block">JUNTAS NDS</h5>
                </div>
            </div>
        </a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto">

            </ul>

            <ul class="navbar-nav ms-auto">
                @guest
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                <div class="d-flex align-items-center">
                                    <i class="material-icons opacity-10">login</i>
                                    <span class="ms-2">Ingresar</span>
                                </div>
                            </a>
                        </li>
                    @endif
                @endguest
            </ul>
        </div>
    </div>

</nav>
