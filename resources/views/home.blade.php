@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">OPA JAC Cúcuta</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    Es aplicación permite la creación y validación de certificados de juntas de acción comunal
                    generado de manera online por los dignatarios de cada Junta
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
