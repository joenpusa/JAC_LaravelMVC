@extends('layouts.app_out')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show mt-2 mb-2" role="alert">
                        <p>Proceso no realizado:</p>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show mt-2 mb-2" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="generate-tab" data-bs-toggle="tab" data-bs-target="#generate"
                            type="button" role="tab" aria-controls="home" aria-selected="true">Tramites JAC</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="generate-tab" data-bs-toggle="tab" data-bs-target="#generateAso"
                            type="button" role="tab" aria-controls="homeAso" aria-selected="true">Tramites
                            Asociación</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="validate-tab" data-bs-toggle="tab" data-bs-target="#validate"
                            type="button" role="tab" aria-controls="profile" aria-selected="false">Validar
                            Certificados</button>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="generate" role="tabpanel" aria-labelledby="generate-tab">
                        <form method="POST" action="{{ route('certificado.generar') }}">
                            @csrf
                            <div class="container">
                                <div class="mb-3">
                                    <label for="juntas">Juntas</label>
                                    <select name="junta_id" id="junta_id" class="form-select form-control" required>
                                        <option value="">Seleccione la JAC</option>
                                        @foreach ($juntas as $j)
                                            <option value="{{ $j->id }}">{{ $j->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="num_documento" class="form-label">Documento Presidente</label>
                                    <input type="number" name="num_documento" id="num_documento" class="form-control"
                                        required>
                                </div>
                                <div class="mb-3 col-12">
                                    <button type="submit" class="btn btn-primary">Generar</button>
                                    <button type="button" class="btn btn-secundary"
                                        onclick="descargarArchivosJunta()">Solicitar Documentos</button>
                                </div>
                                <p class="mt-3">
                                    Para generar un certificado debes seleccionar la JAC a la que perteneces y
                                    posteriormente
                                    digitar el número de documento del dignatario que está registrado asociado como
                                    presidente.
                                    Si los datos son correctos, se descargará automáticamente el documento en PDF con un
                                    código único de confirmación
                                </p>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="generateAso" role="tabpanel" aria-labelledby="generateAso-tab">
                        <form method="POST" action="{{ route('certificado.generarAso') }}">
                            @csrf
                            <div class="container">
                                <div class="mb-3">
                                    <label for="asociaciones">Asociaciones</label>
                                    <select name="asociacion_id" id="asociacion_id" class="form-select form-control"
                                        required>
                                        <option value="">Seleccione la Asociación</option>
                                        @foreach ($asociaciones as $j)
                                            <option value="{{ $j->id }}">{{ $j->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="num_documentoAso">Documento Presidente</label>
                                    <input type="number" name="num_documentoAso" id="num_documentoAso" class="form-control"
                                        required>
                                </div>
                                <div class="mb-3 col-12">
                                    <button type="submit" class="btn btn-primary">Generar</button>
                                    <button type="button" class="btn btn-secundary"
                                        onclick="descargarArchivosAsociacion()">Solicitar Documentos</button>
                                </div>
                                <p class="mt-3">
                                    Para generar un certificado debes seleccionar la asociación a la que perteneces y
                                    posteriormente
                                    digitar el número de documento del dignatario que está registrado asociado como
                                    presidente.
                                    Si los datos son correctos, se descargará automáticamente el documento en PDF con un
                                    código único de confirmación
                                </p>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="validate" role="tabpanel" aria-labelledby="validate-tab">
                        <form method="POST" action="{{ route('certificado.validar') }}">
                            @csrf
                            <div class="container">


                                <div class="mb-3">
                                    <label for="fecha_certificado" class="form-label">Fecha certificado</label>
                                    <input type="date" name="fecha_certificado" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="cod_certificado" class="form-label">Codigo certificado</label>
                                    <input type="text" name="cod_certificado" class="form-control" required>
                                </div>
                                <div class="mb-3 col-12">
                                    <button type="submit" class="btn btn-primary">Validar</button>
                                </div>
                                <p class="mt-3">
                                    Para validar un certificado, digita el número único del documento y su fecha de
                                    expedición en cada uno de los campos del formulario.
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function descargarArchivosJunta() {
            const juntaId = document.getElementById('junta_id').value;
            const numDocumento = document.getElementById('num_documento').value;

            if (!juntaId || !numDocumento) {
                alert('Por favor selecciona una junta y digita el número de documento del presidente.');
                return;
            }
            window.location.href = `/juntas/${juntaId}/descargar-archivos/${numDocumento}`;
        }

        function descargarArchivosAsociacion() {
            const asociacionId = document.getElementById('asociacion_id').value;
            const numDocumento = document.getElementById('num_documentoAso').value;

            if (!asociacionId || !numDocumento) {
                alert('Por favor selecciona una asociación y digita el número de documento del presidente.');
                return;
            }
            window.location.href = `/asociaciones/${asociacionId}/descargar-archivos/${numDocumento}`;
        }
    </script>

@endsection
