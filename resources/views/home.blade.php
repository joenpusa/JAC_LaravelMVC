@extends('layouts.app')

@section('content')
    <div class="container-fluid px-2 px-md-3">
        <!-- Encabezado de Bienvenida -->
        <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-1 text-xs">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-muted text-decoration-none">Inicio</a></li>
                        <li class="breadcrumb-item active text-primary fw-semibold" aria-current="page">Panel Principal</li>
                    </ol>
                </nav>
                <h1 class="page-title">Panel de Control</h1>
                <p class="page-subtitle mb-0">Visión general y estadísticas operativas de Juntas de Acción Comunal</p>
            </div>
            <div class="d-flex align-items-center gap-2">
                <span class="badge bg-light text-dark border px-3 py-2 fw-medium d-flex align-items-center gap-1 rounded-pill">
                    <i class="material-icons text-primary" style="font-size: 16px;">today</i>
                    {{ \Carbon\Carbon::now()->isoFormat('D [de] MMMM, YYYY') }}
                </span>
                <a href="{{ route('certificados.index') }}" class="btn btn-primary d-inline-flex align-items-center gap-1">
                    <i class="material-icons" style="font-size: 18px;">history_edu</i>
                    <span>Ver Certificados</span>
                </a>
            </div>
        </div>

        @include('layouts.alerts')

        <!-- Tarjetas de Métricas KPI -->
        <div class="row g-3 mb-4">
            <!-- KPI 1: Juntas -->
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card shadow-sm border-0 h-100 mb-0">
                    <div class="card-body p-3 p-md-4">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <span class="text-xs text-uppercase fw-bold text-muted tracking-wider">Juntas Registradas</span>
                            <div class="rounded-3 p-2 bg-primary-subtle text-primary d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                                <i class="material-icons" style="font-size: 22px;">diversity_1</i>
                            </div>
                        </div>
                        <div class="d-flex align-items-baseline gap-2 mb-2">
                            <h2 class="fw-bold mb-0 text-dark">{{ number_format($juntas) }}</h2>
                            <span class="text-xs text-success fw-semibold d-flex align-items-center">
                                <i class="material-icons" style="font-size: 14px;">arrow_upward</i> Activas
                            </span>
                        </div>
                        <p class="text-muted text-xs mb-0">Organizaciones comunales registradas en el departamento</p>
                    </div>
                </div>
            </div>

            <!-- KPI 2: Dignatarios -->
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card shadow-sm border-0 h-100 mb-0">
                    <div class="card-body p-3 p-md-4">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <span class="text-xs text-uppercase fw-bold text-muted tracking-wider">Dignatarios</span>
                            <div class="rounded-3 p-2 text-success d-flex align-items-center justify-content-center" style="width: 42px; height: 42px; background-color: #ecfdf5;">
                                <i class="material-icons" style="font-size: 22px;">badge</i>
                            </div>
                        </div>
                        <div class="d-flex align-items-baseline gap-2 mb-2">
                            <h2 class="fw-bold mb-0 text-dark">{{ number_format($funcionarios) }}</h2>
                            <span class="text-xs text-muted fw-semibold">Líderes</span>
                        </div>
                        <p class="text-muted text-xs mb-0">Miembros directivos y comisionados acreditados</p>
                    </div>
                </div>
            </div>

            <!-- KPI 3: Certificados -->
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card shadow-sm border-0 h-100 mb-0">
                    <div class="card-body p-3 p-md-4">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <span class="text-xs text-uppercase fw-bold text-muted tracking-wider">Certificados</span>
                            <div class="rounded-3 p-2 text-warning d-flex align-items-center justify-content-center" style="width: 42px; height: 42px; background-color: #fffbeb;">
                                <i class="material-icons" style="font-size: 22px;">find_in_page</i>
                            </div>
                        </div>
                        <div class="d-flex align-items-baseline gap-2 mb-2">
                            <h2 class="fw-bold mb-0 text-dark">{{ number_format($certificados) }}</h2>
                            <span class="text-xs text-primary fw-semibold">Emitidos</span>
                        </div>
                        <p class="text-muted text-xs mb-0">Constancias y certificados oficiales expedidos</p>
                    </div>
                </div>
            </div>

            <!-- KPI 4: Comunas y Sectores -->
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card shadow-sm border-0 h-100 mb-0">
                    <div class="card-body p-3 p-md-4">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <span class="text-xs text-uppercase fw-bold text-muted tracking-wider">Comunas y Sectores</span>
                            <div class="rounded-3 p-2 text-info d-flex align-items-center justify-content-center" style="width: 42px; height: 42px; background-color: #eff6ff;">
                                <i class="material-icons" style="font-size: 22px;">location_city</i>
                            </div>
                        </div>
                        <div class="d-flex align-items-baseline gap-2 mb-2">
                            <h2 class="fw-bold mb-0 text-dark">{{ number_format($comunas ?? 0) }}</h2>
                            <span class="text-xs text-muted fw-semibold">Zonas</span>
                        </div>
                        <p class="text-muted text-xs mb-0">Divisiones territoriales y corregimientos vinculados</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Fila de Gráficos Estadísticos -->
        <div class="row g-4">
            <!-- Gráfico 1: Certificados por mes -->
            <div class="col-12 col-lg-6">
                <div class="card shadow-sm border-0 h-100 mb-0">
                    <div class="card-header bg-transparent py-3 d-flex align-items-center justify-content-between">
                        <h5 class="mb-0 fw-bold d-flex align-items-center gap-2">
                            <i class="material-icons text-primary" style="font-size: 20px;">analytics</i>
                            Certificados por Mes
                        </h5>
                        <span class="badge bg-light text-muted border text-xs">Últimos meses</span>
                    </div>
                    <div class="card-body p-3 p-md-4 d-flex flex-column align-items-center justify-content-center" style="min-height: 340px;">
                        <div style="position: relative; width: 100%; max-width: 320px; margin: 0 auto;">
                            <canvas id="certificadosChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Gráfico 2: Juntas por municipio -->
            <div class="col-12 col-lg-6">
                <div class="card shadow-sm border-0 h-100 mb-0">
                    <div class="card-header bg-transparent py-3 d-flex align-items-center justify-content-between">
                        <h5 class="mb-0 fw-bold d-flex align-items-center gap-2">
                            <i class="material-icons text-success" style="font-size: 20px;">pie_chart</i>
                            Distribución de Juntas por Municipio
                        </h5>
                        <span class="badge bg-light text-muted border text-xs">Por territorio</span>
                    </div>
                    <div class="card-body p-3 p-md-4 d-flex flex-column align-items-center justify-content-center" style="min-height: 340px;">
                        <div style="position: relative; width: 100%; max-width: 360px; margin: 0 auto;">
                            <canvas id="juntasChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const modernPalette = [
            '#2563eb', '#3b82f6', '#60a5fa', '#10b981', '#34d399',
            '#f59e0b', '#fbbf24', '#8b5cf6', '#a78bfa', '#ec4899',
            '#06b6d4', '#64748b'
        ];

        // Certificados por Mes
        const certificadosPorMes = @json($certificadosPorMes);
        const labels = Object.keys(certificadosPorMes).map(mes => {
            const [anio, mesNumero] = mes.split("-");
            const fecha = new Date(anio, mesNumero - 1);
            return fecha.toLocaleString('es-ES', {
                month: 'short',
                year: 'numeric'
            });
        });

        const dataCertificados = {
            labels: labels,
            datasets: [{
                label: 'Certificados emitidos',
                data: Object.values(certificadosPorMes),
                backgroundColor: modernPalette,
                borderWidth: 2,
                borderColor: '#ffffff',
                hoverOffset: 6
            }]
        };

        new Chart(document.getElementById('certificadosChart'), {
            type: 'doughnut',
            data: dataCertificados,
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            boxWidth: 12,
                            padding: 12,
                            font: { family: "'Plus Jakarta Sans', sans-serif", size: 11 }
                        }
                    }
                },
                cutout: '65%'
            }
        });

        // Juntas por Municipio
        const juntasPorMunicipio = @json($juntasPorMunicipio);
        const labelsJuntas = Object.keys(juntasPorMunicipio);
        const dataJuntasValues = Object.values(juntasPorMunicipio);

        const dataJuntas = {
            labels: labelsJuntas,
            datasets: [{
                label: 'Juntas',
                data: dataJuntasValues,
                backgroundColor: modernPalette,
                borderWidth: 2,
                borderColor: '#ffffff',
                hoverOffset: 6
            }]
        };

        new Chart(document.getElementById('juntasChart'), {
            type: 'doughnut',
            data: dataJuntas,
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            boxWidth: 12,
                            padding: 12,
                            font: { family: "'Plus Jakarta Sans', sans-serif", size: 11 }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                let value = context.formattedValue || 0;
                                return ` ${label}: ${value} juntas`;
                            }
                        }
                    }
                },
                cutout: '65%'
            }
        });
    </script>
@endpush
