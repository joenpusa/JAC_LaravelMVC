<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'OPA JAC Cúcuta') }}</title>

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link href="{{ mix('css/custom.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app" class="d-flex flex-column min-vh-100">
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

        <main class="py-4 flex-grow-1">
            @yield('content')
        </main>
        <footer class="bg-dark text-light">
            <div class="container">
                <div class="row text-center">
                    <div class="col-md-4">
                        <img src="{{ asset('images/logo.png') }}" class="logo-footer">
                    </div>
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-12">
                                <h5>Alcaldía de San José de Cúcuta</h5>
                            </div>
                            <div class="col-md-6">
                                <p>
                                    Horarios de atención:<br>
                                    Lunes a viernes de<br>
                                    7:00 a 11:30 a.m. y 2:00 a 5:30 p.m
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p>
                                    Línea de Atención:<br>
                                    PBX: (60) (7)5960051
                                </p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="copyright">
                <h5>Copyright © 2024</h5>
            </div>
        </footer>
    </div>
</body>
</html>
