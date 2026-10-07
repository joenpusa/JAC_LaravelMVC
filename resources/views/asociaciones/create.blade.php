@extends('layouts.app')

@section('content')
    <div class="container-fluid px-2 px-md-3">
        <!-- Encabezado de página -->
        <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-1 text-xs">
                        <li class="breadcrumb-item"><a href="{{ route('asociaciones.index') }}" class="text-muted text-decoration-none">Asociaciones</a></li>
                        <li class="breadcrumb-item active text-primary fw-semibold" aria-current="page">Crear</li>
                    </ol>
                </nav>
                <h1 class="page-title">Crear Asociación</h1>
                <p class="page-subtitle mb-0">Registre una nueva asociación de juntas de acción comunal y sus dignatarios iniciales.</p>
            </div>
            <div>
                <a href="{{ route('asociaciones.index') }}" class="btn btn-outline-secondary d-inline-flex align-items-center gap-1">
                    <i class="material-icons" style="font-size: 18px;">arrow_back</i>
                    <span>Volver al listado</span>
                </a>
            </div>
        </div>

        @include('layouts.alerts')

        <form action="{{ route('asociaciones.store') }}" method="POST">
            @csrf

            <!-- Tarjeta 1: Datos Básicos -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-transparent py-3">
                    <h5 class="mb-0 fw-bold d-flex align-items-center gap-2">
                        <i class="material-icons text-primary" style="font-size: 22px;">domain</i>
                        Datos Básicos
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <label for="nombre">Razón social <span class="text-danger">*</span></label>
                            <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}"
                                class="form-control" required placeholder="Nombre oficial de la asociación">
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="resolucion">Resolución</label>
                            <input type="text" name="resolucion" id="resolucion" value="{{ old('resolucion') }}"
                                class="form-control" placeholder="Número de resolución">
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="personeria">Personería</label>
                            <input type="text" name="personeria" id="personeria" value="{{ old('personeria') }}"
                                class="form-control" placeholder="Número de personería">
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="fecha_resolucion">Fecha resolución</label>
                            <input type="date" name="fecha_resolucion" id="fecha_resolucion"
                                value="{{ old('fecha_resolucion') }}" class="form-control">
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="res_personeria_juridica">Res. Personería Jurídica</label>
                            <input type="text" name="res_personeria_juridica" id="res_personeria_juridica"
                                value="{{ old('res_personeria_juridica') }}" class="form-control" placeholder="Resolución de personería jurídica">
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="fecha_res_personeria_juridica">Fecha Res. Personería Jurídica</label>
                            <input type="date" name="fecha_res_personeria_juridica" id="fecha_res_personeria_juridica"
                                value="{{ old('fecha_res_personeria_juridica') }}" class="form-control">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tarjeta 2: Período y Ubicación -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-transparent py-3">
                    <h5 class="mb-0 fw-bold d-flex align-items-center gap-2">
                        <i class="material-icons text-primary" style="font-size: 22px;">event_note</i>
                        Período y Ubicación
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <label for="municipio">Municipio <span class="text-danger">*</span></label>
                            <select name="municipio_id" id="municipio" class="form-select select2" style="width: 100%" required>
                                <option value="">Seleccione municipio</option>
                                @foreach ($municipios as $m)
                                    <option value="{{ $m->id }}" {{ old('municipio_id') == $m->id ? 'selected' : '' }}>
                                        {{ $m->nombre_municipio }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="zona">Zona</label>
                            <select name="zona" id="zona" class="form-select">
                                <option value="">Seleccione zona</option>
                                <option value="URBANA" {{ old('zona') == 'URBANA' ? 'selected' : '' }}>URBANA</option>
                                <option value="RURAL" {{ old('zona') == 'RURAL' ? 'selected' : '' }}>RURAL</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-4">
                            <label for="fecha_eleccion">Fecha elección</label>
                            <input type="date" name="fecha_eleccion" id="fecha_eleccion"
                                value="{{ old('fecha_eleccion') }}" class="form-control">
                        </div>
                        <div class="col-12 col-md-4">
                            <label for="fecha_inicio_periodo">Fecha Inicio Período</label>
                            <input type="date" name="fecha_inicio_periodo" id="fecha_inicio_periodo"
                                value="{{ old('fecha_inicio_periodo') }}" class="form-control">
                        </div>
                        <div class="col-12 col-md-4">
                            <label for="fecha_final_periodo">Fecha Final Período</label>
                            <input type="date" name="fecha_final_periodo" id="fecha_final_periodo"
                                value="{{ old('fecha_final_periodo') }}" class="form-control">
                        </div>
                        <div class="col-12 col-md-4">
                            <label for="auto_numero">Auto No.</label>
                            <input type="text" name="auto_numero" id="auto_numero"
                                value="{{ old('auto_numero') }}" class="form-control" placeholder="Número de auto">
                        </div>
                        <div class="col-12 col-md-4">
                            <label for="tipo_auto">Tipo Auto</label>
                            <input type="text" name="tipo_auto" id="tipo_auto"
                                value="{{ old('tipo_auto') }}" class="form-control" placeholder="Tipo de auto">
                        </div>
                        <div class="col-12 col-md-4">
                            <label for="fecha_auto">Fecha Auto</label>
                            <input type="date" name="fecha_auto" id="fecha_auto"
                                value="{{ old('fecha_auto') }}" class="form-control">
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="tipo_oac">Tipo O.A.C.</label>
                            <input type="text" name="tipo_oac" id="tipo_oac"
                                value="{{ old('tipo_oac', 'ASOCOMUNAL') }}" class="form-control">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tarjeta 3: Dignatarios Principales -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-transparent py-3">
                    <h5 class="mb-0 fw-bold d-flex align-items-center gap-2">
                        <i class="material-icons text-primary" style="font-size: 22px;">badge</i>
                        Dignatarios Principales
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <label for="presidente">Presidente</label>
                            <select name="presidente_id" id="presidente" class="form-select select2" style="width: 100%">
                                <option value="">Seleccione el presidente</option>
                                @foreach ($funcionarios as $funcionario)
                                    <option value="{{ $funcionario->id }}" {{ old('presidente_id') == $funcionario->id ? 'selected' : '' }}>
                                        {{ $funcionario->num_documento }} - {{ $funcionario->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="vicepresidente">Vicepresidente</label>
                            <select name="vicepresidente_id" id="vicepresidente" class="form-select select2" style="width: 100%">
                                <option value="">Seleccione el vicepresidente</option>
                                @foreach ($funcionarios as $funcionario)
                                    <option value="{{ $funcionario->id }}" {{ old('vicepresidente_id') == $funcionario->id ? 'selected' : '' }}>
                                        {{ $funcionario->num_documento }} - {{ $funcionario->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-md-4">
                            <label for="secretario">Secretario</label>
                            <select name="secretario_id" id="secretario" class="form-select select2" style="width: 100%">
                                <option value="">Seleccione el secretario</option>
                                @foreach ($funcionarios as $funcionario)
                                    <option value="{{ $funcionario->id }}" {{ old('secretario_id') == $funcionario->id ? 'selected' : '' }}>
                                        {{ $funcionario->num_documento }} - {{ $funcionario->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-md-4">
                            <label for="tesorero">Tesorero</label>
                            <select name="tesorero_id" id="tesorero" class="form-select select2" style="width: 100%">
                                <option value="">Seleccione el tesorero</option>
                                @foreach ($funcionarios as $funcionario)
                                    <option value="{{ $funcionario->id }}" {{ old('tesorero_id') == $funcionario->id ? 'selected' : '' }}>
                                        {{ $funcionario->num_documento }} - {{ $funcionario->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-md-4">
                            <label for="fiscal">Fiscal</label>
                            <select name="fiscal_id" id="fiscal" class="form-select select2" style="width: 100%">
                                <option value="">Seleccione el fiscal</option>
                                @foreach ($funcionarios as $funcionario)
                                    <option value="{{ $funcionario->id }}" {{ old('fiscal_id') == $funcionario->id ? 'selected' : '' }}>
                                        {{ $funcionario->num_documento }} - {{ $funcionario->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-light py-3 d-flex justify-content-end gap-2">
                    <a href="{{ route('asociaciones.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary d-inline-flex align-items-center gap-1">
                        <i class="material-icons" style="font-size: 18px;">save</i>
                        <span>Guardar Asociación</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                theme: 'bootstrap-5',
                width: '100%',
                placeholder: 'Seleccione una opción'
            });
        });
    </script>
@endpush
