@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 mb-4">
                <h2>Panel de control</h2>
            </div>
            <div class="row mb-4">
                <div class="col-3 mb-4">
                    <div class="card mt-4 h-100">
                        <div class="card-header p-3 pt-2">
                            <div
                                class="icon icon-lg icon-shape bg-gradient-info shadow-dark text-center border-radius-xl mt-n4 position-absolute">
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
                <div class="col-3 mb-4">
                    <div class="card mt-4 h-100">
                        <div class="card-header p-3 pt-2">
                            <div
                                class="icon icon-lg icon-shape bg-gradient-info shadow-dark text-center border-radius-xl mt-n4 position-absolute">
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
                <div class="col-3 mb-4">
                    <div class="card mt-4 h-100">
                        <div class="card-header p-3 pt-2">
                            <div
                                class="icon icon-lg icon-shape bg-gradient-info shadow-dark text-center border-radius-xl mt-n4 position-absolute">
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
                <div class="col-3 mb-4">
                    <div class="card mt-4 h-100">
                        <div class="card-header p-3 pt-2">
                            <div
                                class="icon icon-lg icon-shape bg-gradient-info shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                                <i class="material-icons opacity-10">location_city</i>
                            </div>
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0 text-capitalize">Comunas Registradas</p>
                                <h4 class="mb-0">{{ $comunas }}</h4>
                            </div>
                        </div>
                        <hr class="dark horizontal my-0">
                        <div class="card-footer p-3">
                            <p class="mb-0">Número de comunas registradas en la plataforma</p>
                        </div>
                    </div>
                </div>

            </div>
            {{-- <div class="col-12 mt-4 mb-4">
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
            </div> --}}
        </div>
    </div>
    </div>
@endsection
