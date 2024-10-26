@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Lista de Dignatarios</h1>
        <a href="{{ route('funcionarios.create') }}" class="btn btn-primary mb-3">Crear Nuevo</a>
        @if ($message = Session::get('success'))
            <div class="alert alert-success text-white">
                {{ $message }}
            </div>
        @endif
        <form action="{{ route('funcionarios.index') }}" method="GET" role="search">
            <div class="input-group mb-3">
                <input type="text" name="search" class="form-control" placeholder="Buscar funcionarios..." value="{{ request('search') }}">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit">Buscar</button>
                </div>
            </div>
        </form>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Tipo Documento</th>
                    <th>Num Documento</th>
                    <th>Profesión</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($funcionarios as $funcionario)
                    <tr>
                        <td>{{ $funcionario->nombre }}</td>
                        <td>{{ $funcionario->tipo_documento }}</td>
                        <td>{{ $funcionario->num_documento }}</td>
                        <td>{{ $funcionario->profesion }}</td>
                        <td>
                            <a href="{{ route('funcionarios.edit', $funcionario->id) }}" class="btn btn-warning">Editar</a>
                            <form action="{{ route('funcionarios.destroy', $funcionario->id) }}" method="POST" style="display:inline;">
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
            {{ $funcionarios->appends(['search' => request('search')])->links('pagination::bootstrap-4') }}
        </div>
    </div>
@endsection
