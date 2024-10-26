@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Lista de Cumunas</h1>
        <a href="{{ route('comunas.create') }}" class="btn btn-primary mb-3">Crear Nueva</a>
        @if ($message = Session::get('success'))
            <div class="alert alert-success text-white">
                {{ $message }}
            </div>
        @endif
        <form action="{{ route('comunas.index') }}" method="GET" role="search">
            <div class="input-group mb-3">
                <input type="text" name="search" class="form-control" placeholder="Buscar comunas..." value="{{ request('search') }}">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit">Buscar</button>
                </div>
            </div>
        </form>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Municipio</th>
                    <th>Nombre</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($comunas as $c)
                    <tr>
                        <td>{{ $c->municipio->nombre_municipio }}</td>
                        <td>{{ $c->nombre }}</td>
                        <td>
                            <form action="{{ route('comunas.destroy', $c->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
