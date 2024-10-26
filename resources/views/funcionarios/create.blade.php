@extends('layouts.app')
@section('content')
    <div class="container">
        <h1>{{ isset($funcionario) ? 'Editar' : 'Crear' }} Dignatario</h1>
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show text-white" role="alert">
                <p>Proceso no realizado:</p>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form action="{{ isset($funcionario) ? route('funcionarios.update', $funcionario->id) : route('funcionarios.store') }}" method="POST">
            @csrf
            @if (isset($funcionario))
                @method('PUT')
            @endif
            <div class="row">
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" name="nombre" value="{{ old('nombre', $funcionario->nombre ?? '') }}" class="form-control" required>
                </div>
                <div class="mb-3 col-6">
                    <label for="tipo_documento" class="form-label">Tipo de Documento</label>
                    <select name="tipo_documento" id="tipo_documento" class="form-select" required>
                        <option value="">Seleccione el tipo de documento</option>
                        <option value="Cedula de Ciudadania">Cédula de Ciudadanía</option>
                        <option value="PPT">PPT</option>
                        <option value="Cedula de Extrangeria">Cédula de Extranjería</option>
                        <option value="Tarjeta de Identidad">Tarjeta de Identidad</option>
                    </select>
                </div>
                <div class="mb-3 col-6">
                    <label for="num_documento" class="form-label">Documento</label>
                    <input type="number" name="num_documento" value="{{ old('num_documento', $funcionario->num_documento ?? '') }}" class="form-control" required>
                </div>
                <div class="mb-3 col-6">
                    <label for="num_afiliacion" class="form-label">Numero afiliación</label>
                    <input type="number" name="num_afiliacion" value="{{ old('num_afiliacion', $funcionario->num_afiliacion ?? '') }}" class="form-control" required>
                </div>
                <div class="mb-3 col-6">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" value="{{ old('email', $funcionario->email ?? '') }}" class="form-control" required>
                </div>
                <div class="mb-3 col-6">
                    <label for="profesion" class="form-label">Profesión</label>
                    <input type="text" name="profesion" value="{{ old('profesion', $funcionario->profesion ?? '') }}" class="form-control" required>
                </div>
                <div class="mb-3 col-6">
                    <label for="genero" class="form-label">Genero</label>
                    <select name="genero" id="genero" class="form-select" required>
                        <option value="">Seleccione el genero</option>
                        <option value="Hombre">Hombre</option>
                        <option value="Mujer">Mujer</option>
                    </select>
                </div>
                <div class="mb-3 col-6">
                    <label for="discapacidad" class="form-label">Discapacidad</label>
                    <select name="discapacidad" id="discapacidad" class="form-select" required>
                        <option value="">Seleccione</option>
                        <option value="1">Si</option>
                        <option value="0">No</option>
                    </select>
                </div>
                <div class="mb-3 col-6">
                    <label for="grupo_etnico" class="form-label">Grupo etnico</label>
                    <select name="grupo_etnico" id="grupo_etnico" class="form-select" required>
                        <option value="Ninguno">Ninguno</option>
                        <option value="Negro">Negro</option>
                        <option value="Palenquero">Palenquero</option>
                        <option value="Gitano">Gitano</option>
                        <option value="Indigena">Indigena</option>
                        <option value="Rom">Rom</option>
                    </select>
                </div>
                <div class="mb-3 col-6">
                    <label for="direccion" class="form-label">Dirección</label>
                    <input type="text" name="direccion" value="{{ old('direccion', $funcionario->direccion ?? '') }}" class="form-control" required>
                </div>
                <div class="mb-3 col-12">
                    <button type="submit" class="btn btn-success">{{ isset($funcionario) ? 'Actualizar' : 'Crear' }}</button>
                </div>
            </div>
        </form>
    </div>
@endsection
