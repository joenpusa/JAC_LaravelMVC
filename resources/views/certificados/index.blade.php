@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Historial de certificados certificados</h1>
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
            {{ $certificados->links('pagination::bootstrap-4') }}
        </div>
    </div>
@endsection
