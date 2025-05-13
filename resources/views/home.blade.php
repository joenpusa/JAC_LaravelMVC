@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 mb-4">
                <h2>Panel de control</h2>
            </div>
            <div class="row mb-4">

            </div>
            <div class="row">
                <div class="col-md-4 col-xs-12">
                    <canvas id="certificadosChart"></canvas>
                </div>
                <div class="col-md-4 col-xs-12">
                    <div class="col-12 mb-4">
                        <div class="card mt-4 h-100">
                            <div class="card-header p-3 pt-2">
                                <div
                                    class="icon icon-lg icon-shape bg-gradient-info shadow-dark text-center border-radius-xl position-absolute">
                                    <i class="material-icons opacity-10">diversity_1</i>
                                </div>
                                <div class="text-end pt-1">
                                    <p class="text-sm mb-0 text-capitalize">Juntas registradas</p>
                                    <h4 class="mb-0">{{ $juntas }}</h4>
                                </div>
                            </div>
                            <hr class="dark horizontal my-0">
                            <div class="card-footer p-3">
                                <p class="mb-0">Cada semana más juntas actualizan la información de su composición</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mb-4">
                        <div class="card mt-4 h-100">
                            <div class="card-header p-3 pt-2">
                                <div
                                    class="icon icon-lg icon-shape bg-gradient-info shadow-dark text-center border-radius-xl position-absolute">
                                    <i class="material-icons opacity-10">badge</i>
                                </div>
                                <div class="text-end pt-1">
                                    <p class="text-sm mb-0 text-capitalize">Dignatarios registrados</p>
                                    <h4 class="mb-0">{{ $funcionarios }}</h4>
                                </div>
                            </div>
                            <hr class="dark horizontal my-0">
                            <div class="card-footer p-3">
                                <p class="mb-0">Con cada elección es necesario registrar los dignatarios que conforman la
                                    junta</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mb-4">
                        <div class="card mt-4 h-100">
                            <div class="card-header p-3 pt-2">
                                <div
                                    class="icon icon-lg icon-shape bg-gradient-info shadow-dark text-center border-radius-xl position-absolute">
                                    <i class="material-icons opacity-10">find_in_page</i>
                                </div>
                                <div class="text-end pt-1">
                                    <p class="text-sm mb-0 text-capitalize">Certificados Generados</p>
                                    <h4 class="mb-0">{{ $certificados }}</h4>
                                </div>
                            </div>
                            <hr class="dark horizontal my-0">
                            <div class="card-footer p-3">
                                <p class="mb-0">Desde la implementación de la plataforma se han generado un gran número de
                                    certificados</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-xs-12">
                    <canvas id="juntasChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const certificadosPorMes = @json($certificadosPorMes);

        const labels = Object.keys(certificadosPorMes).map(mes => {
            const [anio, mesNumero] = mes.split("-");
            const fecha = new Date(anio, mesNumero - 1);
            return fecha.toLocaleString('default', {
                month: 'short',
                year: 'numeric'
            });
        });

        const data = {
            labels: labels,
            datasets: [{
                label: 'Certificados por mes',
                data: Object.values(certificadosPorMes),
                backgroundColor: [
                    '#FFB3BA', '#FFDFBA', '#FFFFBA', '#BAFFC9', '#BAE1FF',
                    '#E3BAFF', '#C2F0FC', '#FCD5CE', '#D0F4DE', '#FFFEC4',
                    '#C1E1C1', '#F6D6AD'
                ]
            }]
        };

        const config = {
            type: 'doughnut',
            data: data,
        };

        new Chart(document.getElementById('certificadosChart'), config);

        const juntasPorMunicipio = @json($juntasPorMunicipio);

        const labelsJuntas = Object.keys(juntasPorMunicipio);
        const dataJuntas = Object.values(juntasPorMunicipio);

        const data2 = {
            labels: labelsJuntas,
            datasets: [{
                label: 'Juntas por municipio',
                data: dataJuntas,
                backgroundColor: [
                    '#FFB3BA', '#FFDFBA', '#FFFFBA', '#BAFFC9', '#BAE1FF',
                    '#E3BAFF', '#C2F0FC', '#FCD5CE', '#D0F4DE', '#FFFEC4',
                    '#C1E1C1', '#F6D6AD'
                ],
                borderColor: '#fff',
                borderWidth: 2
            }]
        };

        const config2 = {
            type: 'doughnut',
            data: data2,
            options: {
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                let value = context.formattedValue || 0;
                                return `${label}: ${value} juntas`;
                            }
                        }
                    }
                }
            }
        };

        new Chart(document.getElementById('juntasChart'), config2);
    </script>
@endpush
