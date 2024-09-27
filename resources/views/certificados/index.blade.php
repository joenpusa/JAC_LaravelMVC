@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Historial de certificados certificados</h1>
        <form action="{{ route('certificados.index') }}" method="GET" role="search">
            <div class="input-group mb-3">
                <input type="text" name="search" class="form-control" placeholder="Buscar certificado..." value="{{ request('search') }}">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit">Buscar</button>
                </div>
            </div>
        </form>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Fecha Generación</th>
                    <th>Junta y Comuna</th>
                    <th>Documento dignatario</th>
                    <th>Dignatario certificado</th>
                    <th>Codigo verificación</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($certificados as $c)
                    <tr>
                        <td>{{ $c->created_at->format('d/m/Y H:i') }}</td>
                        <td>{{ $c->nombre_junta }} - {{ $c->comuna }}</td>
                        <td>{{ $c->documento_dignario }}</td>
                        <td>{{ $c->nombre_dignatario }}</td>
                        <td>{{ $c->codigo_hash }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-center">
            {{ $certificados->appends(['search' => request('search')])->links('pagination::bootstrap-4') }}
        </div>
    </div>
@endsection
