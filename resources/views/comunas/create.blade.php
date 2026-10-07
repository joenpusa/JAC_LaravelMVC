@extends('layouts.app')

@section('content')
    <div class="container-fluid px-2 px-md-3">
        <!-- Encabezado de página -->
        <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-1 text-xs">
                        <li class="breadcrumb-item"><a href="{{ route('comunas.index') }}" class="text-muted text-decoration-none">Comunas</a></li>
                        <li class="breadcrumb-item active text-primary fw-semibold" aria-current="page">{{ isset($comuna) ? 'Editar' : 'Crear' }}</li>
                    </ol>
                </nav>
                <h1 class="page-title">{{ isset($comuna) ? 'Editar Comuna' : 'Crear Nueva Comuna' }}</h1>
                <p class="page-subtitle mb-0">Registre o modifique la información territorial de la comuna o corregimiento.</p>
            </div>
            <div>
                <a href="{{ route('comunas.index') }}" class="btn btn-outline-secondary d-inline-flex align-items-center gap-1">
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
                            <i class="material-icons text-primary" style="font-size: 22px;">location_city</i>
                            Datos de la Comuna o Corregimiento
                        </h5>
                    </div>
                    <form action="{{ isset($comuna) ? route('comunas.update', $comuna->id) : route('comunas.store') }}" method="POST">
                        @csrf
                        @if (isset($comuna))
                            @method('PUT')
                        @endif
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-12 col-md-6">
                                    <label for="nombre" class="form-label fw-semibold">Nombre de la Comuna / Corregimiento <span class="text-danger">*</span></label>
                                    <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $comuna->nombre ?? '') }}"
                                        class="form-control" required placeholder="Ej: Comuna 1, Corregimiento La Donjuana">
                                </div>

                                <div class="col-12 col-md-6">
                                    <label for="municipio_id" class="form-label fw-semibold">Municipio <span class="text-danger">*</span></label>
                                    <select name="municipio_id" id="municipio_id" class="form-select" required>
                                        <option value="">Seleccione municipio...</option>
                                        @foreach ($municipios as $c)
                                            <option value="{{ $c->id }}" {{ old('municipio_id', $comuna->municipio_id ?? '') == $c->id ? 'selected' : '' }}>
                                                {{ $c->nombre_municipio }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-light py-3 d-flex justify-content-end gap-2">
                            <a href="{{ route('comunas.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-primary d-inline-flex align-items-center gap-1">
                                <i class="material-icons" style="font-size: 18px;">save</i>
                                <span>{{ isset($comuna) ? 'Guardar Cambios' : 'Crear Comuna' }}</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
