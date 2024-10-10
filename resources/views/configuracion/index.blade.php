@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Configuración de la Aplicación</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('configuracion.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-6">
                <label for="nombre_app">Nombre de la aplicación</label>
                <input type="text" class="form-control" name="nombre_app" value="{{ $config->nombre_app ?? '' }}" required>
            </div>
            <div class="col-6">
                <label for="nombre_app">Nombre de la entidad</label>
                <input type="text" class="form-control" name="nombre_app" value="{{ $config->nombre_entidad ?? '' }}" required>
            </div>
            <div class="col-6">
                <label for="direccion">Dirección</label>
                <input type="text" class="form-control" name="direccion" value="{{ $config->direccion ?? '' }}" required>
            </div>

            <div class="col-6">
                <label for="horario">Horario de funcionamiento</label>
                <input type="text" class="form-control" name="horario" value="{{ $config->horario ?? '' }}" required>
            </div>

            <div class="col-6">
                <label for="telefono">Teléfono</label>
                <input type="text" class="form-control" name="telefono" value="{{ $config->telefono ?? '' }}" required>
            </div>

            <div class="col-6">
                <label for="email">Email de contacto</label>
                <input type="email" class="form-control" name="email" value="{{ $config->email ?? '' }}" required>
            </div>

            <div class="col-6">
                <label for="logo">Logo de la entidad</label>
                <input type="file" class="form-control" name="logo">
                @if($config && $config->logo)
                    <img src="{{ asset('storage/' . $config->logo) }}" alt="Logo" class="img-fluid mt-2" width="150">
                @endif
            </div>
        </div>
        <button type="submit" class="btn btn-primary mt-2">Guardar Configuración</button>
    </form>
</div>
@endsection
