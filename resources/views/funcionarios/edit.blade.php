@extends('layouts.app')

@section('content')
    <div class="container-fluid px-2 px-md-3">
        <!-- Encabezado de página -->
        <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-1 text-xs">
                        <li class="breadcrumb-item"><a href="{{ route('funcionarios.index') }}" class="text-muted text-decoration-none">Dignatarios</a></li>
                        <li class="breadcrumb-item active text-primary fw-semibold" aria-current="page">{{ isset($funcionario) ? 'Editar' : 'Crear' }}</li>
                    </ol>
                </nav>
                <h1 class="page-title">{{ isset($funcionario) ? 'Editar Dignatario' : 'Crear Dignatario' }}</h1>
                <p class="page-subtitle mb-0">Gestione la información personal, documentos y datos de contacto del líder comunal.</p>
            </div>
            <div>
                <a href="{{ route('funcionarios.index') }}" class="btn btn-outline-secondary d-inline-flex align-items-center gap-1">
                    <i class="material-icons" style="font-size: 18px;">arrow_back</i>
                    <span>Volver al listado</span>
                </a>
            </div>
        </div>

        @include('layouts.alerts')

        <form action="{{ isset($funcionario) ? route('funcionarios.update', $funcionario->id) : route('funcionarios.store') }}" method="POST">
            @csrf
            @if (isset($funcionario))
                @method('PUT')
            @endif

            <!-- Tarjeta 1: Información Personal y Documento -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-transparent py-3">
                    <h5 class="mb-0 fw-bold d-flex align-items-center gap-2">
                        <i class="material-icons text-primary" style="font-size: 22px;">person</i>
                        Información Personal e Identificación
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <label for="nombre">Nombre completo <span class="text-danger">*</span></label>
                            <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $funcionario->nombre ?? '') }}"
                                class="form-control" required placeholder="Nombres y apellidos completos">
                        </div>

                        <div class="col-12 col-md-3">
                            <label for="tipo_documento">Tipo de Documento <span class="text-danger">*</span></label>
                            <select name="tipo_documento" id="tipo_documento" class="form-select" required>
                                <option value="">Seleccione tipo...</option>
                                <option value="Cedula de Ciudadania" {{ old('tipo_documento', $funcionario->tipo_documento ?? '') == 'Cedula de Ciudadania' ? 'selected' : '' }}>Cédula de Ciudadanía</option>
                                <option value="PPT" {{ old('tipo_documento', $funcionario->tipo_documento ?? '') == 'PPT' ? 'selected' : '' }}>PPT</option>
                                <option value="Cedula de Extrangeria" {{ old('tipo_documento', $funcionario->tipo_documento ?? '') == 'Cedula de Extrangeria' ? 'selected' : '' }}>Cédula de Extranjería</option>
                                <option value="Tarjeta de Identidad" {{ old('tipo_documento', $funcionario->tipo_documento ?? '') == 'Tarjeta de Identidad' ? 'selected' : '' }}>Tarjeta de Identidad</option>
                            </select>
                        </div>

                        <div class="col-12 col-md-3">
                            <label for="num_documento">Número de Documento <span class="text-danger">*</span></label>
                            <input type="number" name="num_documento" id="num_documento"
                                value="{{ old('num_documento', $funcionario->num_documento ?? '') }}" class="form-control" required placeholder="Número de documento">
                        </div>

                        <div class="col-12 col-md-3">
                            <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                            <input type="date" name="fecha_nacimiento" id="fecha_nacimiento"
                                value="{{ old('fecha_nacimiento', $funcionario->fecha_nacimiento ?? '') }}" class="form-control">
                        </div>

                        <div class="col-12 col-md-3">
                            <label for="genero">Género</label>
                            <select name="genero" id="genero" class="form-select">
                                <option value="">Seleccione género...</option>
                                <option value="Hombre" {{ old('genero', $funcionario->genero ?? '') == 'Hombre' ? 'selected' : '' }}>Hombre</option>
                                <option value="Mujer" {{ old('genero', $funcionario->genero ?? '') == 'Mujer' ? 'selected' : '' }}>Mujer</option>
                            </select>
                        </div>

                        <div class="col-12 col-md-3">
                            <label for="discapacidad">¿Presenta Discapacidad?</label>
                            <select name="discapacidad" id="discapacidad" class="form-select">
                                <option value="0" {{ old('discapacidad', $funcionario->discapacidad ?? '') == '0' ? 'selected' : '' }}>No</option>
                                <option value="1" {{ old('discapacidad', $funcionario->discapacidad ?? '') == '1' ? 'selected' : '' }}>Sí</option>
                            </select>
                        </div>

                        <div class="col-12 col-md-3">
                            <label for="grupo_etnico">Grupo Étnico</label>
                            <select name="grupo_etnico" id="grupo_etnico" class="form-select">
                                <option value="Ninguno" {{ old('grupo_etnico', $funcionario->grupo_etnico ?? '') == 'Ninguno' ? 'selected' : '' }}>Ninguno</option>
                                <option value="Negro" {{ old('grupo_etnico', $funcionario->grupo_etnico ?? '') == 'Negro' ? 'selected' : '' }}>Negro</option>
                                <option value="Palenquero" {{ old('grupo_etnico', $funcionario->grupo_etnico ?? '') == 'Palenquero' ? 'selected' : '' }}>Palenquero</option>
                                <option value="Gitano" {{ old('grupo_etnico', $funcionario->grupo_etnico ?? '') == 'Gitano' ? 'selected' : '' }}>Gitano</option>
                                <option value="Indigena" {{ old('grupo_etnico', $funcionario->grupo_etnico ?? '') == 'Indigena' ? 'selected' : '' }}>Indígena</option>
                                <option value="Rom" {{ old('grupo_etnico', $funcionario->grupo_etnico ?? '') == 'Rom' ? 'selected' : '' }}>Rom</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tarjeta 2: Contacto y Afiliación -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-transparent py-3">
                    <h5 class="mb-0 fw-bold d-flex align-items-center gap-2">
                        <i class="material-icons text-primary" style="font-size: 22px;">contact_mail</i>
                        Contacto y Afiliación Comunal
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12 col-md-4">
                            <label for="email">Correo Electrónico <span class="text-danger">*</span></label>
                            <input type="email" name="email" id="email" value="{{ old('email', $funcionario->email ?? '') }}"
                                class="form-control" required placeholder="ejemplo@correo.com">
                        </div>

                        <div class="col-12 col-md-4">
                            <label for="telefono">Teléfono / Celular</label>
                            <input type="text" name="telefono" id="telefono" value="{{ old('telefono', $funcionario->telefono ?? '') }}"
                                class="form-control" placeholder="Número celular">
                        </div>

                        <div class="col-12 col-md-4">
                            <label for="profesion">Profesión u Ocupación</label>
                            <input type="text" name="profesion" id="profesion" value="{{ old('profesion', $funcionario->profesion ?? '') }}"
                                class="form-control" placeholder="Profesión u ocupación">
                        </div>

                        <div class="col-12 col-md-4">
                            <label for="num_afiliacion">Número de Afiliación</label>
                            <input type="number" name="num_afiliacion" id="num_afiliacion"
                                value="{{ old('num_afiliacion', $funcionario->num_afiliacion ?? '') }}" class="form-control" placeholder="Número de libro/afiliación">
                        </div>

                        <div class="col-12 col-md-8">
                            <label for="direccion">Dirección de Residencia</label>
                            <input type="text" name="direccion" id="direccion" value="{{ old('direccion', $funcionario->direccion ?? '') }}"
                                class="form-control" placeholder="Dirección de residencia">
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-light py-3 d-flex justify-content-end gap-2">
                    <a href="{{ route('funcionarios.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary d-inline-flex align-items-center gap-1">
                        <i class="material-icons" style="font-size: 18px;">save</i>
                        <span>{{ isset($funcionario) ? 'Guardar Cambios' : 'Crear Dignatario' }}</span>
                    </button>
                </div>
            </div>
        </form>

        @if(isset($funcionario))
            <!-- Tarjeta 3: Soporte Documental del Dignatario -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-transparent py-3">
                    <h5 class="mb-0 fw-bold d-flex align-items-center gap-2">
                        <i class="material-icons text-primary" style="font-size: 22px;">attach_file</i>
                        Soporte Documental del Dignatario
                    </h5>
                </div>
                <div class="card-body">
                    <div class="p-3 bg-light rounded-3 border">
                        <form id="uploadForm" action="{{ route('funcionario.upload') }}" method="POST"
                            enctype="multipart/form-data" class="row g-3 align-items-center">
                            @csrf
                            @method('PUT')
                            <input type="hidden" value="{{ $funcionario->id }}" name="funcionario_id">

                            <div class="col-12 col-md-6">
                                <label for="document" class="form-label text-xs fw-bold text-muted text-uppercase mb-1">Archivo de Soporte (PDF o ZIP)</label>
                                <input type="file" id="document" name="document" class="form-control" accept=".pdf,.zip" required>
                            </div>
                            <div class="col-12 col-md-6 d-flex align-items-end gap-2">
                                <button type="submit" class="btn btn-primary d-inline-flex align-items-center gap-1">
                                    <i class="material-icons" style="font-size: 18px;">cloud_upload</i>
                                    <span>Cargar Archivo</span>
                                </button>
                                @if (isset($funcionario->key_anexo))
                                    <a href="{{ asset('storage/documents/funcionarios/' . $funcionario->key_anexo) }}"
                                        target="_blank" class="btn btn-outline-primary d-inline-flex align-items-center gap-1">
                                        <i class="material-icons" style="font-size: 18px;">visibility</i>
                                        <span>Ver Documento Actual</span>
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
