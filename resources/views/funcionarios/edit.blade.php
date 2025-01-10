@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ isset($funcionario) ? 'Editar' : 'Crear' }} Dignatario</h1>
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
            action="{{ isset($funcionario) ? route('funcionarios.update', $funcionario->id) : route('funcionarios.store') }}"
            method="POST">
            @csrf
            @if (isset($funcionario))
                @method('PUT')
            @endif
            <div class="row">
                <div class="mb-3">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" value="{{ old('nombre', $funcionario->nombre ?? '') }}"
                        class="form-control" required>
                </div>
                <div class="mb-3 col-6">
                    <label for="tipo_documento">Tipo de Documento</label>
                    <select name="tipo_documento" id="tipo_documento" class="form-select" required>
                        <option value="">Seleccione el tipo de documento</option>
                        <option value="Cedula de Ciudadania"
                            {{ old('tipo_documento', $funcionario->tipo_documento) == 'Cedula de Ciudadania' ? 'selected' : '' }}>
                            Cédula de Ciudadanía</option>
                        <option value="PPT"
                            {{ old('tipo_documento', $funcionario->tipo_documento) == 'PPT' ? 'selected' : '' }}>PPT
                        </option>
                        <option value="Cedula de Extrangeria"
                            {{ old('tipo_documento', $funcionario->tipo_documento) == 'Cedula de Extrangeria' ? 'selected' : '' }}>
                            Cédula de Extranjería</option>
                        <option value="Tarjeta de Identidad"
                            {{ old('tipo_documento', $funcionario->tipo_documento) == 'Tarjeta de Identidad' ? 'selected' : '' }}>
                            Tarjeta de Identidad</option>
                    </select>
                </div>

                <div class="mb-3 col-6">
                    <label for="num_documento">Documento</label>
                    <input type="number" name="num_documento"
                        value="{{ old('num_documento', $funcionario->num_documento ?? '') }}" class="form-control"
                        required>
                </div>
                <div class="mb-3 col-6">
                    <label for="num_afiliacion">Numero afiliación</label>
                    <input type="number" name="num_afiliacion"
                        value="{{ old('num_afiliacion', $funcionario->num_afiliacion ?? '') }}" class="form-control"
                        required>
                </div>
                <div class="mb-3 col-6">
                    <label for="email">Email</label>
                    <input type="email" name="email" value="{{ old('email', $funcionario->email ?? '') }}"
                        class="form-control" required>
                </div>
                <div class="mb-3 col-6">
                    <label for="profesion">Profesión</label>
                    <input type="text" name="profesion" value="{{ old('profesion', $funcionario->profesion ?? '') }}"
                        class="form-control" required>
                </div>
                <div class="mb-3 col-6">
                    <label for="genero">Género</label>
                    <select name="genero" id="genero" class="form-select" required>
                        <option value="">Seleccione el género</option>
                        <option value="Hombre" {{ old('genero', $funcionario->genero) == 'Hombre' ? 'selected' : '' }}>
                            Hombre</option>
                        <option value="Mujer" {{ old('genero', $funcionario->genero) == 'Mujer' ? 'selected' : '' }}>Mujer
                        </option>
                    </select>
                </div>

                <div class="mb-3 col-6">
                    <label for="discapacidad">Discapacidad</label>
                    <select name="discapacidad" id="discapacidad" class="form-select" required>
                        <option value="">Seleccione</option>
                        <option value="1"
                            {{ old('discapacidad', $funcionario->discapacidad) == '1' ? 'selected' : '' }}>Si</option>
                        <option value="0"
                            {{ old('discapacidad', $funcionario->discapacidad) == '0' ? 'selected' : '' }}>No</option>
                    </select>
                </div>
                <div class="mb-3 col-6">
                    <label for="grupo_etnico">Grupo etnico</label>
                    <select name="grupo_etnico" id="grupo_etnico" class="form-select" required>
                        <option value="Ninguno"
                            {{ old('grupo_etnico', $funcionario->grupo_etnico) == 'Ninguno' ? 'selected' : '' }}>Ninguno
                        </option>
                        <option value="Negro"
                            {{ old('grupo_etnico', $funcionario->grupo_etnico) == 'Negro' ? 'selected' : '' }}>Negro
                        </option>
                        <option value="Palenquero"
                            {{ old('grupo_etnico', $funcionario->grupo_etnico) == 'Palenquero' ? 'selected' : '' }}>
                            Palenquero</option>
                        <option value="Gitano"
                            {{ old('grupo_etnico', $funcionario->grupo_etnico) == 'Gitano' ? 'selected' : '' }}>Gitano
                        </option>
                        <option value="Indigena"
                            {{ old('grupo_etnico', $funcionario->grupo_etnico) == 'Indigena' ? 'selected' : '' }}>Indigena
                        </option>
                        <option value="Rom"
                            {{ old('grupo_etnico', $funcionario->grupo_etnico) == 'Rom' ? 'selected' : '' }}>Rom</option>
                    </select>
                </div>
                <div class="mb-3 col-6">
                    <label for="direccion">Dirección</label>
                    <input type="text" name="direccion" value="{{ old('direccion', $funcionario->direccion ?? '') }}"
                        class="form-control" required>
                </div>

                <div class="mb-3 col-12">
                    <button type="submit"
                        class="btn btn-success">{{ isset($funcionario) ? 'Actualizar' : 'Crear' }}</button>
                </div>
            </div>
        </form>
        <div aria-live="polite" aria-atomic="true" style="position: relative; z-index: 9999;">
            <div id="toast-container" style="position: fixed; top: 20px; right: 20px;"></div>
        </div>
        <div class="mb-3 row align-items-center">
            <label for="direccion" class="form-label col-auto">Soporte Documental</label>
            <div class="col">
                <form id="uploadForm" action="{{ route('funcionario.upload') }}" method="POST"
                    enctype="multipart/form-data" class="d-flex align-items-center">
                    @csrf
                    @method('PUT')
                    <input type="file" id="document" name="document" class="form-control me-2" accept=".pdf,.zip"
                        required>
                    <input type="hidden" value="{{ $funcionario->id }}" name="funcionario_id">
                    <button type="submit" class="btn btn-default me-2">Cargar</button>
                    @if (isset($funcionario->key_anexo))
                        <a href="{{ asset('storage/documents/funcionarios/' . $funcionario->key_anexo) }}" target="_blank"
                            class="btn btn-primary">Ver</a>
                    @endif
                </form>
            </div>
        </div>
    </div>

@endsection
