@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ isset($asociacion) ? 'Editar' : 'Crear' }} Asociación</h1>
        <hr>
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
        <form
            action="{{ isset($asociacion) ? route('asociaciones.update', $asociacion->id) : route('asociaciones.store') }}"
            method="POST">
            @csrf
            @if (isset($asociacion))
                @method('PUT')
            @endif
            <div class="row">
                <div class="col-12">
                    <h4>Datos básicos</h4>
                    <hr>
                </div>
                <div class="mb-3 col-6">
                    <label for="nombre">Razón social <span class="text-danger">*</span></label>
                    <input type="text" name="nombre" value="{{ old('nombre', $asociacion->nombre ?? '') }}"
                        class="form-control" required>
                </div>
                <div class="mb-3 col-6">
                    <label for="resolucion">Resolución</label>
                    <input type="text" name="resolucion" value="{{ old('resolucion', $asociacion->resolucion ?? '') }}"
                        class="form-control">
                </div>
                <div class="mb-3 col-6">
                    <label for="personeria">Personería</label>
                    <input type="text" name="personeria" value="{{ old('personeria', $asociacion->personeria ?? '') }}"
                        class="form-control">
                </div>
                <div class="mb-3 col-6">
                    <label for="fecha_resolucion">Fecha resolución</label>
                    <input type="date" name="fecha_resolucion"
                        value="{{ old('fecha_resolucion', $asociacion->fecha_resolucion ?? '') }}" class="form-control">
                </div>
                <div class="mb-3 col-6">
                    <label for="res_personeria_juridica">Res. Personería Jurídica</label>
                    <input type="text" name="res_personeria_juridica" id="res_personeria_juridica"
                        value="{{ old('res_personeria_juridica', $asociacion->res_personeria_juridica ?? '') }}"
                        class="form-control">
                </div>
                <div class="mb-3 col-6">
                    <label for="fecha_res_personeria_juridica">Fecha Res. Personería Jurídica</label>
                    <input type="date" name="fecha_res_personeria_juridica" id="fecha_res_personeria_juridica"
                        value="{{ old('fecha_res_personeria_juridica', $asociacion->fecha_res_personeria_juridica ?? '') }}"
                        class="form-control">
                </div>

                <div class="col-12">
                    <h4>Dignatarios y Período</h4>
                    <hr>
                </div>
                <div class="mb-3 col-6">
                    <label for="fecha_eleccion">Fecha elección</label>
                    <input type="date" name="fecha_eleccion"
                        value="{{ old('fecha_eleccion', $asociacion->fecha_eleccion ?? '') }}" class="form-control">
                </div>
                <div class="mb-3 col-6">
                    <label for="municipio">Municipio <span class="text-danger">*</span></label>
                    <select name="municipio_id" id="municipio" class="form-select select2" style="width: 100%" required>
                        <option value="">Seleccione municipio</option>
                        @foreach ($municipios as $m)
                            <option value="{{ $m->id }}"
                                {{ old('municipio_id', $asociacion->municipio_id ?? '') == $m->id ? 'selected' : '' }}>
                                {{ $m->nombre_municipio }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3 col-6">
                    <label for="auto_numero">Auto No.</label>
                    <input type="text" name="auto_numero" value="{{ old('auto_numero', $asociacion->auto_numero ?? '') }}" class="form-control">
                </div>
                <div class="mb-3 col-6">
                    <label for="tipo_auto">Tipo Auto</label>
                    <input type="text" name="tipo_auto" value="{{ old('tipo_auto', $asociacion->tipo_auto ?? '') }}" class="form-control">
                </div>
                <div class="mb-3 col-6">
                    <label for="fecha_auto">Fecha Auto</label>
                    <input type="date" name="fecha_auto" value="{{ old('fecha_auto', $asociacion->fecha_auto ?? '') }}" class="form-control">
                </div>
                <div class="mb-3 col-6">
                    <label for="fecha_inicio_periodo">Fecha Inicio Periodo</label>
                    <input type="date" name="fecha_inicio_periodo" value="{{ old('fecha_inicio_periodo', $asociacion->fecha_inicio_periodo ?? '') }}" class="form-control">
                </div>
                <div class="mb-3 col-6">
                    <label for="fecha_final_periodo">Fecha Final Periodo</label>
                    <input type="date" name="fecha_final_periodo" value="{{ old('fecha_final_periodo', $asociacion->fecha_final_periodo ?? '') }}" class="form-control">
                </div>
                <div class="mb-3 col-6">
                    <label for="tipo_oac">Tipo O.A.C.</label>
                    <input type="text" name="tipo_oac" value="{{ old('tipo_oac', $asociacion->tipo_oac ?? '') }}" class="form-control">
                </div>
                <div class="mb-3 col-6">
                    <label for="zona">Zona</label>
                    <select name="zona" id="zona" class="form-select">
                        <option value="">Seleccione zona</option>
                        <option value="URBANA" {{ old('zona', $asociacion->zona ?? '') == 'URBANA' ? 'selected' : '' }}>URBANA</option>
                        <option value="RURAL" {{ old('zona', $asociacion->zona ?? '') == 'RURAL' ? 'selected' : '' }}>RURAL</option>
                    </select>
                </div>

                <!-- Select para Presidente -->
                <div class="mb-3">
                    <label for="presidente">Presidente</label>
                    <select name="presidente_id" id="presidente" class="form-select select2" style="width: 100%">
                        <option value="">Seleccione el presidente</option>
                        @foreach ($funcionarios as $funcionario)
                            <option value="{{ $funcionario->id }}"
                                {{ old('presidente_id', $asociacion->presidente_id ?? '') == $funcionario->id ? 'selected' : '' }}>
                                {{ $funcionario->num_documento }} - {{ $funcionario->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <!-- Select para Vicepresidente -->
                <div class="mb-3">
                    <label for="vicepresidente">Vicepresidente</label>
                    <select name="vicepresidente_id" id="vicepresidente" class="form-select select2" style="width: 100%">
                        <option value="">Seleccione el vicepresidente</option>
                        @foreach ($funcionarios as $funcionario)
                            <option value="{{ $funcionario->id }}"
                                {{ old('vicepresidente_id', $asociacion->vicepresidente_id ?? '') == $funcionario->id ? 'selected' : '' }}>
                                {{ $funcionario->num_documento }} - {{ $funcionario->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <!-- Select para Secretario -->
                <div class="mb-3">
                    <label for="secretario">Secretario</label>
                    <select name="secretario_id" id="secretario" class="form-select select2" style="width: 100%">
                        <option value="">Seleccione el secretario</option>
                        @foreach ($funcionarios as $funcionario)
                            <option value="{{ $funcionario->id }}"
                                {{ old('secretario_id', $asociacion->secretario_id ?? '') == $funcionario->id ? 'selected' : '' }}>
                                {{ $funcionario->num_documento }} - {{ $funcionario->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <!-- Select para Tesorero -->
                <div class="mb-3">
                    <label for="tesorero">Tesorero</label>
                    <select name="tesorero_id" id="tesorero" class="form-select select2" style="width: 100%">
                        <option value="">Seleccione el tesorero</option>
                        @foreach ($funcionarios as $funcionario)
                            <option value="{{ $funcionario->id }}"
                                {{ old('tesorero_id', $asociacion->tesorero_id ?? '') == $funcionario->id ? 'selected' : '' }}>
                                {{ $funcionario->num_documento }} - {{ $funcionario->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <!-- Select para Fiscal -->
                <div class="mb-3">
                    <label for="fiscal">Fiscal</label>
                    <select name="fiscal_id" id="fiscal" class="form-select select2" style="width: 100%">
                        <option value="">Seleccione el fiscal</option>
                        @foreach ($funcionarios as $funcionario)
                            <option value="{{ $funcionario->id }}"
                                {{ old('fiscal_id', $asociacion->fiscal_id ?? '') == $funcionario->id ? 'selected' : '' }}>
                                {{ $funcionario->num_documento }} - {{ $funcionario->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3 col-12" style="display:inline-block;">
                    <button type="submit"
                        class="btn btn-success">{{ isset($asociacion) ? 'Actualizar' : 'Crear' }}</button>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#addDocumentModal">
                        Cargar documento
                    </button>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#addComisionadoModal">
                        Crear comisionado
                    </button>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#addAutoModal">
                        Generar documento
                    </button>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#addCarpetaModal">
                        Registro carpeta
                    </button>
                    <a href="{{ route('asociaciones.index') }}" class="btn btn-secondary">Volver</a>
                </div>
            </div>
        </form>

        <div class="accordion" id="accordionExample">
            <div class="accordion-item border-top">
                <h2 class="accordion-header" id="heading3">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                        Comisionados
                    </button>
                </h2>
                <div class="accordion-collapse collapse" id="collapse3" aria-labelledby="heading3"
                    data-bs-parent="#accordionExample">
                    <div class="accordion-body pt-0">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Comisión</th>
                                    <th>Comisionado</th>
                                    <th>Documento</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($asociacion->comisiones as $comision)
                                    <tr>
                                        <td>{{ $comision->nomcomision }}</td>
                                        <td>{{ $comision->nomcomisionado }}</td>
                                        <td>{{ $comision->doccomisionado }}</td>
                                        <td>
                                            <form action="{{ route('comisiones.destroy', $comision->id) }}"
                                                method="POST" onsubmit="return confirm('¿Eliminar esta comisión?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4">No hay comisionados asociados a esta asociación.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="accordion-item border-top">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                        Documentos de la asociación
                    </button>
                </h2>
                <div class="accordion-collapse collapse" id="collapseOne" aria-labelledby="headingOne"
                    data-bs-parent="#accordionExample">
                    <div class="accordion-body pt-0">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Nombre del Documento</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($asociacion->documentos as $documento)
                                    <tr>
                                        <td>{{ $documento->nomanexo }}</td>
                                        <td>
                                            <a href="{{ route('documentos.show', $documento->id) }}"
                                                class="btn btn-info btn-sm" target="_blank">
                                                Ver
                                            </a>
                                            <form action="{{ route('documentos.destroy', $documento->id) }}"
                                                method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('¿Está seguro de eliminar este documento?')">Eliminar</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2">No hay documentos asociados a esta asociación.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingTwo">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        AUTOS generados y documentos
                    </button>
                </h2>
                <div class="accordion-collapse collapse" id="collapseTwo" aria-labelledby="headingTwo"
                    data-bs-parent="#accordionExample">
                    <div class="accordion-body pt-0">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Fecha generado</th>
                                    <th>Número</th>
                                    <th>Responsable</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($asociacion->autos as $auto)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($auto->fecha)->format('d/m/Y') }}</td>
                                        <td>{{ $auto->numero }}</td>
                                        <td>{{ $auto->usuario->name ?? 'N/A' }}</td>
                                        <td>
                                            <a href="{{ asset($auto->keyarchivo) }}" class="btn btn-info btn-sm"
                                                target="_blank">
                                                Ver PDF
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4">No hay autos generados para esta asociación.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="accordion-item border-top">
                <h2 class="accordion-header" id="heading4">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                        Libros de asociación
                    </button>
                </h2>
                <div class="accordion-collapse collapse" id="collapse4" aria-labelledby="heading4"
                    data-bs-parent="#accordionExample">
                    <div class="accordion-body pt-0">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Tipo libro</th>
                                    <th>Causal</th>
                                    <th>Fecha</th>
                                    <th>Folios</th>
                                    <th>Responsable</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($asociacion->carpetas as $carpeta)
                                    <tr>
                                        <td>{{ $carpeta->libro }}</td>
                                        <td>{{ $carpeta->causal }}</td>
                                        <td>{{ $carpeta->fecha }}</td>
                                        <td>{{ $carpeta->folios }}</td>
                                        <td>{{ $carpeta->usuario->name ?? 'N/A' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5">No hay libros registrados para esta asociación.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- MODAL DE CARGAR DOCUMENTO -->
    <div class="modal fade" id="addDocumentModal" tabindex="-1" aria-labelledby="addDocumentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addDocumentModalLabel">Cargar Nuevo Documento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('documentos.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="nomanexo">Documento</label>
                            <select name="nomanexo" id="nomanexo" class="form-select" required>
                                <option value="">Seleccione el documento</option>
                                <option value="Acta de Conformación Asociación">Acta de Conformación Asociación</option>
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
                            <label for="otro_documento">Nombre del soporte a cargar</label>
                            <input type="text" id="otro_documento" class="form-control" placeholder="Especifique el nombre del soporte">
                        </div>
                        <div class="mb-3">
                            <label for="archivo">Archivo</label>
                            <input type="file" name="archivo" class="form-control" required>
                        </div>
                        <input type="hidden" name="documentable_type" value="asociacion">
                        <input type="hidden" name="documentable_id" value="{{ $asociacion->id }}">
                        <button type="submit" class="btn btn-success">Cargar Documento</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- MODAL DE COMISIONADO -->
    <div class="modal fade" id="addComisionadoModal" tabindex="-1" aria-labelledby="addComisionadoModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addComisionadoModalLabel">Crear nuevo comisionado</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('comisiones.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="nomcomision">Nombre de la comisión</label>
                            <select name="nomcomision" id="nomcomision" class="form-select" required>
                                <option value="">Seleccione opción</option>
                                <option value="CONCILIADOR 1">CONCILIADOR 1</option>
                                <option value="CONCILIADOR 2">CONCILIADOR 2</option>
                                <option value="CONCILIADOR 3">CONCILIADOR 3</option>
                                <option value="CONCILIADOR 4">CONCILIADOR 4</option>
                                <option value="FISCAL SUPLENTE">FISCAL SUPLENTE</option>
                                <option value="DELEGADO PRINCIPAL 1">DELEGADO PRINCIPAL 1</option>
                                <option value="DELEGADO PRINCIPAL 2">DELEGADO PRINCIPAL 2</option>
                                <option value="DELEGADO PRINCIPAL 3">DELEGADO PRINCIPAL 3</option>
                                <option value="DELEGADO PRINCIPAL 4">DELEGADO PRINCIPAL 4</option>
                                <option value="DELEGADO SUPLEMENTE 1">DELEGADO SUPLEMENTE 1</option>
                                <option value="DELEGADO SUPLEMENTE 2">DELEGADO SUPLEMENTE 2</option>
                                <option value="DELEGADO SUPLEMENTE 3">DELEGADO SUPLEMENTE 3</option>
                                <option value="DELEGADO SUPLEMENTE 4">DELEGADO SUPLEMENTE 4</option>
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
                            <label for="otra_comision">Especifique otra comisión</label>
                            <input type="text" id="otra_comision" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="nomcomisionado">Nombre del comisionado</label>
                            <input type="text" name="nomcomisionado" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="doccomisionado">Documento del comisionado</label>
                            <input type="text" name="doccomisionado" class="form-control" required>
                        </div>
                        <input type="hidden" name="owner_type" value="asociacion">
                        <input type="hidden" name="owner_id" value="{{ $asociacion->id }}">
                        <button type="submit" class="btn btn-success">Crear</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- MODAL DE CONFIRMACION DE AUTO-->
    <div class="modal fade" id="addAutoModal" tabindex="-1" aria-labelledby="addAutoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addAutoModalLabel">¿Está seguro de generar el AUTO?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('autos.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="tipo">Tipo de documento</label>
                            <select name="tipo" id="tipo" class="form-select" required>
                                <option value="AUTO">AUTO</option>
                                <option value="Resolución">Resolución</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="numero">Digite el número del documento</label>
                            <input type="text" name="numero" class="form-control" required maxlength="5">
                        </div>
                        <input type="hidden" name="owner_type" value="App\Models\Asociacion">
                        <input type="hidden" name="owner_id" value="{{ $asociacion->id }}">
                        <input type="hidden" name="usuario_id" value="{{ auth()->user()->id }}">
                        <button type="submit" class="btn btn-success">Crear</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- MODAL DE registro de carpeta -->
    <div class="modal fade" id="addCarpetaModal" tabindex="-1" aria-labelledby="addCarpetaModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCarpetaModalLabel">Registro de libro</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('carpetas.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="libro">Libro</label>
                            <select name="libro" class="form-select" required>
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
                            <label for="causal">Causal de cambio</label>
                            <select name="causal" class="form-select" required>
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
                            <label for="fecha">Fecha</label>
                            <input type="date" name="fecha" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="folios">Folios</label>
                            <input type="number" name="folios" class="form-control" required>
                        </div>

                        <input type="hidden" name="owner_type" value="App\Models\Asociacion">
                        <input type="hidden" name="owner_id" value="{{ $asociacion->id }}">
                        <input type="hidden" name="usuario_id" value="{{ auth()->user()->id }}">
                        <button type="submit" class="btn btn-success">Crear</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const select = document.getElementById('nomcomision');
            const otraComisionDiv = document.getElementById('otraComisionDiv');
            const otraComisionInput = document.getElementById('otra_comision');

            if (select) {
                select.addEventListener('change', function() {
                    if (select.value === 'OTRO') {
                        otraComisionDiv.classList.remove('d-none');
                        otraComisionInput.setAttribute('name', 'nomcomision');
                        otraComisionInput.setAttribute('required', 'required');
                        select.removeAttribute('name');
                    } else {
                        otraComisionDiv.classList.add('d-none');
                        otraComisionInput.removeAttribute('name');
                        otraComisionInput.removeAttribute('required');
                        select.setAttribute('name', 'nomcomision');
                    }
                });
            }

            const selectDoc = document.getElementById('nomanexo');
            const otroDocDiv = document.getElementById('otroDocumentoDiv');
            const otroDocInput = document.getElementById('otro_documento');

            if (selectDoc) {
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
