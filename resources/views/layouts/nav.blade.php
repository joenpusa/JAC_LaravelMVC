<div class="collapse navbar-collapse justify-content-between px-3">
    <div class="navbar-logo d-flex align-items-center">
        <button class="btn navbar-toggler navbar-toggler-humburger-icon hover-bg-transparent me-2" type="button"
            data-bs-toggle="collapse" data-bs-target="#navbarVerticalCollapse" aria-controls="navbarVerticalCollapse"
            aria-expanded="false" aria-label="Toggle Navigation">
            <span class="navbar-toggle-icon"><span class="toggle-line"></span></span>
        </button>
        <a class="navbar-brand me-1 me-sm-3 d-flex align-items-center" href="{{ route('home') }}">
            @if(isset($appConfig) && $appConfig->logo)
                <img src="{{ asset($appConfig->logo) }}" alt="{{ $appConfig->nombre_app ?? 'JUNTAS NDS' }}" height="38" style="object-fit: contain;" />
            @else
                <div class="d-inline-flex align-items-center justify-content-center bg-primary text-white rounded-3 p-2 me-2 shadow-sm" style="width: 36px; height: 36px;">
                    <i class="material-icons" style="font-size: 20px;">account_balance</i>
                </div>
            @endif
            <span class="fw-bold ms-2 fs-6 text-dark tracking-tight">{{ $appConfig->nombre_app ?? 'JUNTAS NDS' }}</span>
        </a>
    </div>

    @if(auth()->check())
        <ul class="navbar-nav navbar-nav-icons ms-auto flex-row align-items-center gap-2">
            <li class="nav-item dropdown">
                <a class="nav-link text-decoration-none p-0" id="navbarDropdownUser" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="user-profile-chip d-flex align-items-center gap-2">
                        <div class="user-avatar-initials">
                            {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                        </div>
                        <div class="d-none d-md-block text-start pe-1">
                            <span class="fw-bold text-dark d-block text-truncate" style="max-width: 140px; font-size: 0.85rem; line-height: 1.2;">
                                {{ auth()->user()->name }}
                            </span>
                            <small class="text-muted text-uppercase fw-semibold" style="font-size: 0.68rem; letter-spacing: 0.05em;">
                                {{ auth()->user()->role->name ?? 'Usuario' }}
                            </small>
                        </div>
                        <i class="material-icons text-muted" style="font-size: 18px;">expand_more</i>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-3 py-2 mt-2" aria-labelledby="navbarDropdownUser" style="min-width: 220px;">
                    <li class="px-3 py-2 border-bottom mb-1">
                        <span class="fw-bold text-dark d-block text-sm">{{ auth()->user()->name }}</span>
                        <span class="text-muted text-truncate d-block" style="font-size: 0.775rem;">{{ auth()->user()->email }}</span>
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="{{ route('password.change') }}">
                            <i class="material-icons text-muted" style="font-size: 18px;">lock_reset</i>
                            <span>Cambiar contraseña</span>
                        </a>
                    </li>
                    @if(auth()->user()->role && auth()->user()->role->name === 'administrador')
                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="{{ route('configuracion.index') }}">
                                <i class="material-icons text-muted" style="font-size: 18px;">settings</i>
                                <span>Configuración</span>
                            </a>
                        </li>
                    @endif
                    <li><hr class="dropdown-divider my-1"></li>
                    <li>
                        <form id="logout-form-nav" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                        <a class="dropdown-item d-flex align-items-center gap-2 py-2 text-danger" href="#"
                            onclick="event.preventDefault(); document.getElementById('logout-form-nav').submit();">
                            <i class="material-icons text-danger" style="font-size: 18px;">logout</i>
                            <span>Cerrar sesión</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    @endif
</div>
