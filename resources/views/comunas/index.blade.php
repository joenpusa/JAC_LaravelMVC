@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Lista de Cumunas</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Nombre</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($comunas as $c)
                    <tr>
                        <td>{{ $c->id }}</td>
                        <td>{{ $c->nombre }}</td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
