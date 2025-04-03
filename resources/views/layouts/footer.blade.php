<footer class="" style="background-color: #ffffff; padding-top: 20px; border-top: #36c solid 2px;">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-4">
                <img src="{{ asset($appConfig->logo) }}" class="logo-footer">
            </div>
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-12 p-2">
                        <h4>{{ $appConfig->nom_entidad }}</h4>
                    </div>
                    <div class="col-md-6">
                        <i class="material-icons opacity-10">schedule</i>
                        <p>
                            Horario de atención:<br>
                            {{ $appConfig->horario }}
                        </p>
                        <i class="material-icons opacity-10">location_on</i>
                        <p>
                            Dirección:<br>
                            {{ $appConfig->horario }}
                        </p>
                    </div>
                    <div class="col-md-6">
                        <i class="material-icons opacity-10">phone</i>
                        <p>
                            Línea de Atención:<br>
                            PBX: {{ $appConfig->telefono }}
                        </p>
                        <i class="material-icons opacity-10">email</i>
                        <p>
                            Correo contacto:<br>
                            {{ $appConfig->email }}
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="copyright text-light" style="background-color: #36c; padding: 20px; text-align: center;">
        <h5>Copyright © {{ date('Y') }}</h5>
    </div>
</footer>
