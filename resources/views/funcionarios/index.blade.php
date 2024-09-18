@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Lista de Dignatarios</h1>
        <a href="{{ route('funcionarios.create') }}" class="btn btn-primary mb-3">Crear Nuevo</a>
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                {{ $message }}
            </div>
        @endif
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Documento</th>
                    <th>Profesión</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($funcionarios as $funcionario)
                    <tr>
                        <td>{{ $funcionario->nombre }}</td>
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
    </div>
@endsection
