@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Lista de Juntas</h1>
        <div class="d-flex mb-3 gap-2">
            <a href="{{ route('juntas.create') }}" class="btn btn-primary">Crear Nueva</a>
            <!-- Botón para abrir la modal de exportación -->
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exportModal">
                Exportar
            </button>
            @if(auth()->check() && auth()->user()->role && auth()->user()->role->name === 'administrador')
                <!-- Botón para abrir la modal de importación masiva -->
                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#importModal">
                    Importar Masivo
                </button>
            @endif
        </div>
        
        @if ($errors->any() || ($message = Session::get('error')))
            <div class="alert alert-danger alert-dismissible text-white" role="alert">
                <span class="text-sm">
                    <p>Proceso no realizado:</p>
                    <ul>
                        {{ $message ?? '' }}
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </span>
                <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-dismissible text-white" role="alert">
                <span class="text-sm">{{ $message }} </span>
                <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <form action="{{ route('juntas.index') }}" method="GET" role="search">
            <div class="input-group mb-3">
                <input type="text" name="search" class="form-control" placeholder="Buscar juntas..."
                    value="{{ request('search') }}">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit">Buscar</button>
                </div>
            </div>
        </form>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Municipio</th>
                    <th>Razón social</th>
                    <th>Resolución</th>
                    <th>Presidente</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($juntas as $j)
                    <tr>
                        <td>{{ $j->municipio->nombre_municipio ?? 'N/A' }}</td>
                        <td>{{ $j->nombre }}</td>
                        <td>{{ $j->resolucion }}</td>
                        <td>{{ $j->presidente->nombre ?? 'Sin presidente asignado' }}</td>
                        <td>
                            <a href="{{ route('juntas.edit', $j->id) }}" class="btn btn-warning">Editar</a>
                            <form action="{{ route('juntas.destroy', $j->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-center">
            {{ $juntas->appends(['search' => request('search')])->links('pagination::bootstrap-4') }}
        </div>
    </div>

    <!-- Modal de Exportación -->
    <div class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="exportModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="GET" action="{{ route('juntas.export') }}">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exportModalLabel">Exportar Juntas por Municipio</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="municipio_id" class="form-label">Selecciona un municipio</label>
                            <select name="municipio_id" id="municipio_id" class="form-select" required>
                                <option value="all" selected>-- Todos los municipios --</option>
                                @foreach ($municipios as $municipio)
                                    <option value="{{ $municipio->id }}">{{ $municipio->nombre_municipio }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Descargar Excel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal de Importación Masiva -->
    @if(auth()->check() && auth()->user()->role && auth()->user()->role->name === 'administrador')
    <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importModalLabel">Importar Juntas (Masivo)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('juntas.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="file" class="form-label">Seleccionar archivo (CSV, Excel)</label>
                            <input class="form-control" type="file" id="file" name="file" required accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                            <div class="form-text">
                                El archivo debe contener las columnas: MUNICIPIO, AUTO No., TIPO AUTO, FECHA AUTO, FECHA ELECCION, FECHA INICIO PERIODO, FECHA FINAL PERIODO, NOMBRE O.A.C., PERSONERIA JURIDICA No., TIPO O.A.C., ZONA, # DOCUMENTO PRESIDENTE, # DOCUMENTO VICEPRESIDENTE, # DOCUMENTO SECRETARIO, # DOCUMENTO TESORERO, # DOCUMENTO FISCAL.
                                <br>
                                <a href="{{ asset('ejemplo_juntas.csv') }}" class="btn btn-link btn-sm p-0 mt-1" download>Descargar archivo de referencia</a>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success">Importar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

@endsection
