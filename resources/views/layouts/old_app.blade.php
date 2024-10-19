<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $appConfig->nombre_app }}</title>

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

        @include('layouts.nav')

        <main class="flex-grow-1">
            <div class="row" style="height: 100%; padding-bottom: 0px; margin-bottom: 0px;">
                @auth
                    <div class="col-12">
                        <button class="btn btn-primary d-md-none mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar" aria-expanded="false" aria-controls="sidebar">
                            Mostrar/Ocultar Menú
                        </button>
                    </div>

                    <div class="col-3 bg-dark">
                        <div id="sidebar" class="collapse d-md-block">
                            @include('layouts.sidebar')
                        </div>
                    </div>
                @endauth
                <div class="py-4 {{ Auth::check() ? 'col-md-9' : 'col-md-12' }}">
                    @yield('content')
                </div>
            </div>
        </main>

        @include('layouts.footer')

    </div>
</body>
</html>
