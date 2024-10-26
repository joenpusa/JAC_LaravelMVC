
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ isset($comuna) ? 'Editar' : 'Crear' }} Comuna</h1>
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
        <form action="{{ isset($comuna) ? route('comunas.update', $comuna->id) : route('comunas.store') }}" method="POST">
            @csrf
            @if (isset($comuna))
                @method('PUT')
            @endif
            <div class="row">
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" name="nombre" value="{{ old('nombre', $comuna->nombre ?? '') }}" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="municipio" class="form-label">Municipio</label>
                    <select name="municipio_id" id="municipio_id" class="form-select select2 form-control" required>
                        <option value="">Seleccione municipio</option>
                        @foreach ($municipios as $c)
                            <option value="{{ $c->id }}">{{ $c->nombre_municipio }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3 col-12">
                    <button type="submit" class="btn btn-success">{{ isset($comuna) ? 'Actualizar' : 'Crear' }}</button>
                </div>
            </div>
        </form>
    </div>
@endsection
