<nav class="navbar navbar-vertical navbar-expand-lg">
    <div class="collapse navbar-collapse" id="navbarVerticalCollapse">
        <div class="navbar-vertical-content">
            <ul class="navbar-nav flex-column" id="navbarVerticalNav">
                <li class="nav-item">
                    <div class="nav-item-wrapper">
                        <a href="{{ route('home') }}" class="nav-link label-1" role="button" data-bs-toggle=""
                            aria-expanded="false">
                            <div class="d-flex align-items-center">
                                <span class="nav-link-icon"><i class="material-icons opacity-10">home</i></span><span
                                    class="nav-link-text-wrapper"><span class="nav-link-text">Inicio</span></span>
                            </div>
                        </a>
                    </div>
                </li>
                <li class="nav-item">
                    <div class="nav-item-wrapper">
                        <a href="{{ route('comunas.index') }}" class="nav-link label-1" role="button" data-bs-toggle=""
                            aria-expanded="false">
                            <div class="d-flex align-items-center">
                                <span class="nav-link-icon"><i
                                        class="material-icons opacity-10">location_city</i></span><span
                                    class="nav-link-text-wrapper"><span class="nav-link-text">Comunas</span></span>
                            </div>
                        </a>
                    </div>
                </li>
                <li class="nav-item">
                    <div class="nav-item-wrapper">
                        <a href="{{ route('certificados.index') }}" class="nav-link label-1" role="button"
                            data-bs-toggle="" aria-expanded="false">
                            <div class="d-flex align-items-center">
                                <span class="nav-link-icon"><i
                                        class="material-icons opacity-10">history_edu</i></span><span
                                    class="nav-link-text-wrapper"><span class="nav-link-text">Certificados</span></span>
                            </div>
                        </a>
                    </div>
                </li>
                <li class="nav-item">
                    <div class="nav-item-wrapper">
                        <a href="{{ route('juntas.index') }}" class="nav-link label-1" role="button" data-bs-toggle=""
                            aria-expanded="false">
                            <div class="d-flex align-items-center">
                                <span class="nav-link-icon"><i
                                        class="material-icons opacity-10">diversity_1</i></span><span
                                    class="nav-link-text-wrapper"><span class="nav-link-text">Juntas</span></span>
                            </div>
                        </a>
                    </div>
                </li>
                <li class="nav-item">
                    <div class="nav-item-wrapper">
                        <a href="{{ route('asociaciones.index') }}" class="nav-link label-1" role="button"
                            data-bs-toggle="" aria-expanded="false">
                            <div class="d-flex align-items-center">
                                <span class="nav-link-icon"><i
                                        class="material-icons opacity-10">apartment</i></span><span
                                    class="nav-link-text-wrapper"><span class="nav-link-text">Asociaciones</span></span>
                            </div>
                        </a>
                    </div>
                </li>
                <li class="nav-item">
                    <div class="nav-item-wrapper">
                        <a href="{{ route('funcionarios.index') }}" class="nav-link label-1" role="button"
                            data-bs-toggle="" aria-expanded="false">
                            <div class="d-flex align-items-center">
                                <span class="nav-link-icon"><i class="material-icons opacity-10">badge</i></span><span
                                    class="nav-link-text-wrapper"><span class="nav-link-text">Dignatarios</span></span>
                            </div>
                        </a>
                    </div>
                </li>
                <li class="nav-item">
                    <div class="nav-item-wrapper">
                        <a href="{{ route('users.index') }}" class="nav-link label-1" role="button" data-bs-toggle=""
                            aria-expanded="false">
                            <div class="d-flex align-items-center">
                                <span class="nav-link-icon"><i
                                        class="material-icons opacity-10">folder_shared</i></span><span
                                    class="nav-link-text-wrapper"><span class="nav-link-text">Usuarios</span></span>
                            </div>
                        </a>
                    </div>
                </li>
                <li class="nav-item">
                    <div class="nav-item-wrapper">
                        <a href="{{ route('configuracion.index') }}" class="nav-link label-1" role="button"
                            data-bs-toggle="" aria-expanded="false">
                            <div class="d-flex align-items-center">
                                <span class="nav-link-icon"><i class="material-icons opacity-10">tune</i></span><span
                                    class="nav-link-text-wrapper"><span
                                        class="nav-link-text">Configuración</span></span>
                            </div>
                        </a>
                    </div>
                </li>
                <li class="nav-item">
                    <div class="nav-item-wrapper">
                        <a href="{{ route('password.change') }}" class="nav-link label-1" role="button"
                            data-bs-toggle="" aria-expanded="false">
                            <div class="d-flex align-items-center">
                                <span class="nav-link-icon"><i
                                        class="material-icons opacity-10">lock_clock</i></span><span
                                    class="nav-link-text-wrapper"><span class="nav-link-text">Cambiar
                                        clave</span></span>
                            </div>
                        </a>
                    </div>
                </li>
                <li class="nav-item">
                    <div class="nav-item-wrapper">
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                        <a href="#" class="nav-link label-1" role="button"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <div class="d-flex align-items-center">
                                <span class="nav-link-icon"><i class="material-icons opacity-10">logout</i></span>
                                <span class="nav-link-text-wrapper">
                                    <span class="nav-link-text">Salir</span>
                                </span>
                            </div>
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
