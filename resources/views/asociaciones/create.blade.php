@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ isset($asociacion) ? 'Editar' : 'Crear' }} Asociación</h1>
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
        <form action="{{ isset($asociacion) ? route('asociaciones.update', $asociacion->id) : route('asociaciones.store') }}"
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
                            <option value="{{ $m->id }}" {{ old('municipio_id', $asociacion->municipio_id ?? '') == $m->id ? 'selected' : '' }}>
                                {{ $m->nombre_municipio }}
                            </option>
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
                    <input type="text" name="tipo_oac" value="{{ old('tipo_oac', $asociacion->tipo_oac ?? 'ASOCOMUNAL') }}" class="form-control">
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
                            <option value="{{ $funcionario->id }}" {{ old('presidente_id', $asociacion->presidente_id ?? '') == $funcionario->id ? 'selected' : '' }}>
                                {{ $funcionario->num_documento }} - {{ $funcionario->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <!-- Select para Vicepresidente -->
                <div class="mb-3">
                    <label for="vicepresidente">Vicepresidente</label>
                    <select name="vicepresidente_id" id="vicepresidente" class="form-select select2" style="width: 100%">
                        <option value="">Seleccione el vicepresidente</option>
                        @foreach ($funcionarios as $funcionario)
                            <option value="{{ $funcionario->id }}" {{ old('vicepresidente_id', $asociacion->vicepresidente_id ?? '') == $funcionario->id ? 'selected' : '' }}>
                                {{ $funcionario->num_documento }} - {{ $funcionario->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <!-- Select para Secretario -->
                <div class="mb-3">
                    <label for="secretario">Secretario</label>
                    <select name="secretario_id" id="secretario" class="form-select select2" style="width: 100%">
                        <option value="">Seleccione el secretario</option>
                        @foreach ($funcionarios as $funcionario)
                            <option value="{{ $funcionario->id }}" {{ old('secretario_id', $asociacion->secretario_id ?? '') == $funcionario->id ? 'selected' : '' }}>
                                {{ $funcionario->num_documento }} - {{ $funcionario->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <!-- Select para Tesorero -->
                <div class="mb-3">
                    <label for="tesorero">Tesorero</label>
                    <select name="tesorero_id" id="tesorero" class="form-select select2" style="width: 100%">
                        <option value="">Seleccione el tesorero</option>
                        @foreach ($funcionarios as $funcionario)
                            <option value="{{ $funcionario->id }}" {{ old('tesorero_id', $asociacion->tesorero_id ?? '') == $funcionario->id ? 'selected' : '' }}>
                                {{ $funcionario->num_documento }} - {{ $funcionario->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <!-- Select para Fiscal -->
                <div class="mb-3">
                    <label for="fiscal">Fiscal</label>
                    <select name="fiscal_id" id="fiscal" class="form-select select2" style="width: 100%">
                        <option value="">Seleccione el fiscal</option>
                        @foreach ($funcionarios as $funcionario)
                            <option value="{{ $funcionario->id }}" {{ old('fiscal_id', $asociacion->fiscal_id ?? '') == $funcionario->id ? 'selected' : '' }}>
                                {{ $funcionario->num_documento }} - {{ $funcionario->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3 col-12">
                    <button type="submit"
                        class="btn btn-success">{{ isset($asociacion) ? 'Actualizar' : 'Crear' }}</button>
                    <a href="{{ route('asociaciones.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </div>
        </form>
    </div>
@endsection
