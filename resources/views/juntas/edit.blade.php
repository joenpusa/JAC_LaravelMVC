@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ isset($junta) ? 'Editar' : 'Crear' }} Junta</h1>
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <p>Proceso no realizado:</p>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if ($message = Session::get('success'))
            <div class="alert alert-success text-white">
                {{ $message }}
            </div>
        @endif
        @if ($message = Session::get('error'))
            <div class="alert alert-danger text-white">
                {{ $message }}
            </div>
        @endif
        <form action="{{ isset($junta) ? route('juntas.update', $junta->id) : route('juntas.store') }}" method="POST">
            @csrf
            @if (isset($junta))
                @method('PUT')
            @endif
            <div class="row">
                <div class="mb-3 col-6">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" name="nombre" value="{{ old('nombre', $junta->nombre ?? '') }}" class="form-control" required>
                </div>
                <div class="mb-3 col-6">
                    <label for="resolucion" class="form-label">Resolución</label>
                    <input type="text" name="resolucion" value="{{ old('resolucion', $junta->resolucion ?? '') }}" class="form-control" required>
                </div>

                <div class="mb-3 col-6">
                    <label for="fecha_resolucion" class="form-label">Fecha resolución</label>
                    <input type="date" name="fecha_resolucion" value="{{ old('fecha_resolucion', $junta->fecha_resolucion ?? '') }}" class="form-control" required>
                </div>
                <div class="mb-3 col-6">
                    <label for="fecha_eleccion" class="form-label">Fecha elección</label>
                    <input type="date" name="fecha_eleccion" value="{{ old('fecha_eleccion', $junta->fecha_eleccion ?? '') }}" class="form-control" required>
                </div>
                <!-- Select para Presidente -->
                <div class="mb-3">
                    <label for="presidente" class="form-label">Presidente</label>
                    <select name="presidente_id" id="presidente" class="form-select select2 form-control" required>
                        <option value="">Seleccione el presidente</option>
                        @foreach ($funcionarios as $funcionario)
                            <option value="{{ $funcionario->id }}" {{ $funcionario->id == $junta->presidente_id ? 'selected' : '' }}>{{ $funcionario->num_documento }} - {{ $funcionario->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <!-- Select para Vicepresidente -->
                <div class="mb-3">
                    <label for="vicepresidente" class="form-label">Vicepresidente</label>
                    <select name="vicepresidente_id" id="vicepresidente" class="form-select select2 form-control" required>
                        <option value="">Seleccione el vicepresidente</option>
                        @foreach ($funcionarios as $funcionario)
                            <option value="{{ $funcionario->id }}" {{ $funcionario->id == $junta->vicepresidente_id ? 'selected' : '' }}>{{ $funcionario->num_documento }} - {{ $funcionario->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <!-- Select para Secretario -->
                <div class="mb-3">
                    <label for="secretario" class="form-label">Secretario</label>
                    <select name="secretario_id" id="secretario" class="form-select select2 form-control" required>
                        <option value="">Seleccione el secretario</option>
                        @foreach ($funcionarios as $funcionario)
                            <option value="{{ $funcionario->id }}" {{ $funcionario->id == $junta->secretario_id ? 'selected' : '' }}>{{ $funcionario->num_documento }} - {{ $funcionario->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <!-- Select para Tesorero -->
                <div class="mb-3">
                    <label for="tesorero" class="form-label">Tesorero</label>
                    <select name="tesorero_id" id="tesorero" class="form-select select2 form-control" required>
                        <option value="">Seleccione el tesorero</option>
                        @foreach ($funcionarios as $funcionario)
                            <option value="{{ $funcionario->id }}" {{ $funcionario->id == $junta->tesorero_id ? 'selected' : '' }}>{{ $funcionario->num_documento }} - {{ $funcionario->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <!-- Select para Fiscal -->
                <div class="mb-3">
                    <label for="fiscal" class="form-label">Fiscal</label>
                    <select name="fiscal_id" id="fiscal" class="form-select select2 form-control" required>
                        <option value="">Seleccione el fiscal</option>
                        @foreach ($funcionarios as $funcionario)
                            <option value="{{ $funcionario->id }}" {{ $funcionario->id == $junta->fiscal_id ? 'selected' : '' }}>{{ $funcionario->num_documento }} - {{ $funcionario->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <!-- Select para Concil1 -->
                <div class="mb-3">
                    <label for="concil1" class="form-label">Conciliador 1</label>
                    <select name="concil1_id" id="concil1" class="form-select select2 form-control" required>
                        <option value="">Seleccione el conciliador 1</option>
                        @foreach ($funcionarios as $funcionario)
                            <option value="{{ $funcionario->id }}" {{ $funcionario->id == $junta->concil1_id ? 'selected' : '' }}>{{ $funcionario->num_documento }} - {{ $funcionario->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="concil2" class="form-label">Conciliador 2</label>
                    <select name="concil2_id" id="concil2" class="form-select select2 form-control" required>
                        <option value="">Seleccione el conciliador 2</option>
                        @foreach ($funcionarios as $funcionario)
                            <option value="{{ $funcionario->id }}" {{ $funcionario->id == $junta->concil2_id ? 'selected' : '' }}>{{ $funcionario->num_documento }} - {{ $funcionario->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="concil3" class="form-label">Conciliador 3</label>
                    <select name="concil3_id" id="concil3" class="form-select select2 form-control" required>
                        <option value="">Seleccione el conciliador 3</option>
                        @foreach ($funcionarios as $funcionario)
                            <option value="{{ $funcionario->id }}" {{ $funcionario->id == $junta->concil3_id ? 'selected' : '' }}>{{ $funcionario->num_documento }} - {{ $funcionario->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="delegado1" class="form-label">Delegado 1</label>
                    <select name="delegado1_id" id="delegado1" class="form-select select2 form-control" required>
                        <option value="">Seleccione el delegado 1</option>
                        @foreach ($funcionarios as $funcionario)
                            <option value="{{ $funcionario->id }}" {{ $funcionario->id == $junta->delegado1_id ? 'selected' : '' }}>{{ $funcionario->num_documento }} - {{ $funcionario->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="delegado2" class="form-label">Delegado 2</label>
                    <select name="delegado2_id" id="delegado2" class="form-select select2 form-control" required>
                        <option value="">Seleccione el delegado 2</option>
                        @foreach ($funcionarios as $funcionario)
                            <option value="{{ $funcionario->id }}"{{ $funcionario->id == $junta->delegado2_id ? 'selected' : '' }}>{{ $funcionario->num_documento }} - {{ $funcionario->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="delegado3" class="form-label">Delegado 3</label>
                    <select name="delegado3_id" id="delegado3" class="form-select select2 form-control" required>
                        <option value="">Seleccione el delegado 3</option>
                        @foreach ($funcionarios as $funcionario)
                            <option value="{{ $funcionario->id }}" {{ $funcionario->id == $junta->delegado3_id ? 'selected' : '' }}>{{ $funcionario->num_documento }} - {{ $funcionario->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="comuna" class="form-label">Comuna de la junta</label>
                    <select name="comuna_id" id="comuna" class="form-select select2 form-control" required>
                        <option value="">Seleccione comuna</option>
                        @foreach ($comunas as $c)
                            <option value="{{ $c->id }}" {{ $c->id == $junta->comuna_id ? 'selected' : '' }}>{{ $c->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3 col-12" style="display:inline-block;">
                    <button type="submit" class="btn btn-success">{{ isset($junta) ? 'Actualizar' : 'Crear' }}</button>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addDocumentModal">
                        Cargar documento
                    </button>
                </div>
            </div>
        </form>
        <!-- Botón para abrir el modal y cargar un nuevo documento -->
        <div class="mb-3">

        </div>

        <!-- Tabla de documentos asociados -->
        <h3>Documentos Asociados</h3>
        <table class="table table-striped">
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
                            <!-- Botón de ver documento -->
                            <a href="{{ route('documentos.show', $documento->id) }}" class="btn btn-info btn-sm">
                                Ver
                            </a>
                            <!-- Botón de eliminar documento -->
                            <form action="{{ route('documentos.destroy', $documento->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Está seguro de eliminar este documento?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">No hay documentos asociados a esta junta.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="modal fade" id="addDocumentModal" tabindex="-1" aria-labelledby="addDocumentModalLabel" aria-hidden="true">
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
                            <label for="nomanexo" class="form-label">Nombre del Documento</label>
                            <input type="text" name="nomanexo" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="archivo" class="form-label">Archivo</label>
                            <input type="file" name="archivo" class="form-control" required>
                        </div>
                        <input type="hidden" name="junta_id" value="{{ $junta->id }}">
                        <button type="submit" class="btn btn-success">Cargar Documento</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
