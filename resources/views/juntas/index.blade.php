@extends('layouts.app')

@section('content')
    <div class="container-fluid px-2 px-md-3">
        <!-- Encabezado de página y botones de acción -->
        <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-1 text-xs">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-muted text-decoration-none">Inicio</a></li>
                        <li class="breadcrumb-item active text-primary fw-semibold" aria-current="page">Juntas</li>
                    </ol>
                </nav>
                <h1 class="page-title">Lista de Juntas</h1>
                <p class="page-subtitle mb-0">Gestión de Juntas de Acción Comunal (JAC) registradas en el departamento.</p>
            </div>
            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('juntas.create') }}" class="btn btn-primary shadow-sm">
                    <i class="material-icons" style="font-size: 18px;">add</i> Crear Nueva
                </a>
                <button type="button" class="btn btn-success shadow-sm" data-bs-toggle="modal" data-bs-target="#exportModal">
                    <i class="material-icons" style="font-size: 18px;">download</i> Exportar
                </button>
                @if(auth()->check() && auth()->user()->role && auth()->user()->role->name === 'administrador')
                    <button type="button" class="btn btn-warning text-white shadow-sm" data-bs-toggle="modal" data-bs-target="#importModal">
                        <i class="material-icons" style="font-size: 18px;">upload_file</i> Importar Masivo
                    </button>
                @endif
            </div>
        </div>

        @include('layouts.alerts')

        <!-- Tarjeta de listado -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-transparent py-3">
                <div class="row align-items-center justify-content-between g-3">
                    <div class="col-12 col-md-5">
                        <form action="{{ route('juntas.index') }}" method="GET" role="search">
                            <div class="search-box-wrap">
                                <i class="material-icons search-icon">search</i>
                                <input type="text" name="search" class="form-control" placeholder="Buscar por municipio, razón social o presidente..."
                                    value="{{ request('search') }}">
                                <button class="btn btn-primary btn-sm" type="submit">Buscar</button>
                            </div>
                        </form>
                    </div>
                    @if(request('search'))
                        <div class="col-auto">
                            <a href="{{ route('juntas.index') }}" class="btn btn-sm btn-outline-secondary">
                                <i class="material-icons" style="font-size: 16px;">clear</i> Limpiar búsqueda
                            </a>
                        </div>
                    @endif
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Municipio</th>
                                <th>Razón Social</th>
                                <th>Resolución</th>
                                <th>Presidente Actual</th>
                                <th class="text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($juntas as $j)
                                <tr>
                                    <td>
                                        <span class="badge bg-light text-dark border px-2 py-1 fw-bold">
                                            {{ $j->municipio->nombre_municipio ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="fw-bold text-dark">{{ $j->nombre }}</div>
                                    </td>
                                    <td>
                                        @if($j->resolucion)
                                            <span class="fw-semibold text-secondary">{{ $j->resolucion }}</span>
                                        @else
                                            <span class="text-muted fst-italic text-sm">Sin resolución</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($j->presidente && $j->presidente->nombre)
                                            <div class="fw-semibold text-dark">{{ $j->presidente->nombre }}</div>
                                            <small class="text-muted">{{ $j->presidente->num_documento ?? '' }}</small>
                                        @else
                                            <span class="text-muted fst-italic text-sm">Sin asignar</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <div class="d-inline-flex gap-1">
                                            <a href="{{ route('juntas.edit', $j->id) }}" class="btn btn-sm btn-outline-warning" title="Editar">
                                                <i class="material-icons" style="font-size: 16px;">edit</i> Editar
                                            </a>
                                            <form action="{{ route('juntas.destroy', $j->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Está seguro de eliminar esta junta?')" title="Eliminar">
                                                    <i class="material-icons" style="font-size: 16px;">delete</i> Eliminar
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <i class="material-icons d-block mb-2 text-muted" style="font-size: 48px;">diversity_1</i>
                                        No se encontraron juntas registradas.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if ($juntas->hasPages())
                <div class="card-footer bg-transparent py-3 border-top d-flex justify-content-center">
                    {{ $juntas->appends(['search' => request('search')])->links('pagination::bootstrap-4') }}
                </div>
            @endif
        </div>
    </div>

    <!-- Modal de Exportación -->
    <div class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="exportModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="GET" action="{{ route('juntas.export') }}">
                <div class="modal-content border-0 shadow-lg rounded-4">
                    <div class="modal-header border-bottom py-3">
                        <h5 class="modal-title fw-bold" id="exportModalLabel">Exportar Juntas por Municipio</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label for="municipio_id" class="form-label">Selecciona un municipio</label>
                            <select name="municipio_id" id="municipio_id" class="form-select" required>
                                <option value="all" selected>-- Todos los municipios --</option>
                                @foreach ($municipios as $municipio)
                                    <option value="{{ $municipio->id }}">{{ $municipio->nombre_municipio }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="p-3 bg-light rounded-3 text-muted text-xs">
                            El archivo Excel generado incluirá toda la información de cada junta (datos básicos, fechas, autos, período) y la información completa de sus dignatarios (Presidente, Vicepresidente, Secretario, Tesorero, Fiscal y Comisionados).
                        </div>
                    </div>
                    <div class="modal-footer border-top py-2">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success btn-sm">Descargar Excel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal de Importación Masiva -->
    @if(auth()->check() && auth()->user()->role && auth()->user()->role->name === 'administrador')
    <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header border-bottom py-3">
                    <h5 class="modal-title fw-bold" id="importModalLabel">Importar Juntas (Masivo)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <form action="{{ route('juntas.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label for="file" class="form-label">Seleccionar archivo (CSV, Excel)</label>
                            <input class="form-control" type="file" id="file" name="file" required accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                            <div class="form-text mt-2">
                                El archivo debe contener las columnas: MUNICIPIO, AUTO No., TIPO AUTO, FECHA AUTO, FECHA ELECCION, FECHA INICIO PERIODO, FECHA FINAL PERIODO, NOMBRE O.A.C., PERSONERIA JURIDICA No., TIPO O.A.C., ZONA, # DOCUMENTO PRESIDENTE, # DOCUMENTO VICEPRESIDENTE, # DOCUMENTO SECRETARIO, # DOCUMENTO TESORERO, # DOCUMENTO FISCAL.
                                <div class="mt-2">
                                    <a href="{{ asset('ejemplo_juntas.csv') }}" class="btn btn-link btn-sm p-0" download>Descargar archivo de referencia</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-top py-2">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success btn-sm">Importar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
@endsection
