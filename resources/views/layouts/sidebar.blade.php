<nav class="navbar navbar-vertical navbar-expand-lg">
    <div class="collapse navbar-collapse" id="navbarVerticalCollapse">
        <div class="navbar-vertical-content py-3">
            <ul class="navbar-nav flex-column gap-1" id="navbarVerticalNav">
                <li class="nav-item">
                    <div class="nav-item-wrapper">
                        <a href="{{ route('home') }}" class="nav-link label-1 {{ request()->routeIs('home') ? 'active-route' : '' }}" role="button">
                            <div class="d-flex align-items-center">
                                <span class="nav-link-icon"><i class="material-icons">dashboard</i></span>
                                <span class="nav-link-text-wrapper"><span class="nav-link-text">Inicio</span></span>
                            </div>
                        </a>
                    </div>
                </li>

                <li class="nav-item">
                    <div class="nav-item-wrapper">
                        <a href="{{ route('certificados.index') }}" class="nav-link label-1 {{ request()->routeIs('certificados.*') ? 'active-route' : '' }}" role="button">
                            <div class="d-flex align-items-center">
                                <span class="nav-link-icon"><i class="material-icons">history_edu</i></span>
                                <span class="nav-link-text-wrapper"><span class="nav-link-text">Certificados</span></span>
                            </div>
                        </a>
                    </div>
                </li>

                <li class="nav-item">
                    <div class="nav-item-wrapper">
                        <a href="{{ route('juntas.index') }}" class="nav-link label-1 {{ request()->routeIs('juntas.*') ? 'active-route' : '' }}" role="button">
                            <div class="d-flex align-items-center">
                                <span class="nav-link-icon"><i class="material-icons">diversity_1</i></span>
                                <span class="nav-link-text-wrapper"><span class="nav-link-text">Juntas</span></span>
                            </div>
                        </a>
                    </div>
                </li>

                <li class="nav-item">
                    <div class="nav-item-wrapper">
                        <a href="{{ route('asociaciones.index') }}" class="nav-link label-1 {{ request()->routeIs('asociaciones.*') ? 'active-route' : '' }}" role="button">
                            <div class="d-flex align-items-center">
                                <span class="nav-link-icon"><i class="material-icons">apartment</i></span>
                                <span class="nav-link-text-wrapper"><span class="nav-link-text">Asociaciones</span></span>
                            </div>
                        </a>
                    </div>
                </li>

                <li class="nav-item">
                    <div class="nav-item-wrapper">
                        <a href="{{ route('funcionarios.index') }}" class="nav-link label-1 {{ request()->routeIs('funcionarios.*') ? 'active-route' : '' }}" role="button">
                            <div class="d-flex align-items-center">
                                <span class="nav-link-icon"><i class="material-icons">badge</i></span>
                                <span class="nav-link-text-wrapper"><span class="nav-link-text">Dignatarios</span></span>
                            </div>
                        </a>
                    </div>
                </li>

                <li class="nav-item">
                    <div class="nav-item-wrapper">
                        <a href="{{ route('users.index') }}" class="nav-link label-1 {{ request()->routeIs('users.*') ? 'active-route' : '' }}" role="button">
                            <div class="d-flex align-items-center">
                                <span class="nav-link-icon"><i class="material-icons">manage_accounts</i></span>
                                <span class="nav-link-text-wrapper"><span class="nav-link-text">Usuarios</span></span>
                            </div>
                        </a>
                    </div>
                </li>

                <li class="nav-item mt-2 pt-2 border-top">
                    <div class="nav-item-wrapper">
                        <a href="{{ route('configuracion.index') }}" class="nav-link label-1 {{ request()->routeIs('configuracion.*') ? 'active-route' : '' }}" role="button">
                            <div class="d-flex align-items-center">
                                <span class="nav-link-icon"><i class="material-icons">tune</i></span>
                                <span class="nav-link-text-wrapper"><span class="nav-link-text">Configuración</span></span>
                            </div>
                        </a>
                    </div>
                </li>

                <li class="nav-item">
                    <div class="nav-item-wrapper">
                        <a href="{{ route('password.change') }}" class="nav-link label-1 {{ request()->routeIs('password.change') ? 'active-route' : '' }}" role="button">
                            <div class="d-flex align-items-center">
                                <span class="nav-link-icon"><i class="material-icons">lock_reset</i></span>
                                <span class="nav-link-text-wrapper"><span class="nav-link-text">Cambiar clave</span></span>
                            </div>
                        </a>
                    </div>
                </li>

                <li class="nav-item mt-2">
                    <div class="nav-item-wrapper">
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                        <a href="#" class="nav-link label-1 text-danger" role="button"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <div class="d-flex align-items-center">
                                <span class="nav-link-icon text-danger"><i class="material-icons">logout</i></span>
                                <span class="nav-link-text-wrapper"><span class="nav-link-text fw-semibold">Salir</span></span>
                            </div>
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
