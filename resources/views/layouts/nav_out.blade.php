<div class="container d-flex align-items-center justify-content-between py-2">
    <a class="navbar-brand d-flex align-items-center text-decoration-none" href="{{ Auth::check() ? url('/home') : url('/') }}">
        @if(isset($appConfig) && $appConfig->logo)
            <img src="{{ asset($appConfig->logo) }}" alt="{{ $appConfig->nombre_app ?? 'JUNTAS NDS' }}" height="38" style="object-fit: contain;" />
        @else
            <div class="d-inline-flex align-items-center justify-content-center bg-primary text-white rounded-3 p-2 me-2 shadow-sm" style="width: 36px; height: 36px;">
                <i class="material-icons" style="font-size: 20px;">account_balance</i>
            </div>
        @endif
        <span class="fw-bold ms-2 fs-6 text-dark tracking-tight">{{ $appConfig->nombre_app ?? 'JUNTAS NDS' }}</span>
    </a>

    <div class="d-flex align-items-center gap-2">
        @auth
            <a href="{{ route('home') }}" class="btn btn-primary d-inline-flex align-items-center gap-1">
                <i class="material-icons" style="font-size: 18px;">dashboard</i>
                <span>Panel de Control</span>
            </a>
        @else
            @if (Route::has('login'))
                <a href="{{ route('login') }}" class="btn btn-outline-primary d-inline-flex align-items-center gap-1">
                    <i class="material-icons" style="font-size: 18px;">login</i>
                    <span>Iniciar Sesión</span>
                </a>
            @endif
        @endauth
    </div>
</div>
