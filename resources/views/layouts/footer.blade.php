<footer class="mt-auto border-top bg-white" style="border-top: 1px solid #e2e8f0 !important;">
    <div class="container py-4">
        <div class="row align-items-center g-4 text-center text-md-start">
            <div class="col-12 col-md-4 text-center">
                @if(isset($appConfig) && $appConfig->logo)
                    <img src="{{ asset($appConfig->logo) }}" alt="{{ $appConfig->nom_entidad ?? 'Logo Entidad' }}" class="img-fluid" style="max-height: 80px; object-fit: contain;">
                @else
                    <div class="d-inline-flex align-items-center justify-content-center bg-primary-subtle text-primary rounded-4 p-3 mb-2" style="width: 64px; height: 64px;">
                        <i class="material-icons" style="font-size: 32px;">account_balance</i>
                    </div>
                    <div class="fw-bold text-dark fs-6">{{ $appConfig->nom_entidad ?? 'Juntas de Acción Comunal' }}</div>
                @endif
            </div>
            <div class="col-12 col-md-8">
                <h5 class="fw-bold text-dark mb-3">{{ $appConfig->nom_entidad ?? 'Gobernación / Entidad Departamental' }}</h5>
                <div class="row g-3 text-xs text-muted">
                    <div class="col-12 col-sm-6 d-flex align-items-start gap-2">
                        <i class="material-icons text-primary" style="font-size: 18px;">schedule</i>
                        <div>
                            <strong class="d-block text-dark">Horario de atención:</strong>
                            <span>{{ $appConfig->horario ?? 'Lunes a Viernes 8:00 AM - 5:00 PM' }}</span>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 d-flex align-items-start gap-2">
                        <i class="material-icons text-primary" style="font-size: 18px;">location_on</i>
                        <div>
                            <strong class="d-block text-dark">Dirección:</strong>
                            <span>{{ $appConfig->direccion ?? 'Sede Principal' }}</span>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 d-flex align-items-start gap-2">
                        <i class="material-icons text-primary" style="font-size: 18px;">phone</i>
                        <div>
                            <strong class="d-block text-dark">Línea de Atención:</strong>
                            <span>PBX: {{ $appConfig->telefono ?? 'N/A' }}</span>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 d-flex align-items-start gap-2">
                        <i class="material-icons text-primary" style="font-size: 18px;">email</i>
                        <div>
                            <strong class="d-block text-dark">Correo de contacto:</strong>
                            <span>{{ $appConfig->email ?? 'contacto@entidad.gov.co' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="py-3 text-center text-xs text-muted border-top bg-light">
        <span>© {{ date('Y') }} {{ $appConfig->nombre_app ?? 'JUNTAS NDS' }} — Todos los derechos reservados.</span>
    </div>
</footer>
