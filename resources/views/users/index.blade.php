@extends('layouts.app')

@section('content')
    <div class="container-fluid px-2 px-md-3">
        <!-- Encabezado de página -->
        <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-1 text-xs">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-muted text-decoration-none">Inicio</a></li>
                        <li class="breadcrumb-item active text-primary fw-semibold" aria-current="page">Usuarios</li>
                    </ol>
                </nav>
                <h1 class="page-title">Gestión de Usuarios</h1>
                <p class="page-subtitle mb-0">Administre las cuentas de acceso, roles y estados de los usuarios del sistema.</p>
            </div>
            <div>
                <a href="{{ route('users.create') }}" class="btn btn-primary d-inline-flex align-items-center gap-1">
                    <i class="material-icons" style="font-size: 18px;">person_add</i>
                    <span>Crear Nuevo Usuario</span>
                </a>
            </div>
        </div>

        @include('layouts.alerts')

        <!-- Tarjeta de Contenido y Tabla -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-transparent py-3">
                <div class="row align-items-center g-2">
                    <div class="col-12 col-md-6">
                        <h5 class="mb-0 fw-bold d-flex align-items-center gap-2">
                            <i class="material-icons text-primary" style="font-size: 22px;">manage_accounts</i>
                            Usuarios del Sistema
                        </h5>
                    </div>
                    <div class="col-12 col-md-6">
                        <form action="{{ route('users.index') }}" method="GET" role="search">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" placeholder="Buscar por nombre o correo..."
                                    value="{{ request('search') }}">
                                <button class="btn btn-primary d-flex align-items-center gap-1" type="submit">
                                    <i class="material-icons" style="font-size: 18px;">search</i>
                                    <span>Buscar</span>
                                </button>
                                @if(request('search'))
                                    <a href="{{ route('users.index') }}" class="btn btn-outline-secondary d-flex align-items-center" title="Limpiar filtro">
                                        <i class="material-icons" style="font-size: 18px;">close</i>
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-uppercase text-xs fw-bold text-muted">
                        <tr>
                            <th class="ps-4">Usuario</th>
                            <th>Correo Electrónico</th>
                            <th>Rol Asignado</th>
                            <th>Estado</th>
                            <th class="text-end pe-4">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="avatar-circle rounded-circle bg-primary-subtle text-primary fw-bold d-flex align-items-center justify-content-center"
                                            style="width: 38px; height: 38px; font-size: 0.85rem; flex-shrink: 0;">
                                            {{ strtoupper(substr($user->name, 0, 2)) }}
                                        </div>
                                        <div>
                                            <span class="fw-semibold text-dark d-block">{{ $user->name }}</span>
                                            @if($user->id === auth()->id())
                                                <span class="badge bg-primary text-white text-xs px-2 py-0">Tú</span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-secondary text-sm d-inline-flex align-items-center gap-1">
                                        <i class="material-icons text-muted" style="font-size: 16px;">email</i>
                                        {{ $user->email }}
                                    </span>
                                </td>
                                <td>
                                    @php
                                        $roleName = strtolower($user->role->name ?? '');
                                    @endphp
                                    <span class="badge {{ $roleName === 'administrador' ? 'bg-primary-subtle text-primary border border-primary-subtle' : 'bg-light text-dark border' }} px-3 py-1 text-xs text-capitalize fw-semibold">
                                        {{ $user->role->name ?? 'Sin Rol' }}
                                    </span>
                                </td>
                                <td>
                                    @if ($user->activo)
                                        <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 text-xs d-inline-flex align-items-center gap-1">
                                            <i class="material-icons" style="font-size: 13px;">check_circle</i>
                                            Activo
                                        </span>
                                    @else
                                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1 text-xs d-inline-flex align-items-center gap-1">
                                            <i class="material-icons" style="font-size: 13px;">cancel</i>
                                            Inactivo
                                        </span>
                                    @endif
                                </td>
                                <td class="text-end pe-4">
                                    @if (auth()->user()->role && auth()->user()->role->name === 'administrador')
                                        <div class="d-inline-flex align-items-center gap-1">
                                            <form action="{{ route('users.toggleActive', $user) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm {{ $user->activo ? 'btn-outline-danger' : 'btn-outline-success' }} d-inline-flex align-items-center gap-1"
                                                    title="{{ $user->activo ? 'Desactivar acceso al sistema' : 'Activar acceso al sistema' }}">
                                                    <i class="material-icons" style="font-size: 16px;">{{ $user->activo ? 'block' : 'check_circle' }}</i>
                                                    <span>{{ $user->activo ? 'Desactivar' : 'Activar' }}</span>
                                                </button>
                                            </form>
                                            <form action="{{ route('users.resetPassword', $user) }}" method="POST" style="display:inline;"
                                                onsubmit="return confirm('¿Restablecer la contraseña de este usuario a la predeterminada?');">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-outline-warning d-inline-flex align-items-center gap-1" title="Restablecer contraseña">
                                                    <i class="material-icons" style="font-size: 16px;">lock_reset</i>
                                                    <span>Restablecer</span>
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="material-icons mb-2 opacity-50" style="font-size: 48px;">group_off</i>
                                        <p class="mb-1 fw-semibold">No se encontraron usuarios</p>
                                        <small>Intente otra búsqueda o cree una nueva cuenta.</small>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($users->hasPages())
                <div class="card-footer bg-transparent py-3 d-flex justify-content-center">
                    {{ $users->appends(['search' => request('search')])->links('pagination::bootstrap-4') }}
                </div>
            @endif
        </div>
    </div>
@endsection
