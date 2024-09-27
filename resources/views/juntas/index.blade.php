@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Lista de Juntas</h1>
        <a href="{{ route('juntas.create') }}" class="btn btn-primary mb-3">Crear Nueva</a>
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                {{ $message }}
            </div>
        @endif
        <form action="{{ route('juntas.index') }}" method="GET" role="search">
            <div class="input-group mb-3">
                <input type="text" name="search" class="form-control" placeholder="Buscar juntas..." value="{{ request('search') }}">
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
                @foreach ($juntas as $j)
                    <tr>
                        <td>{{ $j->comuna->nombre }}</td>
                        <td>{{ $j->nombre }}</td>
                        <td>{{ $j->resolucion }}</td>
                        <td>{{ $j->presidente->nombre }}</td>
                        <td>
                            <a href="{{ route('juntas.edit', $j->id) }}" class="btn btn-warning">Editar</a>
                            <form action="{{ route('juntas.destroy', $j->id) }}" method="POST" style="display:inline;">
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
            {{ $juntas->appends(['search' => request('search')])->links('pagination::bootstrap-4') }}
        </div>
    </div>
@endsection
