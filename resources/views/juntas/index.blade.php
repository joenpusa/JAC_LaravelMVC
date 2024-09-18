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
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Comuna</th>
                    <th>Resolución</th>
                    <th>Presidente</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($juntas as $j)
                    <tr>
                        <td>{{ $j->comuna->nombre }}</td>
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
    </div>
@endsection
