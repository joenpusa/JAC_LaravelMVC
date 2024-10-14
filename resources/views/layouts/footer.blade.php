<footer class="bg-dark text-light">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-4">
                <img src="{{ asset($appConfig->logo) }}" class="logo-footer">
            </div>
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-12">
                        <h5>{{ $appConfig->nom_entidad }}</h5>
                    </div>
                    <div class="col-md-6">
                        <p>
                            Horarios de atención:<br>
                            Lunes a viernes de<br>
                            {{ $appConfig->horario }}
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p>
                            Línea de Atención:<br>
                            PBX: {{ $appConfig->telefono }}
                        </p>
                        <p>
                            Correo contacto:<br>
                            {{ $appConfig->email }}
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="copyright">
        <h5>Copyright © 2024</h5>
    </div>
</footer>
