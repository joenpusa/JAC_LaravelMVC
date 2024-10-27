@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Lista de Usuarios</h1>
        <a href="{{ route('users.create') }}" class="btn btn-primary mb-3">Crear Nuevo</a>
        @if ($errors->any() || $message = Session::get('error'))
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
        <form action="{{ route('users.index') }}" method="GET" role="search">
            <div class="input-group mb-3">
                <input type="text" name="search" class="form-control" placeholder="Buscar usuarios..." value="{{ request('search') }}">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit">Buscar</button>
                </div>
            </div>
        </form>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->role->name ?? 'Sin Rol' }}</td>
                        <td>
                            @if (auth()->user()->role->name === 'administrador')
                                <form action="{{ route('users.toggleActive', $user) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn bnt-xs {{ $user->activo ? 'btn-danger' : 'btn-success' }}">
                                        {{ $user->activo ? 'Desactivar' : 'Activar' }}
                                    </button>
                                </form>
                                <form action="{{ route('users.resetPassword', $user) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-warning">
                                        Restablecer contraseña
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-center">
            {{ $users->appends(['search' => request('search')])->links('pagination::bootstrap-4') }}
        </div>
    </div>
@endsection
