@extends('layouts.app')

@section('content')
    <div class="container-fluid px-2 px-md-3">
        <!-- Encabezado de página -->
        <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-1 text-xs">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-muted text-decoration-none">Inicio</a></li>
                        <li class="breadcrumb-item active text-primary fw-semibold" aria-current="page">Configuración</li>
                    </ol>
                </nav>
                <h1 class="page-title">Configuración del Sistema</h1>
                <p class="page-subtitle mb-0">Gestione los parámetros generales de la entidad, despacho y firma oficial para certificados.</p>
            </div>
        </div>

        @include('layouts.alerts')

        <form action="{{ route('configuracion.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Tarjeta 1: Información General -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-transparent py-3">
                    <h5 class="mb-0 fw-bold d-flex align-items-center gap-2">
                        <i class="material-icons text-primary" style="font-size: 22px;">domain</i>
                        Información de la Entidad y Aplicación
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <label for="nombre_app">Nombre de la Aplicación <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nombre_app" name="nombre_app"
                                value="{{ old('nombre_app', $config->nombre_app ?? '') }}" placeholder="Ej. JUNTAS NDS" required>
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="nom_entidad">Nombre de la Entidad <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nom_entidad" name="nom_entidad"
                                value="{{ old('nom_entidad', $config->nom_entidad ?? '') }}" placeholder="Ej. Gobernación de Norte de Santander" required>
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="direccion">Dirección <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="direccion" name="direccion"
                                value="{{ old('direccion', $config->direccion ?? '') }}" placeholder="Ej. Calle 10 # 5-20" required>
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="horario">Horario de Funcionamiento <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="horario" name="horario"
                                value="{{ old('horario', $config->horario ?? '') }}" placeholder="Ej. Lunes a Viernes 8:00 AM - 5:00 PM" required>
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="telefono">Teléfono de Contacto <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="telefono" name="telefono"
                                value="{{ old('telefono', $config->telefono ?? '') }}" placeholder="Ej. (607) 583 0000" required>
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="email">Email Institucional <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" name="email"
                                value="{{ old('email', $config->email ?? '') }}" placeholder="Ej. contacto@gobernacion.gov.co" required>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tarjeta 2: Despacho y Autoridad -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-transparent py-3">
                    <h5 class="mb-0 fw-bold d-flex align-items-center gap-2">
                        <i class="material-icons text-primary" style="font-size: 22px;">badge</i>
                        Despacho y Representante Oficial
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <label for="secretaria">Nombre del Despacho / Secretaría <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="secretaria" name="secretaria"
                                value="{{ old('secretaria', $config->secretaria ?? '') }}" placeholder="Ej. Secretaría de Desarrollo Social" required>
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="nombre_secretario">Nombre del Secretario(a) <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nombre_secretario" name="nombre_secretario"
                                value="{{ old('nombre_secretario', $config->nombre_secretario ?? '') }}" placeholder="Ej. Dr. Juan Pérez" required>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tarjeta 3: Identidad Visual y Firma -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-transparent py-3">
                    <h5 class="mb-0 fw-bold d-flex align-items-center gap-2">
                        <i class="material-icons text-primary" style="font-size: 22px;">draw</i>
                        Identidad Visual y Firma Digital para Documentos
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-12 col-md-6">
                            <label for="logo" class="d-block">Logo de la Entidad</label>
                            <div class="input-group">
                                <input type="file" class="form-control" id="logo" name="logo" accept="image/*">
                            </div>
                            <small class="text-muted d-block mt-1">Formato PNG o JPG recomendado (fondo transparente).</small>
                            @if ($config && $config->logo)
                                <div class="mt-3 p-3 bg-light rounded-3 border d-inline-block text-center">
                                    <span class="d-block text-xs text-muted fw-bold mb-1">Logo Actual:</span>
                                    <img src="{{ asset('storage/' . $config->logo) }}" alt="Logo" class="img-fluid rounded" style="max-height: 80px; object-fit: contain;">
                                </div>
                            @endif
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="firma" class="d-block">Firma Oficial para Certificados y Autos</label>
                            <div class="input-group">
                                <input type="file" class="form-control" id="firma" name="firma" accept="image/*">
                            </div>
                            <small class="text-muted d-block mt-1">Imagen de la firma escaneada (PNG con fondo transparente recomendado).</small>
                            @if ($config && $config->keyfirma)
                                <div class="mt-3 p-3 bg-light rounded-3 border d-inline-block text-center">
                                    <span class="d-block text-xs text-muted fw-bold mb-1">Firma Actual:</span>
                                    <img src="{{ asset('storage/' . $config->keyfirma) }}" alt="Firma Oficial" class="img-fluid rounded" style="max-height: 80px; object-fit: contain;">
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end mb-4">
                <button type="submit" class="btn btn-primary px-4 py-2 shadow-sm">
                    <i class="material-icons" style="font-size: 20px;">save</i>
                    Guardar Configuración
                </button>
            </div>
        </form>
    </div>
@endsection
