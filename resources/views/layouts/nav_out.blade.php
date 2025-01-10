<nav class="navbar navbar-expand-md bg-dark text-light shadow-sm">
    <div class="container">
        <a class="navbar-brand text-light" href="{{ Auth::check() ? url('/home') : url('/') }}">
            {{ $appConfig->nombre_app }}
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="OPA JAC Cúcuta">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto">

            </ul>

            <ul class="navbar-nav ms-auto">
                @guest
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link text-light" href="{{ route('login') }}">Ingresar</a>
                        </li>
                    @endif
                @endguest
            </ul>
        </div>
    </div>
</nav>
