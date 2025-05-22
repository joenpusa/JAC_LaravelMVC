@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ isset($junta) ? 'Editar' : 'Crear' }} Junta</h1>
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
        <form action="{{ isset($junta) ? route('juntas.update', $junta->id) : route('juntas.store') }}" method="POST">
            @csrf
            @if (isset($junta))
                @method('PUT')
            @endif
            <div class="row">
                <div class="col-12">
                    <h4>Datos basicos</h4>
                    <hr>
                </div>
                <div class="mb-3 col-6">
                    <label for="nombre">Razón social</label>
                    <input type="text" name="nombre" value="{{ old('nombre', $junta->nombre ?? '') }}"
                        class="form-control" required readonly>
                </div>
                <div class="mb-3 col-6">
                    <label for="resolucion">Resolución</label>
                    <input type="text" name="resolucion" value="{{ old('resolucion', $junta->resolucion ?? '') }}"
                        class="form-control" required readonly>
                </div>
                <div class="mb-3 col-6">
                    <label for="personeria">Personeria</label>
                    <input type="text" name="personeria" value="{{ old('personeria', $junta->personeria ?? '') }}"
                        class="form-control" required readonly>
                </div>
                <div class="mb-3 col-6">
                    <label for="fecha_resolucion">Fecha resolución</label>
                    <input type="date" name="fecha_resolucion"
                        value="{{ old('fecha_resolucion', $junta->fecha_resolucion ?? '') }}" class="form-control" required
                        readonly>
                </div>
                <div class="col-12">
                    <h4>Dignatarios y Comisionados</h4>
                    <hr>
                </div>
                <div class="mb-3 col-6">
                    <label for="fecha_eleccion">Fecha elección</label>
                    <input type="date" name="fecha_eleccion"
                        value="{{ old('fecha_eleccion', $junta->fecha_eleccion ?? '') }}" class="form-control" required>
                </div>
                <div class="mb-3 col-6">
                    <label for="municipio">Municipio</label>
                    <select name="municipio_id" id="municipio" class="form-select select2" style="width: 100%" required>
                        <option value="">Seleccione municipio</option>
                        @foreach ($municipios as $m)
                            <option value="{{ $m->id }}" {{ $m->id == $junta->municipio_id ? 'selected' : '' }}>
                                {{ $m->nombre_municipio }}</option>
                        @endforeach
                    </select>
                </div>
                <!-- Select para Presidente -->
                <div class="mb-3">
                    <label for="presidente">Presidente</label>
                    <select name="presidente_id" id="presidente" class="form-select select2" style="width: 100%" required>
                        <option value="">Seleccione el presidente</option>
                        @foreach ($funcionarios as $funcionario)
                            <option value="{{ $funcionario->id }}"
                                {{ $funcionario->id == $junta->presidente_id ? 'selected' : '' }}>
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
                                {{ $funcionario->id == $junta->vicepresidente_id ? 'selected' : '' }}>
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
                                {{ $funcionario->id == $junta->secretario_id ? 'selected' : '' }}>
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
                                {{ $funcionario->id == $junta->tesorero_id ? 'selected' : '' }}>
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
                                {{ $funcionario->id == $junta->fiscal_id ? 'selected' : '' }}>
                                {{ $funcionario->num_documento }} - {{ $funcionario->nombre }}</option>
                        @endforeach
                    </select>
                </div>


                <div class="mb-3 col-12" style="display:inline-block;">
                    <button type="submit" class="btn btn-success">{{ isset($junta) ? 'Actualizar' : 'Crear' }}</button>
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
                        Genenerar documento
                    </button>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#addCarpetaModal">
                        Registro carpeta
                    </button>
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
                    data-bs-parent="#accordionExample" style="">
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
                                @forelse($junta->comisiones as $comision)
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
                                        <td colspan="3">No hay comisiones asociadas a esta junta.</td>
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
                        Documentos de la Junta
                    </button>
                </h2>
                <div class="accordion-collapse collapse" id="collapseOne" aria-labelledby="headingOne"
                    data-bs-parent="#accordionExample" style="">
                    <div class="accordion-body pt-0">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Nombre del Documento</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($junta->documentos as $documento)
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
                                        <td colspan="3">No hay documentos asociados a esta asociación.</td>
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
                        AUTOS y Resoluciones generados
                    </button>
                </h2>
                <div class="accordion-collapse collapse" id="collapseTwo" aria-labelledby="headingTwo"
                    data-bs-parent="#accordionExample">
                    <div class="accordion-body pt-0">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Fecha generado</th>
                                    <th>Tipo</th>
                                    <th>Número</th>
                                    <th>Responsable</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($junta->autos as $auto)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($auto->fecha)->format('d/m/Y') }}</td>
                                        <td>{{ $auto->tipo }}</td>
                                        <td>{{ $auto->numero }}</td>
                                        <td>{{ $auto->usuario->name }}</td>
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
                <h2 class="accordion-header" id="heading3">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                        Libros de asociación
                    </button>
                </h2>
                <div class="accordion-collapse collapse" id="collapse4" aria-labelledby="heading4"
                    data-bs-parent="#accordionExample" style="">
                    <div class="accordion-body pt-0">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>tipo libro</th>
                                    <th>causal</th>
                                    <th>fecha</th>
                                    <th>folios</th>
                                    <th>responsable</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($junta->carpetas as $carpeta)
                                    <tr>
                                        <td>{{ $carpeta->libro }}</td>
                                        <td>{{ $carpeta->causal }}</td>
                                        <td>{{ $carpeta->fecha }}</td>
                                        <td>{{ $carpeta->folios }}</td>
                                        <td>{{ $carpeta->usuario->name }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3">No hay documentos asociados a esta asociación.</td>
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
                                <option value="Acta de Conformación JAC">Acta de Conformación JAC</option>
                                <option value="Acta Elección de Dignatarios">Acta Elección de Dignatarios</option>
                                <option value="Estatutos">Estatutos</option>
                                <option value="RUC">RUC</option>
                                <option value="Camara de comercio">Camara de comercio</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="archivo">Archivo</label>
                            <input type="file" name="archivo" class="form-control" required>
                        </div>
                        <input type="hidden" name="documentable_type" value="junta">
                        <input type="hidden" name="documentable_id" value="{{ $junta->id }}">
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
                            <label for="otra_comision">Especifique otra comisión</label>
                            <input type="text" id="otra_comision" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="nomcomisionado">Nombre del comisionado</label>
                            <input type="text" name="nomcomisionado" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="nomcomisionado">Documento del comisionado</label>
                            <input type="text" name="doccomisionado" class="form-control" required>
                        </div>
                        <input type="hidden" name="owner_type" value="junta">
                        <input type="hidden" name="owner_id" value="{{ $junta->id }}">
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
                    <h5 class="modal-title" id="addAutoModalLabel">¿Esta seguro de generar el documento?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('/autos') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="tipo">Nombre de la comisión</label>
                            <select name="tipo" id="tipo" class="form-select" required>
                                <option value="AUTO">AUTO</option>
                                <option value="Resolución">Resolución</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="nomanexo">Digite el número del documento</label>
                            <input type="text" name="numero" class="form-control" required maxlength="5">
                        </div>
                        <input type="hidden" name="owner_type" value="App\Models\Junta">
                        <input type="hidden" name="owner_id" value="{{ $junta->id }}">
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
                    <h5 class="modal-title" id="addCarpetaModalLabel">¿Esta seguro de generar el AUTO?</h5>
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
                            <label for="causal">causal de cambio</label>
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

                        <input type="hidden" name="owner_type" value="App\Models\Junta">
                        <input type="hidden" name="owner_id" value="{{ $junta->id }}">
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

            select.addEventListener('change', function() {
                if (select.value === 'OTRO') {
                    otraComisionDiv.classList.remove('d-none');
                    otraComisionInput.setAttribute('name', 'nomcomision'); // sobreescribe el name original
                    select.removeAttribute('name');
                } else {
                    otraComisionDiv.classList.add('d-none');
                    otraComisionInput.removeAttribute('name');
                    select.setAttribute('name', 'nomcomision'); // se restaura
                }
            });
        });
    </script>
@endsection
