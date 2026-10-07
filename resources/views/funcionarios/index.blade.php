@extends('layouts.app')

@section('content')
    <div class="container-fluid px-2 px-md-3">
        <!-- Encabezado de página -->
        <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-1 text-xs">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-muted text-decoration-none">Inicio</a></li>
                        <li class="breadcrumb-item active text-primary fw-semibold" aria-current="page">Dignatarios</li>
                    </ol>
                </nav>
                <h1 class="page-title">Lista de Dignatarios</h1>
                <p class="page-subtitle mb-0">Gestión de líderes y miembros acreditados de juntas y asociaciones.</p>
            </div>
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <a href="{{ route('funcionarios.create') }}" class="btn btn-primary d-inline-flex align-items-center gap-1">
                    <i class="material-icons" style="font-size: 18px;">add</i>
                    <span>Crear Nuevo</span>
                </a>
                @if(auth()->check() && auth()->user()->role && auth()->user()->role->name === 'administrador')
                    <button type="button" class="btn btn-outline-primary d-inline-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#importModal">
                        <i class="material-icons" style="font-size: 18px;">upload_file</i>
                        <span>Importar Masivo</span>
                    </button>
                @endif
            </div>
        </div>

        @include('layouts.alerts')

        <!-- Tarjeta de Contenido y Tabla -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-transparent py-3">
                <div class="row align-items-center g-2">
                    <div class="col-12 col-md-6">
                        <h5 class="mb-0 fw-bold d-flex align-items-center gap-2">
                            <i class="material-icons text-primary" style="font-size: 22px;">badge</i>
                            Directorio de Dignatarios
                        </h5>
                    </div>
                    <div class="col-12 col-md-6">
                        <form action="{{ route('funcionarios.index') }}" method="GET" role="search">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" placeholder="Buscar por nombre o documento..."
                                    value="{{ request('search') }}">
                                <button class="btn btn-primary d-flex align-items-center gap-1" type="submit">
                                    <i class="material-icons" style="font-size: 18px;">search</i>
                                    <span>Buscar</span>
                                </button>
                                @if(request('search'))
                                    <a href="{{ route('funcionarios.index') }}" class="btn btn-outline-secondary d-flex align-items-center" title="Limpiar filtro">
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
                            <th class="ps-4">Dignatario</th>
                            <th>Tipo Documento</th>
                            <th>Núm. Documento</th>
                            <th>Email de Contacto</th>
                            <th class="text-end pe-4">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($funcionarios as $funcionario)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="avatar-circle rounded-circle bg-primary-subtle text-primary fw-bold d-flex align-items-center justify-content-center"
                                            style="width: 38px; height: 38px; font-size: 0.85rem; flex-shrink: 0;">
                                            {{ strtoupper(substr($funcionario->nombre, 0, 2)) }}
                                        </div>
                                        <div>
                                            <span class="fw-semibold text-dark d-block">{{ $funcionario->nombre }}</span>
                                            @if($funcionario->profesion)
                                                <small class="text-muted text-xs">{{ $funcionario->profesion }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border px-2 py-1 text-xs">
                                        {{ $funcionario->tipo_documento ?? 'No registrado' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="font-monospace fw-semibold text-secondary">{{ $funcionario->num_documento }}</span>
                                </td>
                                <td>
                                    @if($funcionario->email)
                                        <a href="mailto:{{ $funcionario->email }}" class="text-decoration-none text-muted d-inline-flex align-items-center gap-1 text-sm hover-primary">
                                            <i class="material-icons text-primary" style="font-size: 16px;">email</i>
                                            {{ $funcionario->email }}
                                        </a>
                                    @else
                                        <span class="text-muted text-xs">Sin correo</span>
                                    @endif
                                </td>
                                <td class="text-end pe-4">
                                    <div class="d-inline-flex align-items-center gap-1">
                                        <a href="{{ route('funcionarios.edit', $funcionario->id) }}" class="btn btn-sm btn-outline-warning d-inline-flex align-items-center gap-1" title="Editar">
                                            <i class="material-icons" style="font-size: 16px;">edit</i>
                                            <span>Editar</span>
                                        </a>
                                        <form action="{{ route('funcionarios.destroy', $funcionario->id) }}" method="POST"
                                            style="display:inline;" onsubmit="return confirm('¿Está seguro de eliminar este dignatario?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger d-inline-flex align-items-center gap-1" title="Eliminar">
                                                <i class="material-icons" style="font-size: 16px;">delete</i>
                                                <span>Eliminar</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="material-icons mb-2 opacity-50" style="font-size: 48px;">person_off</i>
                                        <p class="mb-1 fw-semibold">No se encontraron dignatarios</p>
                                        <small>Intente una búsqueda diferente o cree un nuevo dignatario.</small>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($funcionarios->hasPages())
                <div class="card-footer bg-transparent py-3 d-flex justify-content-center">
                    {{ $funcionarios->appends(['search' => request('search')])->links('pagination::bootstrap-4') }}
                </div>
            @endif
        </div>
    </div>

    @if(auth()->check() && auth()->user()->role && auth()->user()->role->name === 'administrador')
    <!-- Modal para Importar Masivo -->
    <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
                <div class="modal-header border-bottom py-3">
                    <h5 class="modal-title fw-bold d-flex align-items-center gap-2" id="importModalLabel">
                        <i class="material-icons text-primary" style="font-size: 22px;">upload_file</i>
                        Importar Dignatarios (Masivo)
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('funcionarios.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label for="file" class="form-label fw-semibold">Seleccionar archivo (CSV, Excel) <span class="text-danger">*</span></label>
                            <input class="form-control" type="file" id="file" name="file" required accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                            <div class="form-text mt-2 text-xs">
                                <i class="material-icons align-middle text-info" style="font-size: 14px;">info</i>
                                El archivo debe contener los encabezados: <strong>NOMBRE, CEDULA, CELULAR</strong>.
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-top py-3">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary d-inline-flex align-items-center gap-1">
                            <i class="material-icons" style="font-size: 18px;">cloud_upload</i>
                            <span>Cargar e Importar</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
@endsection
