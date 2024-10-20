@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 mb-4">
            <h2>Panel de control</h2>
        </div>
        <div class="row">
            <div class="col-6 mb-4">
                <div class="card">
                    <div class="card-header p-3 pt-2">
                        <div class="icon icon-lg icon-shape bg-gradient-info shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                            <i class="material-icons opacity-10">weekend</i>
                        </div>
                        <div class="text-end pt-1">
                            <p class="text-sm mb-0 text-capitalize">Juntas registradas</p>
                            <h4 class="mb-0">$53k</h4>
                        </div>
                    </div>
                    <hr class="dark horizontal my-0">
                    <div class="card-footer p-3">
                        <p class="mb-0">Cada semana más juntas actualizan la información de su composición</p>
                    </div>
                </div>
                <div class="card mt-4">
                    <div class="card-header p-3 pt-2">
                        <div class="icon icon-lg icon-shape bg-gradient-info shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                            <i class="material-icons opacity-10">weekend</i>
                        </div>
                        <div class="text-end pt-1">
                            <p class="text-sm mb-0 text-capitalize">Dignatarios registrados</p>
                            <h4 class="mb-0">$53k</h4>
                        </div>
                    </div>
                    <hr class="dark horizontal my-0">
                    <div class="card-footer p-3">
                        <p class="mb-0">Con cada elección es necesario registrar los dignatarios que conforman la junta</p>
                    </div>
                </div>
            </div>
            <div class="col-6 mt-4 mb-4">
                <div class="card z-index-2 ">
                  <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                    <div class="bg-gradient-light shadow-dark border-radius-lg py-3 pe-1">
                      <div class="chart">
                        <canvas id="chart-line-tasks" class="chart-canvas" ></canvas>
                      </div>
                    </div>
                  </div>
                  <div class="card-body">
                    <h6 class="mb-0 ">Certificados por municipio</h6>
                    <p class="text-sm ">Cantidad de los certificados que se han generado por cada municipio del departamento.</p>
                    {{-- <hr class="dark horizontal">
                    <div class="d-flex ">
                      <i class="material-icons text-sm my-auto me-1">schedule</i>
                      <p class="mb-0 text-sm">just updated</p>
                    </div> --}}
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12 mt-4 mb-4">
                <div class="card z-index-2  ">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                        <div class="bg-gradient-success shadow-success border-radius-lg py-3 pe-1">
                            <div class="chart">
                                <canvas id="chart-line" class="chart-canvas" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <h6 class="mb-0 "> Certificados generados </h6>
                        <p class="text-sm "> Historico de los certificados generados mes a mes en el último año. </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('assets/js/plugins/chartjs.min.js') }}"></script>
<script>
    var ctx2 = document.getElementById("chart-line").getContext("2d");

    new Chart(ctx2, {
    type: "line",
    data: {
        labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        datasets: [{
        label: "Mobile apps",
        tension: 0,
        borderWidth: 0,
        pointRadius: 5,
        pointBackgroundColor: "rgba(255, 255, 255, .8)",
        pointBorderColor: "transparent",
        borderColor: "rgba(255, 255, 255, .8)",
        borderColor: "rgba(255, 255, 255, .8)",
        borderWidth: 4,
        backgroundColor: "transparent",
        fill: true,
        data: [50, 40, 300, 320, 500, 350, 200, 230, 500],
        maxBarThickness: 6

        }],
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
        legend: {
            display: false,
        }
        },
        interaction: {
        intersect: false,
        mode: 'index',
        },
        scales: {
        y: {
            grid: {
            drawBorder: false,
            display: true,
            drawOnChartArea: true,
            drawTicks: false,
            borderDash: [5, 5],
            color: 'rgba(255, 255, 255, .2)'
            },
            ticks: {
            display: true,
            color: '#f8f9fa',
            padding: 10,
            font: {
                size: 14,
                weight: 300,
                family: "Roboto",
                style: 'normal',
                lineHeight: 2
            },
            }
        },
        x: {
            grid: {
            drawBorder: false,
            display: false,
            drawOnChartArea: false,
            drawTicks: false,
            borderDash: [5, 5]
            },
            ticks: {
            display: true,
            color: '#f8f9fa',
            padding: 10,
            font: {
                size: 14,
                weight: 300,
                family: "Roboto",
                style: 'normal',
                lineHeight: 2
            },
            }
        },
        },
    },
    });

    var ctx3 = document.getElementById("chart-line-tasks").getContext("2d");

    new Chart(ctx3, {
        type: 'pie', // Tipo de gráfico
        data: {
            labels: ['Rojo', 'Azul', 'Amarillo'], // Etiquetas para las secciones del pastel
            datasets: [{
                label: 'Colores favoritos',
                data: [300, 50, 100], // Datos para cada sección del pastel
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)', // Rojo
                    'rgba(54, 162, 235, 0.2)', // Azul
                    'rgba(255, 206, 86, 0.2)'  // Amarillo
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)', // Rojo
                    'rgba(54, 162, 235, 1)', // Azul
                    'rgba(255, 206, 86, 1)'  // Amarillo
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true, // El gráfico se ajusta al tamaño del contenedor
            plugins: {
                legend: {
                    position: 'top', // Posición de la leyenda
                },
                tooltip: {
                    enabled: true // Mostrar tooltip al hacer hover
                }
            }
        }
    });
</script>
@endsection
