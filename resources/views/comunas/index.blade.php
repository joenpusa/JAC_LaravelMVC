@extends('layouts.app')

@section('content')
    <div class="container-fluid px-2 px-md-3">
        <!-- Encabezado de página -->
        <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-1 text-xs">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-muted text-decoration-none">Inicio</a></li>
                        <li class="breadcrumb-item active text-primary fw-semibold" aria-current="page">Comunas</li>
                    </ol>
                </nav>
                <h1 class="page-title">Lista de Comunas y Sectores</h1>
                <p class="page-subtitle mb-0">Gestión de divisiones territoriales por municipio.</p>
            </div>
            <div>
                <a href="{{ route('comunas.create') }}" class="btn btn-primary d-inline-flex align-items-center gap-1">
                    <i class="material-icons" style="font-size: 18px;">add</i>
                    <span>Crear Nueva Comuna</span>
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
                            <i class="material-icons text-primary" style="font-size: 22px;">location_city</i>
                            Comunas Registradas
                        </h5>
                    </div>
                    <div class="col-12 col-md-6">
                        <form action="{{ route('comunas.index') }}" method="GET" role="search">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" placeholder="Buscar por nombre o municipio..."
                                    value="{{ request('search') }}">
                                <button class="btn btn-primary d-flex align-items-center gap-1" type="submit">
                                    <i class="material-icons" style="font-size: 18px;">search</i>
                                    <span>Buscar</span>
                                </button>
                                @if(request('search'))
                                    <a href="{{ route('comunas.index') }}" class="btn btn-outline-secondary d-flex align-items-center" title="Limpiar filtro">
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
                            <th class="ps-4">Municipio</th>
                            <th>Nombre de la Comuna / Corregimiento</th>
                            <th class="text-end pe-4">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($comunas as $c)
                            <tr>
                                <td class="ps-4">
                                    <span class="badge bg-light text-dark border px-2 py-1 text-xs">
                                        {{ $c->municipio->nombre_municipio ?? 'N/A' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="fw-semibold text-dark">{{ $c->nombre }}</span>
                                </td>
                                <td class="text-end pe-4">
                                    <form action="{{ route('comunas.destroy', $c->id) }}" method="POST"
                                        style="display:inline;" onsubmit="return confirm('¿Está seguro de eliminar esta comuna?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger d-inline-flex align-items-center gap-1" title="Eliminar">
                                            <i class="material-icons" style="font-size: 16px;">delete</i>
                                            <span>Eliminar</span>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="material-icons mb-2 opacity-50" style="font-size: 48px;">location_off</i>
                                        <p class="mb-1 fw-semibold">No se encontraron comunas</p>
                                        <small>Intente otra búsqueda o registre una nueva comuna.</small>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(method_exists($comunas, 'hasPages') && $comunas->hasPages())
                <div class="card-footer bg-transparent py-3 d-flex justify-content-center">
                    {{ $comunas->appends(['search' => request('search')])->links('pagination::bootstrap-4') }}
                </div>
            @endif
        </div>
    </div>
@endsection
