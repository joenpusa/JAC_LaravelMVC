<nav class="navbar navbar-expand-md bg-dark text-light shadow-sm">
    <div class="container">
        <a class="navbar-brand text-light" href="{{ Auth::check() ? url('/home') : url('/') }}">
            {{ config('app.name', 'OPA JAC Cúcuta') }}
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="OPA JAC Cúcuta">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav me-auto">

            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ms-auto">
                <!-- Authentication Links -->
                @guest
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link text-light" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                    @endif

                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link text-light" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item">
                        <a class="nav-link text-light" href="{{ route('configuracion.index') }}">Configuración</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light" href="{{ route('comunas.index') }}">Comunas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light" href="{{ route('certificados.index') }}">Certificados</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light" href="{{ route('juntas.index') }}">Juntas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light" href="{{ route('funcionarios.index') }}">Dignatarios</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle text-light" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-end bg-dark" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item text-light" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                Salir
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
