@extends('layouts.app_out')

@section('content')
    <div class="container my-auto py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-10 col-md-8 col-lg-5 col-xl-4">
                <div class="card shadow-lg border-0" style="border-radius: 20px;">
                    <div class="card-body p-4 p-md-5">
                        <div class="text-center mb-4">
                            @if(isset($appConfig) && $appConfig->logo)
                                <img src="{{ asset($appConfig->logo) }}" alt="{{ $appConfig->nombre_app ?? 'JUNTAS NDS' }}" height="56" class="mb-3" style="object-fit: contain;" />
                            @else
                                <div class="d-inline-flex align-items-center justify-content-center bg-primary text-white rounded-4 p-3 mb-3 shadow-sm" style="width: 58px; height: 58px;">
                                    <i class="material-icons" style="font-size: 30px;">account_balance</i>
                                </div>
                            @endif
                            <h3 class="fw-bold text-dark mb-1">Iniciar Sesión</h3>
                            <p class="text-muted text-xs mb-0">Sistema de Gestión de Juntas de Acción Comunal</p>
                        </div>

                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label text-xs fw-bold text-uppercase text-muted">Correo Electrónico</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="material-icons text-muted" style="font-size: 18px;">email</i>
                                    </span>
                                    <input id="email" type="email"
                                        class="form-control border-start-0 ps-0 @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="nombre@correo.com">
                                </div>
                                @error('email')
                                    <span class="text-danger text-xs mt-1 d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label text-xs fw-bold text-uppercase text-muted">Contraseña</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="material-icons text-muted" style="font-size: 18px;">lock</i>
                                    </span>
                                    <input id="password" type="password"
                                        class="form-control border-start-0 ps-0 @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="current-password" placeholder="••••••••">
                                </div>
                                @error('password')
                                    <span class="text-danger text-xs mt-1 d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <div class="form-check mb-0">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                        {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label text-xs text-muted" for="remember">
                                        Recordar sesión
                                    </label>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-2 d-flex align-items-center justify-content-center gap-2 fw-semibold">
                                <i class="material-icons" style="font-size: 18px;">login</i>
                                <span>Ingresar al Sistema</span>
                            </button>
                        </form>
                    </div>
                </div>

                <div class="text-center mt-3 text-muted text-xs">
                    <span>Acceso exclusivo para personal autorizado</span>
                </div>
            </div>
        </div>
    </div>
@endsection
