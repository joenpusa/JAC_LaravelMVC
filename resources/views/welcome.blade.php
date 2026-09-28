@extends('layouts.app_out')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @if ($errors->any())
                    <div class="alert alert-outline-danger d-flex align-items-center" role="alert">
                        <i class="material-icons opacity-10">error</i>
                        <p class="mb-0 ml-2 flex-1">Proceso no realizado:
                            @foreach ($errors->all() as $error)
                                {{ $error }}<br>
                            @endforeach
                        </p>
                        <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('success') && !session('certificado_validado'))
                    <div class="alert alert-success alert-dismissible fade show mt-2 mb-2" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <ul class="nav nav-underline" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ session('tab') === 'validate' ? '' : 'active' }}" id="generate-tab" data-bs-toggle="tab" data-bs-target="#generate"
                            type="button" role="tab" aria-controls="home" aria-selected="{{ session('tab') === 'validate' ? 'false' : 'true' }}">
                            <div class="d-flex align-items-center">
                                <i class="material-icons opacity-10">diversity_1</i>
                                <span class="ms-2">Tramites JAC</span>
                            </div>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="generateAso-tab" data-bs-toggle="tab" data-bs-target="#generateAso"
                            type="button" role="tab" aria-controls="homeAso" aria-selected="false">
                            <div class="d-flex align-items-center">
                                <i class="material-icons opacity-10">apartment</i>
                                <span class="ms-2">Tramites Asociación</span>
                            </div>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ session('tab') === 'validate' ? 'active' : '' }}" id="validate-tab" data-bs-toggle="tab" data-bs-target="#validate"
                            type="button" role="tab" aria-controls="profile" aria-selected="{{ session('tab') === 'validate' ? 'true' : 'false' }}">
                            <div class="d-flex align-items-center">
                                <i class="material-icons opacity-10">history_edu</i>
                                <span class="ms-2">Validar Certificados</span>
                            </div>
                        </button>
                    </li>
                </ul>
                <div class="tab-content p-2" id="myTabContent">
                    <div class="tab-pane fade {{ session('tab') === 'validate' ? '' : 'show active' }}" id="generate" role="tabpanel" aria-labelledby="generate-tab">
                        <form method="POST" action="{{ route('certificado.generar') }}">
                            @csrf
                            <div class="container">
                                <div class="mb-3">
                                    <label for="municipio">Municipio</label>
                                    <select name="municipio_id" id="municipio_id" class="form-select form-control select2"
                                        style="width: 100%" onchange="getJuntasPorMunicipio()" required>
                                        <option value="">Seleccione un Municipio</option>
                                        @foreach ($municipios as $m)
                                            <option value="{{ $m->id }}">{{ $m->nombre_municipio }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="juntas">Juntas</label>
                                    <select name="junta_id" id="junta_id" class="form-select form-control select2"
                                        style="width: 100%" required>
                                        <option value="">Seleccione la JAC</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="cargo" class="form-label">Cargo (Dignidad)</label>
                                    <select name="cargo" id="cargo" class="form-select form-control" required>
                                        <option value="">Seleccione un cargo</option>
                                        <option value="PRESIDENTE">PRESIDENTE</option>
                                        <option value="VICEPRESIDENTE">VICEPRESIDENTE</option>
                                        <option value="SECRETARIO">SECRETARIO</option>
                                        <option value="TESORERO">TESORERO</option>
                                        <option value="FISCAL">FISCAL</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="num_documento" class="form-label">Documento del Dignatario</label>
                                    <input type="number" name="num_documento" id="num_documento" class="form-control"
                                        required>
                                </div>
                                <div class="mb-3 col-12">
                                    <button type="submit" class="btn btn-primary">Generar</button>
                                    <button type="button" class="btn btn-secundary"
                                        onclick="descargarArchivosJunta()">Solicitar Documentos</button>
                                </div>
                                <p class="mt-3">
                                    Para generar un certificado debes seleccionar la JAC a la que perteneces, el cargo que ocupas y
                                    posteriormente digitar tu número de documento.
                                    Si los datos son correctos, se descargará automáticamente el documento en PDF con un
                                    código único de confirmación.
                                </p>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="generateAso" role="tabpanel" aria-labelledby="generateAso-tab">
                        <form method="POST" action="{{ route('certificado.generarAso') }}">
                            @csrf
                            <div class="container">
                                <div class="mb-3">
                                    <label for="municipio">Municipio</label>
                                    <select name="municipio_id2" id="municipio_id2"
                                        class="form-select form-control select2" style="width: 100%"
                                        onchange="getAsociacionesPorMunicipio()" required>
                                        <option value="">Seleccione un Municipio</option>
                                        @foreach ($municipios as $m)
                                            <option value="{{ $m->id }}">{{ $m->nombre_municipio }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="asociaciones">Asociaciones</label>
                                    <select name="asociacion_id" id="asociacion_id"
                                        class="form-select form-control select2" style="width: 100%" required>
                                        <option value="">Seleccione la Asociación</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="num_documentoAso">Documento Presidente</label>
                                    <input type="number" name="num_documentoAso" id="num_documentoAso"
                                        class="form-control" required>
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
                    <div class="tab-pane fade {{ session('tab') === 'validate' ? 'show active' : '' }}" id="validate" role="tabpanel" aria-labelledby="validate-tab">
                        <form method="POST" action="{{ route('certificado.validar') }}">
                            @csrf
                            <div class="container">
                                @if (session('certificado_validado'))
                                    @php $certInfo = session('certificado_validado'); @endphp
                                    <div class="alert alert-outline-success d-flex align-items-start mb-4 p-3" role="alert" style="border-radius: 8px; border: 1px solid #28a745; background-color: #f6fdf8;">
                                        <i class="material-icons text-success me-2" style="font-size: 28px;">verified</i>
                                        <div class="flex-grow-1">
                                            <h5 class="text-success mb-2" style="font-weight: bold;">
                                                Certificado Auténtico y Verificado
                                            </h5>
                                            <p class="mb-2 text-dark" style="font-size: 0.95rem; line-height: 1.5;">
                                                El certificado con código <strong class="text-primary">{{ $certInfo['codigo'] }}</strong> fue verificado con éxito y corresponde a un registro verídico emitido por esta Secretaría:
                                            </p>
                                            <div class="table-responsive">
                                                <table class="table table-sm table-borderless mb-0" style="font-size: 0.9rem;">
                                                    <tbody>
                                                        <tr>
                                                            <td class="text-muted pe-2" style="width: 35%;"><i class="material-icons align-middle" style="font-size: 16px;">calendar_today</i> Fecha de generación:</td>
                                                            <td class="fw-bold text-dark">{{ $certInfo['fecha'] }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-muted pe-2"><i class="material-icons align-middle" style="font-size: 16px;">domain</i> {{ $certInfo['tipo'] }}:</td>
                                                            <td class="fw-bold text-dark">{{ $certInfo['nombre'] }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-muted pe-2"><i class="material-icons align-middle" style="font-size: 16px;">place</i> Municipio / Ubicación:</td>
                                                            <td class="fw-bold text-dark">{{ $certInfo['municipio'] }}</td>
                                                        </tr>
                                                        @if(!empty($certInfo['cargo']))
                                                        <tr>
                                                            <td class="text-muted pe-2"><i class="material-icons align-middle" style="font-size: 16px;">badge</i> Cargo expedido:</td>
                                                            <td class="fw-bold text-dark">{{ $certInfo['cargo'] }}</td>
                                                        </tr>
                                                        @endif
                                                        @if(!empty($certInfo['resolucion']))
                                                        <tr>
                                                            <td class="text-muted pe-2"><i class="material-icons align-middle" style="font-size: 16px;">description</i> Personería Jurídica No.:</td>
                                                            <td class="fw-bold text-dark">{{ $certInfo['resolucion'] }}</td>
                                                        </tr>
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <div class="mb-3">
                                    <label for="fecha_certificado" class="form-label">Fecha certificado</label>
                                    <input type="date" name="fecha_certificado" class="form-control" value="{{ old('fecha_certificado') }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="cod_certificado" class="form-label">Codigo certificado</label>
                                    <input type="text" name="cod_certificado" class="form-control" value="{{ old('cod_certificado') }}" required>
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
        function getJuntasPorMunicipio() {
            var municipioId = $('#municipio_id').val();
            if (municipioId) {
                $.ajax({
                    url: '/juntas/por-municipio/' + municipioId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#junta_id').empty();
                        $('#junta_id').append(
                            '<option value="">Seleccione la JAC</option>');
                        $.each(data, function(key, junta) {
                            $('#junta_id').append('<option value="' + junta.id +
                                '">' + junta.nombre + '</option>');
                        });
                    }
                });
            } else {
                $('#junta_id').empty();
                $('#junta_id').append('<option value="">Seleccione la JAC</option>');
            }
        }

        function getAsociacionesPorMunicipio() {
            var municipioId = $('#municipio_id2').val();
            if (municipioId) {
                $.ajax({
                    url: '/asociaciones/por-municipio/' + municipioId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#asociacion_id').empty();
                        $('#asociacion_id').append(
                            '<option value="">Seleccione la Asociación</option>');
                        $.each(data, function(key, aso) {
                            $('#asociacion_id').append('<option value="' + aso.id +
                                '">' + aso.nombre + '</option>');
                        });
                    }
                });
            } else {
                $('#asociacion_id').empty();
                $('#asociacion_id').append('<option value="">Seleccione la JAC</option>');
            }
        }
        // Tus funciones existentes
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
