@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Lista de Asociaciones</h1>
        <a href="{{ route('asociaciones.create') }}" class="btn btn-primary mb-3">Crear Nueva</a>
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
        <form action="{{ route('asociaciones.index') }}" method="GET" role="search">
            <div class="input-group mb-3">
                <input type="text" name="search" class="form-control" placeholder="Buscar asociaciones..."
                    value="{{ request('search') }}">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit">Buscar</button>
                </div>
            </div>
        </form>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Comuna</th>
                    <th>Nombre</th>
                    <th>Resolución</th>
                    <th>Presidente</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($asociaciones as $j)
                    <tr>
                        <td>{{ $j->comuna->nombre }}</td>
                        <td>{{ $j->nombre }}</td>
                        <td>{{ $j->resolucion }}</td>
                        <td>{{ $j->presidente->nombre }}</td>
                        <td>
                            <a href="{{ route('asociaciones.edit', $j->id) }}" class="btn btn-warning">Editar</a>
                            <form action="{{ route('asociaciones.destroy', $j->id) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-center">
            {{ $asociaciones->appends(['search' => request('search')])->links('pagination::bootstrap-4') }}
        </div>
    </div>
@endsection