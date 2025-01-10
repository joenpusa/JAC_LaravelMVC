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
        <form action="{{ isset($junta) ? route('juntas.update', $junta->id) : route('juntas.store') }}" method="POST">
            @csrf
            @if (isset($junta))
                @method('PUT')
            @endif
            <div class="row">
                <div class="mb-3 col-6">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" value="{{ old('nombre', $junta->nombre ?? '') }}"
                        class="form-control" required>
                </div>
                <div class="mb-3 col-6">
                    <label for="resolucion">Resolución</label>
                    <input type="text" name="resolucion" value="{{ old('resolucion', $junta->resolucion ?? '') }}"
                        class="form-control" required>
                </div>

                <div class="mb-3 col-6">
                    <label for="fecha_resolucion">Fecha resolución</label>
                    <input type="date" name="fecha_resolucion"
                        value="{{ old('fecha_resolucion', $junta->fecha_resolucion ?? '') }}" class="form-control" required>
                </div>
                <div class="mb-3 col-6">
                    <label for="fecha_eleccion">Fecha elección</label>
                    <input type="date" name="fecha_eleccion"
                        value="{{ old('fecha_eleccion', $junta->fecha_eleccion ?? '') }}" class="form-control" required>
                </div>
                <!-- Select para Presidente -->
                <div class="mb-3">
                    <label for="presidente">Presidente</label>
                    <select name="presidente_id" id="presidente" class="form-select form-control" required>
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
                    <select name="vicepresidente_id" id="vicepresidente" class="form-select form-control" required>
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
                    <select name="secretario_id" id="secretario" class="form-select form-control" required>
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
                    <select name="tesorero_id" id="tesorero" class="form-select form-control" required>
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
                    <select name="fiscal_id" id="fiscal" class="form-select form-control" required>
                        <option value="">Seleccione el fiscal</option>
                        @foreach ($funcionarios as $funcionario)
                            <option value="{{ $funcionario->id }}">{{ $funcionario->num_documento }} -
                                {{ $funcionario->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <!-- Select para Concil1 -->
                <div class="mb-3">
                    <label for="concil1">Conciliador 1</label>
                    <select name="concil1_id" id="concil1" class="form-select form-control" required>
                        <option value="">Seleccione el conciliador 1</option>
                        @foreach ($funcionarios as $funcionario)
                            <option value="{{ $funcionario->id }}">{{ $funcionario->num_documento }} -
                                {{ $funcionario->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="concil2">Conciliador 2</label>
                    <select name="concil2_id" id="concil2" class="form-select form-control" required>
                        <option value="">Seleccione el conciliador 2</option>
                        @foreach ($funcionarios as $funcionario)
                            <option value="{{ $funcionario->id }}">{{ $funcionario->num_documento }} -
                                {{ $funcionario->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="concil3">Conciliador 3</label>
                    <select name="concil3_id" id="concil3" class="form-select form-control" required>
                        <option value="">Seleccione el conciliador 3</option>
                        @foreach ($funcionarios as $funcionario)
                            <option value="{{ $funcionario->id }}">{{ $funcionario->num_documento }} -
                                {{ $funcionario->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="delegado1">Delegado 1</label>
                    <select name="delegado1_id" id="delegado1" class="form-select form-control" required>
                        <option value="">Seleccione el delegado 1</option>
                        @foreach ($funcionarios as $funcionario)
                            <option value="{{ $funcionario->id }}">{{ $funcionario->num_documento }} -
                                {{ $funcionario->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="delegado2">Delegado 2</label>
                    <select name="delegado2_id" id="delegado2" class="form-select form-control" required>
                        <option value="">Seleccione el delegado 2</option>
                        @foreach ($funcionarios as $funcionario)
                            <option value="{{ $funcionario->id }}">{{ $funcionario->num_documento }} -
                                {{ $funcionario->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="delegado3">Delegado 3</label>
                    <select name="delegado3_id" id="delegado3" class="form-select form-control" required>
                        <option value="">Seleccione el delegado 3</option>
                        @foreach ($funcionarios as $funcionario)
                            <option value="{{ $funcionario->id }}">{{ $funcionario->num_documento }} -
                                {{ $funcionario->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="comuna">Comuna de la junta</label>
                    <select name="comuna_id" id="comuna" class="form-select form-control" required>
                        <option value="">Seleccione comuna</option>
                        @foreach ($comunas as $c)
                            <option value="{{ $c->id }}">{{ $c->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3 col-12">
                    <button type="submit" class="btn btn-success">{{ isset($junta) ? 'Actualizar' : 'Crear' }}</button>
                </div>
            </div>
        </form>
    </div>
@endsection
