@extends('layouts.app')

@section('content')
    <div class="container-fluid px-2 px-md-3">
        <!-- Encabezado de página -->
        <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-1 text-xs">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-muted text-decoration-none">Inicio</a></li>
                        <li class="breadcrumb-item active text-primary fw-semibold" aria-current="page">Certificados</li>
                    </ol>
                </nav>
                <h1 class="page-title">Historial de Certificados</h1>
                <p class="page-subtitle mb-0">Registro y trazabilidad de todos los certificados emitidos a dignatarios comunales.</p>
            </div>
        </div>

        @include('layouts.alerts')

        <!-- Tarjeta principal de listado -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-transparent py-3">
                <div class="row align-items-center justify-content-between g-3">
                    <div class="col-12 col-md-5">
                        <form action="{{ route('certificados.index') }}" method="GET" role="search">
                            <div class="search-box-wrap">
                                <i class="material-icons search-icon">search</i>
                                <input type="text" name="search" class="form-control" placeholder="Buscar por dignatario, documento, junta o código..."
                                    value="{{ request('search') }}">
                                <button class="btn btn-primary btn-sm" type="submit">Buscar</button>
                            </div>
                        </form>
                    </div>
                    @if(request('search'))
                        <div class="col-auto">
                            <a href="{{ route('certificados.index') }}" class="btn btn-sm btn-outline-secondary">
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
                                <th>Fecha Generación</th>
                                <th>Municipio - Entidad</th>
                                <th>Doc. Dignatario</th>
                                <th>Dignatario Certificado</th>
                                <th>Código Verificación</th>
                                <th class="text-center">Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($certificados as $c)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="material-icons text-muted" style="font-size: 18px;">event</i>
                                            <span class="fw-semibold">{{ $c->created_at->format('d/m/Y') }}</span>
                                            <small class="text-muted">{{ $c->created_at->format('H:i') }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="fw-bold text-dark">{{ $c->nombre_junta }}</div>
                                        <small class="text-muted">{{ $c->comuna }}</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark border font-monospace px-2 py-1">
                                            {{ $c->documento_dignario }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="fw-semibold text-dark">{{ $c->nombre_dignatario }}</div>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary-subtle text-secondary font-monospace px-2 py-1">
                                            {{ $c->codigo_hash }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        @if(strtolower($c->verificado) === 'si')
                                            <span class="badge-status success">
                                                <i class="material-icons" style="font-size: 13px;">verified</i> Verificado
                                            </span>
                                        @else
                                            <span class="badge-status inactive">
                                                <i class="material-icons" style="font-size: 13px;">schedule</i> Pendiente
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="material-icons d-block mb-2 text-muted" style="font-size: 48px;">history_edu</i>
                                        No se encontraron certificados registrados.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if ($certificados->hasPages())
                <div class="card-footer bg-transparent py-3 border-top d-flex justify-content-center">
                    {{ $certificados->appends(['search' => request('search')])->links('pagination::bootstrap-4') }}
                </div>
            @endif
        </div>
    </div>
@endsection
