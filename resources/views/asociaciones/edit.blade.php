@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ isset($asociacion) ? 'Editar' : 'Crear' }} Asociación</h1>
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
                <div class="mb-3 col-6">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" value="{{ old('nombre', $asociacion->nombre ?? '') }}"
                        class="form-control" required>
                </div>
                <div class="mb-3 col-6">
                    <label for="resolucion">Resolución</label>
                    <input type="text" name="resolucion" value="{{ old('resolucion', $asociacion->resolucion ?? '') }}"
                        class="form-control" required>
                </div>
                <div class="mb-3 col-6">
                    <label for="personeria">Personeria</label>
                    <input type="text" name="personeria" value="{{ old('personeria', $asociacion->personeria ?? '') }}"
                        class="form-control" required>
                </div>
                <div class="mb-3 col-6">
                    <label for="fecha_resolucion">Fecha resolución</label>
                    <input type="date" name="fecha_resolucion"
                        value="{{ old('fecha_resolucion', $asociacion->fecha_resolucion ?? '') }}" class="form-control"
                        required>
                </div>
                <div class="mb-3 col-6">
                    <label for="fecha_eleccion">Fecha elección</label>
                    <input type="date" name="fecha_eleccion"
                        value="{{ old('fecha_eleccion', $asociacion->fecha_eleccion ?? '') }}" class="form-control"
                        required>
                </div>
                <!-- Select para Presidente -->
                <div class="mb-3">
                    <label for="presidente">Presidente</label>
                    <select name="presidente_id" id="presidente" class="form-select select2" style="width: 100%" required>
                        <option value="">Seleccione el presidente</option>
                        @foreach ($funcionarios as $funcionario)
                            <option value="{{ $funcionario->id }}"
                                {{ $funcionario->id == $asociacion->presidente_id ? 'selected' : '' }}>
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
                                {{ $funcionario->id == $asociacion->vicepresidente_id ? 'selected' : '' }}>
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
                                {{ $funcionario->id == $asociacion->secretario_id ? 'selected' : '' }}>
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
                                {{ $funcionario->id == $asociacion->tesorero_id ? 'selected' : '' }}>
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
                                {{ $funcionario->id == $asociacion->fiscal_id ? 'selected' : '' }}>
                                {{ $funcionario->num_documento }} - {{ $funcionario->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="municipio">Municipio de la asociación</label>
                    <select name="municipio_id" id="municipio" class="form-select select2" style="width: 100%">
                        <option value="">Seleccione municipio</option>
                        @foreach ($municipios as $c)
                            <option value="{{ $c->id }}"
                                {{ $c->id == $asociacion->municipio_id ? 'selected' : '' }}>
                                {{ $c->nombre_municipio }}</option>
                        @endforeach
                    </select>
                </div>
                {{-- <div class="mb-3">
                    <label for="comuna">Comuna de la asociación</label>
                    <select name="comuna_id" id="comuna" class="form-select select2" style="width: 100%" required>
                        <option value="">Seleccione comuna</option>
                        @foreach ($comunas as $c)
                            <option value="{{ $c->id }}" {{ $c->id == $asociacion->comuna_id ? 'selected' : '' }}>
                                {{ $c->nombre }}</option>
                        @endforeach
                    </select>
                </div> --}}

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
                        Crear AUTO
                    </button>
                </div>
            </div>
        </form>


        <div class="accordion" id="accordionExample">
            <div class="accordion-item border-top">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                        Documentos de la asociación
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
                        AUTOS generados
                    </button>
                </h2>
                <div class="accordion-collapse collapse" id="collapseTwo" aria-labelledby="headingTwo"
                    data-bs-parent="#accordionExample">
                    <div class="accordion-body pt-0">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Fecha generado</th>
                                    <th>Numero</th>
                                    <th>Responsable</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($asociacion->documentos as $documento)
                                    <tr>
                                        <td>{{ $documento->nomanexo }}</td>
                                        <td>{{ $documento->nomanexo }}</td>
                                        <td>{{ $documento->nomanexo }}</td>
                                        <td>
                                            <a href="{{ route('autos.show', $documento->id) }}"
                                                class="btn btn-info btn-sm" target="_blank">
                                                Ver
                                            </a>

                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3">No hay autos generados para esta asociación.</td>
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
                            <label for="nomanexo">Nombre del Documento</label>
                            <input type="text" name="nomanexo" class="form-control" required>
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
                    <form action="{{ route('documentos.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        {{-- <div class="mb-3">
                            <label for="digantario">Digantario</label>
                            <select name="digantario_id" id="digantario" class="form-select select2"
                                style="width: 100%">
                                <option value="">Seleccione el digantario</option>
                                @foreach ($funcionarios as $funcionario)
                                    <option value="{{ $funcionario->id }}">
                                        {{ $funcionario->num_documento }} - {{ $funcionario->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div> --}}
                        <div class="mb-3">
                            <label for="nomanexo">Nombre de la comisión</label>
                            <input type="text" name="nomcomision" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="nomanexo">Nombre del comisionado</label>
                            <input type="text" name="nomcomisionado" class="form-control" required>
                        </div>
                        <input type="hidden" name="documentable_type" value="asociacion">
                        <input type="hidden" name="documentable_id" value="{{ $asociacion->id }}">
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
                    <h5 class="modal-title" id="addAutoModalLabel">¿Esta seguro de generar el AUTO?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('documentos.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="nomanexo">Digite el número de AUTO</label>
                            <input type="text" name="nomanexo" class="form-control" required>
                        </div>
                        <input type="hidden" name="documentable_type" value="asociacion">
                        <input type="hidden" name="documentable_id" value="{{ $asociacion->id }}">
                        <button type="submit" class="btn btn-success">Crear</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
