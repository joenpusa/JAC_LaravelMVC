@extends('layouts.app')

@section('content')
    <div class="container-fluid px-2 px-md-3">
        <!-- Encabezado de página -->
        <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-1 text-xs">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-muted text-decoration-none">Inicio</a></li>
                        <li class="breadcrumb-item active text-primary fw-semibold" aria-current="page">Seguridad</li>
                    </ol>
                </nav>
                <h1 class="page-title">Cambiar Contraseña</h1>
                <p class="page-subtitle mb-0">Actualice su clave de acceso para mantener protegida su cuenta.</p>
            </div>
        </div>

        @include('layouts.alerts')

        <div class="row">
            <div class="col-12 col-lg-7 col-xl-6">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-transparent py-3">
                        <h5 class="mb-0 fw-bold d-flex align-items-center gap-2">
                            <i class="material-icons text-primary" style="font-size: 22px;">lock_reset</i>
                            Credenciales de Acceso
                        </h5>
                    </div>
                    <form action="{{ route('password.update') }}" method="POST">
                        @csrf
                        <div class="card-body p-4">
                            <div class="mb-3">
                                <label for="current_password" class="form-label fw-semibold">Contraseña Actual <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="material-icons text-muted" style="font-size: 18px;">lock_outline</i>
                                    </span>
                                    <input type="password" class="form-control border-start-0 ps-0" id="current_password" name="current_password" required placeholder="Digite su contraseña actual">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="new_password" class="form-label fw-semibold">Nueva Contraseña <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="material-icons text-muted" style="font-size: 18px;">vpn_key</i>
                                    </span>
                                    <input type="password" class="form-control border-start-0 ps-0" id="new_password" name="new_password" required placeholder="Digite la nueva contraseña (mínimo 8 caracteres)">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="new_password_confirmation" class="form-label fw-semibold">Confirmar Nueva Contraseña <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="material-icons text-muted" style="font-size: 18px;">check_circle_outline</i>
                                    </span>
                                    <input type="password" class="form-control border-start-0 ps-0" id="new_password_confirmation" name="new_password_confirmation" required placeholder="Repita la nueva contraseña">
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-light py-3 d-flex justify-content-end gap-2">
                            <a href="{{ route('home') }}" class="btn btn-outline-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-primary d-inline-flex align-items-center gap-1">
                                <i class="material-icons" style="font-size: 18px;">update</i>
                                <span>Actualizar Contraseña</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-12 col-lg-5 col-xl-6">
                <div class="card shadow-sm border-0 mb-4 bg-light">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3 d-flex align-items-center gap-2 text-dark">
                            <i class="material-icons text-primary" style="font-size: 20px;">shield</i>
                            Recomendaciones de Seguridad
                        </h6>
                        <ul class="text-xs text-muted mb-0 ps-3 d-flex flex-column gap-2">
                            <li>Utilice contraseñas que contengan al menos <strong>8 caracteres</strong>.</li>
                            <li>Combine letras mayúsculas, minúsculas, números y símbolos especiales.</li>
                            <li>Evite reutilizar claves de correo electrónico personal o redes sociales.</li>
                            <li>Nunca comparta su clave de acceso con terceros.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
