@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ isset($junta) ? 'Editar' : 'Crear' }} Junta</h1>
        <hr>
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
                    <label for="nombre">Razon social</label>
                    <input type="text" name="nombre" value="{{ old('nombre', $junta->nombre ?? '') }}"
                        class="form-control" required>
                </div>
                <div class="mb-3 col-6">
                    <label for="resolucion">Resolución</label>
                    <input type="text" name="resolucion" value="{{ old('resolucion', $junta->resolucion ?? '') }}"
                        class="form-control" required>
                </div>
                <div class="mb-3 col-6">
                    <label for="personeria">Personeria</label>
                    <input type="text" name="personeria" value="{{ old('personeria', $junta->personeria ?? '') }}"
                        class="form-control" required>
                </div>
                <div class="mb-3 col-6">
                    <label for="fecha_resolucion">Fecha resolución</label>
                    <input type="date" name="fecha_resolucion"
                        value="{{ old('fecha_resolucion', $junta->fecha_resolucion ?? '') }}" class="form-control" required>
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
                            <option value="{{ $m->id }}">{{ $m->nombre_municipio }}</option>
                        @endforeach
                    </select>
                </div>
                <!-- Select para Presidente -->
                <div class="mb-3">
                    <label for="presidente">Presidente</label>
                    <select name="presidente_id" id="presidente" class="form-select select2" style="width: 100%">
                        <option value="">Seleccione el presidente</option>
                        @foreach ($funcionarios as $funcionario)
                            <option value="{{ $funcionario->id }}">{{ $funcionario->num_documento }} -
                                {{ $funcionario->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <!-- Select para Vicepresidente -->
                <div class="mb-3">
                    <label for="vicepresidente">Vicepresidente</label>
                    <select name="vicepresidente_id" id="vicepresidente" class="form-select select2" style="width: 100%">
                        <option value="">Seleccione el vicepresidente</option>
                        @foreach ($funcionarios as $funcionario)
                            <option value="{{ $funcionario->id }}">{{ $funcionario->num_documento }} -
                                {{ $funcionario->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <!-- Select para Secretario -->
                <div class="mb-3">
                    <label for="secretario">Secretario</label>
                    <select name="secretario_id" id="secretario" class="form-select select2" style="width: 100%">
                        <option value="">Seleccione el secretario</option>
                        @foreach ($funcionarios as $funcionario)
                            <option value="{{ $funcionario->id }}">{{ $funcionario->num_documento }} -
                                {{ $funcionario->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <!-- Select para Tesorero -->
                <div class="mb-3">
                    <label for="tesorero">Tesorero</label>
                    <select name="tesorero_id" id="tesorero" class="form-select select2" style="width: 100%">
                        <option value="">Seleccione el tesorero</option>
                        @foreach ($funcionarios as $funcionario)
                            <option value="{{ $funcionario->id }}">{{ $funcionario->num_documento }} -
                                {{ $funcionario->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <!-- Select para Fiscal -->
                <div class="mb-3">
                    <label for="fiscal">Fiscal</label>
                    <select name="fiscal_id" id="fiscal" class="form-select select2" style="width: 100%">
                        <option value="">Seleccione el fiscal</option>
                        @foreach ($funcionarios as $funcionario)
                            <option value="{{ $funcionario->id }}">{{ $funcionario->num_documento }} -
                                {{ $funcionario->nombre }}</option>
                        @endforeach
                    </select>
                </div>


                {{-- <div class="mb-3">
                    <label for="comuna">Comuna de la junta</label>
                    <select name="comuna_id" id="comuna" class="form-select select2" style="width: 100%" required>
                        <option value="">Seleccione comuna</option>
                        @foreach ($comunas as $c)
                            <option value="{{ $c->id }}">{{ $c->nombre }}</option>
                        @endforeach
                    </select>
                </div> --}}
                <div class="mb-3 col-12">
                    <button type="submit" class="btn btn-success">{{ isset($junta) ? 'Actualizar' : 'Crear' }}</button>
                </div>
            </div>
        </form>
    </div>
@endsection
