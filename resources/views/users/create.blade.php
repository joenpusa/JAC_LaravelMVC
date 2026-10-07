@extends('layouts.app')

@section('content')
    <div class="container-fluid px-2 px-md-3">
        <!-- Encabezado de página -->
        <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-1 text-xs">
                        <li class="breadcrumb-item"><a href="{{ route('users.index') }}" class="text-muted text-decoration-none">Usuarios</a></li>
                        <li class="breadcrumb-item active text-primary fw-semibold" aria-current="page">Crear</li>
                    </ol>
                </nav>
                <h1 class="page-title">Crear Nuevo Usuario</h1>
                <p class="page-subtitle mb-0">Registre una nueva cuenta de acceso con credenciales y permisos específicos.</p>
            </div>
            <div>
                <a href="{{ route('users.index') }}" class="btn btn-outline-secondary d-inline-flex align-items-center gap-1">
                    <i class="material-icons" style="font-size: 18px;">arrow_back</i>
                    <span>Volver al listado</span>
                </a>
            </div>
        </div>

        @include('layouts.alerts')

        <div class="row">
            <div class="col-12 col-lg-8">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-transparent py-3">
                        <h5 class="mb-0 fw-bold d-flex align-items-center gap-2">
                            <i class="material-icons text-primary" style="font-size: 22px;">person_add</i>
                            Datos de la Cuenta
                        </h5>
                    </div>
                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-12 col-md-6">
                                    <label for="name" class="form-label fw-semibold">Nombre Completo <span class="text-danger">*</span></label>
                                    <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control" required placeholder="Nombre y apellidos">
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="email" class="form-label fw-semibold">Correo Electrónico <span class="text-danger">*</span></label>
                                    <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-control" required placeholder="correo@ejemplo.com">
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="password" class="form-label fw-semibold">Contraseña <span class="text-danger">*</span></label>
                                    <input type="password" name="password" id="password" class="form-control" required placeholder="Mínimo 8 caracteres">
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="password_confirmation" class="form-label fw-semibold">Confirmar Contraseña <span class="text-danger">*</span></label>
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required placeholder="Repita la contraseña">
                                </div>
                                <div class="col-12">
                                    <label for="role_id" class="form-label fw-semibold">Rol Asignado <span class="text-danger">*</span></label>
                                    <select name="role_id" id="role_id" class="form-select" required>
                                        <option value="">Seleccione un rol...</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                                {{ ucfirst($role->name) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-light py-3 d-flex justify-content-end gap-2">
                            <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-primary d-inline-flex align-items-center gap-1">
                                <i class="material-icons" style="font-size: 18px;">save</i>
                                <span>Crear Usuario</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="card shadow-sm border-0 mb-4 bg-primary-subtle text-primary-emphasis">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="material-icons text-primary" style="font-size: 24px;">security</i>
                            <h6 class="fw-bold mb-0 text-primary">Información de Seguridad</h6>
                        </div>
                        <p class="text-xs mb-2">
                            Al crear una cuenta de usuario, asegúrese de otorgar el rol adecuado para evitar accesos privilegiados indebidos.
                        </p>
                        <ul class="text-xs ps-3 mb-0">
                            <li>El rol <strong>Administrador</strong> tiene acceso a configuración, importación masiva y gestión de usuarios.</li>
                            <li>Los roles de consulta u operador están restringidos según sus funciones asignadas.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
