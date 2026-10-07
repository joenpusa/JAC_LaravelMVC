@extends('layouts.app')

@section('content')
    <div class="container-fluid px-2 px-md-3">
        <!-- Encabezado de página -->
        <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-1 text-xs">
                        <li class="breadcrumb-item"><a href="{{ route('juntas.index') }}" class="text-muted text-decoration-none">Juntas</a></li>
                        <li class="breadcrumb-item active text-primary fw-semibold" aria-current="page">{{ isset($junta) ? 'Editar' : 'Crear' }}</li>
                    </ol>
                </nav>
                <h1 class="page-title">{{ isset($junta) ? 'Editar Junta' : 'Crear Junta' }}</h1>
                <p class="page-subtitle mb-0">Gestione la Junta de Acción Comunal (JAC), sus dignatarios, soportes y resoluciones emitidas.</p>
            </div>
            <div>
                <a href="{{ route('juntas.index') }}" class="btn btn-outline-secondary">
                    <i class="material-icons" style="font-size: 18px;">arrow_back</i> Volver al listado
                </a>
            </div>
        </div>

        @include('layouts.alerts')

        <form action="{{ isset($junta) ? route('juntas.update', $junta->id) : route('juntas.store') }}" method="POST">
            @csrf
            @if (isset($junta))
                @method('PUT')
            @endif

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
                            <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $junta->nombre ?? '') }}"
                                class="form-control" required placeholder="Nombre oficial de la junta">
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="resolucion">Resolución</label>
                            <input type="text" name="resolucion" id="resolucion" value="{{ old('resolucion', $junta->resolucion ?? '') }}"
                                class="form-control" placeholder="Número de resolución">
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="personeria">Personería</label>
                            <input type="text" name="personeria" id="personeria" value="{{ old('personeria', $junta->personeria ?? '') }}"
                                class="form-control" placeholder="Número de personería">
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="fecha_resolucion">Fecha resolución</label>
                            <input type="date" name="fecha_resolucion" id="fecha_resolucion"
                                value="{{ old('fecha_resolucion', $junta->fecha_resolucion ?? '') }}" class="form-control">
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="res_personeria_juridica">Res. Personería Jurídica</label>
                            <input type="text" name="res_personeria_juridica" id="res_personeria_juridica"
                                value="{{ old('res_personeria_juridica', $junta->res_personeria_juridica ?? '') }}"
                                class="form-control" placeholder="Número resolución personería jurídica">
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="fecha_res_personeria_juridica">Fecha Res. Personería Jurídica</label>
                            <input type="date" name="fecha_res_personeria_juridica" id="fecha_res_personeria_juridica"
                                value="{{ old('fecha_res_personeria_juridica', $junta->fecha_res_personeria_juridica ?? '') }}"
                                class="form-control">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tarjeta 2: Dignatarios y Período -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-transparent py-3">
                    <h5 class="mb-0 fw-bold d-flex align-items-center gap-2">
                        <i class="material-icons text-primary" style="font-size: 22px;">badge</i>
                        Dignatarios y Período
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <label for="fecha_eleccion">Fecha elección</label>
                            <input type="date" name="fecha_eleccion" id="fecha_eleccion"
                                value="{{ old('fecha_eleccion', $junta->fecha_eleccion ?? '') }}" class="form-control">
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="municipio">Municipio <span class="text-danger">*</span></label>
                            <select name="municipio_id" id="municipio" class="form-select select2" style="width: 100%" required>
                                <option value="">Seleccione municipio</option>
                                @foreach ($municipios as $m)
                                    <option value="{{ $m->id }}" {{ (isset($junta) && $m->id == $junta->municipio_id) ? 'selected' : '' }}>
                                        {{ $m->nombre_municipio }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="auto_numero">Auto No.</label>
                            <input type="text" name="auto_numero" id="auto_numero" value="{{ old('auto_numero', $junta->auto_numero ?? '') }}" class="form-control">
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="tipo_auto">Tipo Auto</label>
                            <input type="text" name="tipo_auto" id="tipo_auto" value="{{ old('tipo_auto', $junta->tipo_auto ?? '') }}" class="form-control">
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="fecha_auto">Fecha Auto</label>
                            <input type="date" name="fecha_auto" id="fecha_auto" value="{{ old('fecha_auto', $junta->fecha_auto ?? '') }}" class="form-control">
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="fecha_inicio_periodo">Fecha Inicio Periodo</label>
                            <input type="date" name="fecha_inicio_periodo" id="fecha_inicio_periodo" value="{{ old('fecha_inicio_periodo', $junta->fecha_inicio_periodo ?? '') }}" class="form-control">
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="fecha_final_periodo">Fecha Final Periodo</label>
                            <input type="date" name="fecha_final_periodo" id="fecha_final_periodo" value="{{ old('fecha_final_periodo', $junta->fecha_final_periodo ?? '') }}" class="form-control">
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="tipo_oac">Tipo O.A.C.</label>
                            <input type="text" name="tipo_oac" id="tipo_oac" value="{{ old('tipo_oac', $junta->tipo_oac ?? '') }}" class="form-control">
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="zona">Zona</label>
                            <select name="zona" id="zona" class="form-select">
                                <option value="">Seleccione zona</option>
                                <option value="URBANA" {{ old('zona', $junta->zona ?? '') == 'URBANA' ? 'selected' : '' }}>URBANA</option>
                                <option value="RURAL" {{ old('zona', $junta->zona ?? '') == 'RURAL' ? 'selected' : '' }}>RURAL</option>
                            </select>
                        </div>

                        <!-- Dignatarios individuales -->
                        <div class="col-12"><hr class="my-2"></div>

                        <div class="col-12 col-md-6">
                            <label for="presidente">Presidente</label>
                            <select name="presidente_id" id="presidente" class="form-select select2" style="width: 100%">
                                <option value="">Seleccione el presidente</option>
                                @foreach ($funcionarios as $funcionario)
                                    <option value="{{ $funcionario->id }}"
                                        {{ (isset($junta) && $funcionario->id == $junta->presidente_id) ? 'selected' : '' }}>
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
                                    <option value="{{ $funcionario->id }}"
                                        {{ (isset($junta) && $funcionario->id == $junta->vicepresidente_id) ? 'selected' : '' }}>
                                        {{ $funcionario->num_documento }} - {{ $funcionario->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="secretario">Secretario</label>
                            <select name="secretario_id" id="secretario" class="form-select select2" style="width: 100%">
                                <option value="">Seleccione el secretario</option>
                                @foreach ($funcionarios as $funcionario)
                                    <option value="{{ $funcionario->id }}"
                                        {{ (isset($junta) && $funcionario->id == $junta->secretario_id) ? 'selected' : '' }}>
                                        {{ $funcionario->num_documento }} - {{ $funcionario->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="tesorero">Tesorero</label>
                            <select name="tesorero_id" id="tesorero" class="form-select select2" style="width: 100%">
                                <option value="">Seleccione el tesorero</option>
                                @foreach ($funcionarios as $funcionario)
                                    <option value="{{ $funcionario->id }}"
                                        {{ (isset($junta) && $funcionario->id == $junta->tesorero_id) ? 'selected' : '' }}>
                                        {{ $funcionario->num_documento }} - {{ $funcionario->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="fiscal">Fiscal</label>
                            <select name="fiscal_id" id="fiscal" class="form-select select2" style="width: 100%">
                                <option value="">Seleccione el fiscal</option>
                                @foreach ($funcionarios as $funcionario)
                                    <option value="{{ $funcionario->id }}"
                                        {{ (isset($junta) && $funcionario->id == $junta->fiscal_id) ? 'selected' : '' }}>
                                        {{ $funcionario->num_documento }} - {{ $funcionario->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Barra de Acciones y Operaciones -->
            <div class="card shadow-sm border-0 mb-4 bg-light">
                <div class="card-body py-3">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                        <button type="submit" class="btn btn-success shadow-sm">
                            <i class="material-icons" style="font-size: 20px;">save</i>
                            {{ isset($junta) ? 'Actualizar Junta' : 'Guardar Junta' }}
                        </button>

                        @if(isset($junta))
                            <div class="d-flex flex-wrap gap-2">
                                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addDocumentModal">
                                    <i class="material-icons" style="font-size: 18px;">upload_file</i> Cargar documento
                                </button>
                                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addComisionadoModal">
                                    <i class="material-icons" style="font-size: 18px;">person_add</i> Crear comisionado
                                </button>
                                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addAutoModal">
                                    <i class="material-icons" style="font-size: 18px;">description</i> Generar documento
                                </button>
                                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addCarpetaModal">
                                    <i class="material-icons" style="font-size: 18px;">folder</i> Registro libro
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </form>

        @if(isset($junta))
            <!-- Sección de Registros Asociados (Accordion moderno) -->
            <div class="card shadow-sm border-0 mb-5">
                <div class="card-header bg-transparent py-3">
                    <h5 class="mb-0 fw-bold d-flex align-items-center gap-2">
                        <i class="material-icons text-primary" style="font-size: 22px;">folder_shared</i>
                        Registros, Soportes y Documentos Asociados
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="accordion accordion-flush" id="accordionExample">
                        <!-- Comisionados -->
                        <div class="accordion-item border-bottom">
                            <h2 class="accordion-header" id="heading3">
                                <button class="accordion-button collapsed fw-bold text-dark py-3" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                                    <i class="material-icons text-primary me-2" style="font-size: 20px;">groups</i>
                                    Comisionados Registrados
                                    <span class="badge bg-primary-subtle text-primary ms-2">{{ $junta->comisiones->count() }}</span>
                                </button>
                            </h2>
                            <div class="accordion-collapse collapse" id="collapse3" aria-labelledby="heading3" data-bs-parent="#accordionExample">
                                <div class="accordion-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Comisión</th>
                                                    <th>Comisionado</th>
                                                    <th>Documento</th>
                                                    <th class="text-end">Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($junta->comisiones as $comision)
                                                    <tr>
                                                        <td><span class="fw-bold text-dark">{{ $comision->nomcomision }}</span></td>
                                                        <td>{{ $comision->nomcomisionado }}</td>
                                                        <td><span class="badge bg-light text-dark border">{{ $comision->doccomisionado }}</span></td>
                                                        <td class="text-end">
                                                            <form action="{{ route('comisiones.destroy', $comision->id) }}" method="POST" onsubmit="return confirm('¿Eliminar esta comisión?')" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                                                    <i class="material-icons" style="font-size: 16px;">delete</i> Eliminar
                                                                </button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="4" class="text-center py-4 text-muted">No hay comisiones asociadas a esta junta.</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Documentos -->
                        <div class="accordion-item border-bottom">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button collapsed fw-bold text-dark py-3" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                    <i class="material-icons text-primary me-2" style="font-size: 20px;">attachment</i>
                                    Documentos y Soportes Anexos
                                    <span class="badge bg-primary-subtle text-primary ms-2">{{ $junta->documentos->count() }}</span>
                                </button>
                            </h2>
                            <div class="accordion-collapse collapse" id="collapseOne" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                <div class="accordion-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Nombre del Documento / Soporte</th>
                                                    <th class="text-end">Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($junta->documentos as $documento)
                                                    <tr>
                                                        <td><span class="fw-semibold text-dark">{{ $documento->nomanexo }}</span></td>
                                                        <td class="text-end">
                                                            <div class="d-inline-flex gap-1">
                                                                <a href="{{ route('documentos.show', $documento->id) }}" class="btn btn-outline-info btn-sm" target="_blank">
                                                                    <i class="material-icons" style="font-size: 16px;">visibility</i> Ver
                                                                </a>
                                                                <form action="{{ route('documentos.destroy', $documento->id) }}" method="POST" class="d-inline">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('¿Está seguro de eliminar este documento?')">
                                                                        <i class="material-icons" style="font-size: 16px;">delete</i> Eliminar
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="2" class="text-center py-4 text-muted">No hay documentos anexos asociados a esta junta.</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Autos Generados -->
                        <div class="accordion-item border-bottom">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed fw-bold text-dark py-3" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    <i class="material-icons text-primary me-2" style="font-size: 20px;">article</i>
                                    AUTOS y Resoluciones Generados
                                    <span class="badge bg-primary-subtle text-primary ms-2">{{ $junta->autos->count() }}</span>
                                </button>
                            </h2>
                            <div class="accordion-collapse collapse" id="collapseTwo" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                <div class="accordion-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Fecha Generado</th>
                                                    <th>Número</th>
                                                    <th>Responsable</th>
                                                    <th class="text-end">Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($junta->autos as $auto)
                                                    <tr>
                                                        <td>{{ \Carbon\Carbon::parse($auto->fecha)->format('d/m/Y') }}</td>
                                                        <td><span class="badge bg-light text-dark border">{{ $auto->numero }}</span></td>
                                                        <td>{{ $auto->usuario->name ?? 'N/A' }}</td>
                                                        <td class="text-end">
                                                            <a href="{{ asset($auto->keyarchivo) }}" class="btn btn-outline-info btn-sm" target="_blank">
                                                                <i class="material-icons" style="font-size: 16px;">picture_as_pdf</i> Ver PDF
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="4" class="text-center py-4 text-muted">No hay autos generados para esta junta.</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Libros -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading4">
                                <button class="accordion-button collapsed fw-bold text-dark py-3" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                                    <i class="material-icons text-primary me-2" style="font-size: 20px;">menu_book</i>
                                    Registro de Libros
                                    <span class="badge bg-primary-subtle text-primary ms-2">{{ $junta->carpetas->count() }}</span>
                                </button>
                            </h2>
                            <div class="accordion-collapse collapse" id="collapse4" aria-labelledby="heading4" data-bs-parent="#accordionExample">
                                <div class="accordion-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Tipo Libro</th>
                                                    <th>Causal</th>
                                                    <th>Fecha</th>
                                                    <th>Folios</th>
                                                    <th>Responsable</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($junta->carpetas as $carpeta)
                                                    <tr>
                                                        <td><span class="fw-bold text-dark">{{ $carpeta->libro }}</span></td>
                                                        <td><span class="badge bg-light text-secondary border">{{ $carpeta->causal }}</span></td>
                                                        <td>{{ $carpeta->fecha }}</td>
                                                        <td>{{ $carpeta->folios }}</td>
                                                        <td>{{ $carpeta->usuario->name ?? 'N/A' }}</td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="5" class="text-center py-4 text-muted">No hay libros registrados para esta junta.</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    @if(isset($junta))
        <!-- MODAL DE CARGAR DOCUMENTO -->
        <div class="modal fade" id="addDocumentModal" tabindex="-1" aria-labelledby="addDocumentModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content border-0 shadow-lg rounded-4">
                    <div class="modal-header border-bottom py-3">
                        <h5 class="modal-title fw-bold" id="addDocumentModalLabel">Cargar Nuevo Documento</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <form action="{{ route('documentos.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="nomanexo" class="form-label">Tipo de Documento</label>
                                <select name="nomanexo" id="nomanexo" class="form-select" required>
                                    <option value="">Seleccione el documento</option>
                                    <option value="Acta de Conformación JAC">Acta de Conformación JAC</option>
                                    <option value="Acta Elección de Dignatarios">Acta Elección de Dignatarios</option>
                                    <option value="Estatutos">Estatutos</option>
                                    <option value="Auto Total">Auto Total</option>
                                    <option value="Auto Parcial">Auto Parcial</option>
                                    <option value="Auto Corrección">Auto Corrección</option>
                                    <option value="Auto no Inscripción">Auto no Inscripción</option>
                                    <option value="Auto de Requerimiento">Auto de Requerimiento</option>
                                    <option value="Resolución Personería Jurídica">Resolución Personería Jurídica</option>
                                    <option value="Resolución de Estatutos">Resolución de Estatutos</option>
                                    <option value="Resolución Cambio de Jurisdicción">Resolución Cambio de Jurisdicción</option>
                                    <option value="Resolución Cambio de Razón social">Resolución Cambio de Razón social</option>
                                    <option value="RUC">RUC</option>
                                    <option value="RUT">RUT</option>
                                    <option value="RUV">RUV</option>
                                    <option value="Cámara de Comercio">Cámara de Comercio</option>
                                    <option value="OTRO">OTRO</option>
                                </select>
                            </div>
                            <div class="mb-3 d-none" id="otroDocumentoDiv">
                                <label for="otro_documento" class="form-label">Nombre del soporte a cargar</label>
                                <input type="text" id="otro_documento" class="form-control" placeholder="Especifique el nombre del soporte">
                            </div>
                            <div class="mb-3">
                                <label for="archivo" class="form-label">Archivo (PDF o DOCX, máx 5MB)</label>
                                <input type="file" name="archivo" id="archivo" class="form-control" required accept=".pdf,.docx">
                            </div>
                            <input type="hidden" name="documentable_type" value="junta">
                            <input type="hidden" name="documentable_id" value="{{ $junta->id }}">
                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-success btn-sm">Cargar Documento</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- MODAL DE COMISIONADO -->
        <div class="modal fade" id="addComisionadoModal" tabindex="-1" aria-labelledby="addComisionadoModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content border-0 shadow-lg rounded-4">
                    <div class="modal-header border-bottom py-3">
                        <h5 class="modal-title fw-bold" id="addComisionadoModalLabel">Crear Nuevo Comisionado</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <form action="{{ route('comisiones.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="nomcomision" class="form-label">Nombre de la comisión</label>
                                <select name="nomcomision" id="nomcomision" class="form-select" required>
                                    <option value="">Seleccione opción</option>
                                    <option value="CONCILIADOR 1">CONCILIADOR 1</option>
                                    <option value="CONCILIADOR 2">CONCILIADOR 2</option>
                                    <option value="CONCILIADOR 3">CONCILIADOR 3</option>
                                    <option value="CONCILIADOR 4">CONCILIADOR 4</option>
                                    <option value="DELEGADO PRINCIPAL 1">DELEGADO PRINCIPAL 1</option>
                                    <option value="DELEGADO PRINCIPAL 2">DELEGADO PRINCIPAL 2</option>
                                    <option value="DELEGADO PRINCIPAL 3">DELEGADO PRINCIPAL 3</option>
                                    <option value="DELEGADO PRINCIPAL 4">DELEGADO PRINCIPAL 4</option>
                                    <option value="SALUD">SALUD</option>
                                    <option value="EDUCACION">EDUCACION</option>
                                    <option value="DEPORTES">DEPORTES</option>
                                    <option value="OBRAS">OBRAS</option>
                                    <option value="MEDIO AMBIENTE">MEDIO AMBIENTE</option>
                                    <option value="EMPRESARIAL">EMPRESARIAL</option>
                                    <option value="OTRO">OTRO</option>
                                </select>
                            </div>
                            <div class="mb-3 d-none" id="otraComisionDiv">
                                <label for="otra_comision" class="form-label">Especifique otra comisión</label>
                                <input type="text" id="otra_comision" class="form-control" placeholder="Nombre de la comisión">
                            </div>
                            <div class="mb-3">
                                <label for="nomcomisionado" class="form-label">Nombre del comisionado</label>
                                <input type="text" name="nomcomisionado" id="nomcomisionado" class="form-control" required placeholder="Nombre completo">
                            </div>
                            <div class="mb-3">
                                <label for="doccomisionado" class="form-label">Documento del comisionado</label>
                                <input type="text" name="doccomisionado" id="doccomisionado" class="form-control" required placeholder="Número de cédula">
                            </div>
                            <input type="hidden" name="owner_type" value="junta">
                            <input type="hidden" name="owner_id" value="{{ $junta->id }}">
                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-success btn-sm">Crear Comisionado</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- MODAL DE GENERACIÓN DE DOCUMENTO / AUTO -->
        <div class="modal fade" id="addAutoModal" tabindex="-1" aria-labelledby="addAutoModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content border-0 shadow-lg rounded-4">
                    <div class="modal-header border-bottom py-3">
                        <h5 class="modal-title fw-bold" id="addAutoModalLabel">Generar AUTO o Resolución</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <form action="{{ route('autos.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="tipo" class="form-label">Tipo de documento</label>
                                <select name="tipo" id="tipo" class="form-select" required>
                                    <option value="AUTO">AUTO</option>
                                    <option value="Resolución">Resolución</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="numero" class="form-label">Número del documento</label>
                                <input type="text" name="numero" id="numero" class="form-control" required maxlength="5" placeholder="Ej. 1001">
                            </div>
                            <input type="hidden" name="owner_type" value="App\Models\Junta">
                            <input type="hidden" name="owner_id" value="{{ $junta->id }}">
                            <input type="hidden" name="usuario_id" value="{{ auth()->user()->id }}">
                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-success btn-sm">Generar y Descargar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- MODAL DE REGISTRO DE CARPETA / LIBRO -->
        <div class="modal fade" id="addCarpetaModal" tabindex="-1" aria-labelledby="addCarpetaModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content border-0 shadow-lg rounded-4">
                    <div class="modal-header border-bottom py-3">
                        <h5 class="modal-title fw-bold" id="addCarpetaModalLabel">Registro de Libro</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <form action="{{ route('carpetas.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="libro" class="form-label">Libro</label>
                                <select name="libro" id="libro" class="form-select" required>
                                    <option value="">Seleccione el libro</option>
                                    <option value="Libro afiliados">Libro afiliados</option>
                                    <option value="Libro asamblea">Libro asamblea</option>
                                    <option value="Libro inventario">Libro inventario</option>
                                    <option value="Libro directiva">Libro directiva</option>
                                    <option value="Libro conciliación">Libro conciliación</option>
                                    <option value="Libro tesoreria">Libro tesoreria</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="causal" class="form-label">Causal de cambio</label>
                                <select name="causal" id="causal" class="form-select" required>
                                    <option value="">Seleccione causal</option>
                                    <option value="DETERIORO">DETERIORO</option>
                                    <option value="PERDIDA">PERDIDA</option>
                                    <option value="RETENCION">RETENCION</option>
                                    <option value="USO TOTAL">USO TOTAL</option>
                                    <option value="HURTO">HURTO</option>
                                    <option value="ENMENDADURAS">ENMENDADURAS</option>
                                    <option value="PRIMERA VEZ">PRIMERA VEZ</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="fecha" class="form-label">Fecha</label>
                                <input type="date" name="fecha" id="fecha" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="folios" class="form-label">Folios</label>
                                <input type="number" name="folios" id="folios" class="form-control" required placeholder="Número de folios">
                            </div>

                            <input type="hidden" name="owner_type" value="App\Models\Junta">
                            <input type="hidden" name="owner_id" value="{{ $junta->id }}">
                            <input type="hidden" name="usuario_id" value="{{ auth()->user()->id }}">
                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-success btn-sm">Guardar Libro</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Manejo de otra comisión
            const selectComision = document.getElementById('nomcomision');
            const otraComisionDiv = document.getElementById('otraComisionDiv');
            const otraComisionInput = document.getElementById('otra_comision');

            if (selectComision && otraComisionDiv && otraComisionInput) {
                selectComision.addEventListener('change', function() {
                    if (selectComision.value === 'OTRO') {
                        otraComisionDiv.classList.remove('d-none');
                        otraComisionInput.setAttribute('name', 'nomcomision');
                        otraComisionInput.setAttribute('required', 'required');
                        selectComision.removeAttribute('name');
                    } else {
                        otraComisionDiv.classList.add('d-none');
                        otraComisionInput.removeAttribute('name');
                        otraComisionInput.removeAttribute('required');
                        selectComision.setAttribute('name', 'nomcomision');
                    }
                });
            }

            // Manejo de otro documento soporte
            const selectDoc = document.getElementById('nomanexo');
            const otroDocDiv = document.getElementById('otroDocumentoDiv');
            const otroDocInput = document.getElementById('otro_documento');

            if (selectDoc && otroDocDiv && otroDocInput) {
                selectDoc.addEventListener('change', function() {
                    if (selectDoc.value === 'OTRO') {
                        otroDocDiv.classList.remove('d-none');
                        otroDocInput.setAttribute('name', 'nomanexo');
                        otroDocInput.setAttribute('required', 'required');
                        selectDoc.removeAttribute('name');
                        selectDoc.removeAttribute('required');
                    } else {
                        otroDocDiv.classList.add('d-none');
                        otroDocInput.removeAttribute('name');
                        otroDocInput.removeAttribute('required');
                        selectDoc.setAttribute('name', 'nomanexo');
                        selectDoc.setAttribute('required', 'required');
                    }
                });
            }
        });
    </script>
@endsection
