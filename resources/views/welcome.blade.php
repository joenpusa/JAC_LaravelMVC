@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                  <button class="nav-link active" id="generate-tab" data-bs-toggle="tab" data-bs-target="#generate" type="button" role="tab" aria-controls="home" aria-selected="true">Generar certificado</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="validate-tab" data-bs-toggle="tab" data-bs-target="#validate" type="button" role="tab" aria-controls="profile" aria-selected="false">Validar Certificado</button>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="generate" role="tabpanel" aria-labelledby="generate-tab">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="container">
                            <p class="mt-3">
                                Para generar un certificado debes seleccionar la JAC a la que perteneces y posteriormente
                                digitar el número de documento  del dignatario que está registrado asociado como presidente.
                                Si los datos son correctos, se descargará automáticamente  el documento en PDF con un código
                                único de confirmación
                            </p>
                        </div>
                    </form>
                </div>
                <div class="tab-pane fade" id="validate" role="tabpanel" aria-labelledby="validate-tab">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="container">
                            <p class="mt-3">
                                Para validar un certificado, digita el número único del documento y su fecha de expedición en cada uno de los campos del formulario.
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
