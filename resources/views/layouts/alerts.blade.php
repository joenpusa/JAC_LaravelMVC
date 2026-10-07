@if ($errors->any() || ($errorMessage = Session::get('error')))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <div class="d-flex align-items-start">
            <span class="alert-icon-wrap me-2 pt-1 text-danger">
                <i class="material-icons" style="font-size: 22px;">error_outline</i>
            </span>
            <div class="alert-message flex-grow-1">
                @if ($errors->any())
                    <strong class="d-block mb-1 text-danger">Por favor revise los siguientes campos:</strong>
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @else
                    <span>{{ $errorMessage }}</span>
                @endif
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
    </div>
@endif

@if ($successMessage = Session::get('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <div class="d-flex align-items-center">
            <span class="alert-icon-wrap me-2 text-success">
                <i class="material-icons" style="font-size: 22px;">check_circle</i>
            </span>
            <div class="alert-message flex-grow-1">
                <span>{{ $successMessage }}</span>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
    </div>
@endif

@if ($infoMessage = Session::get('info'))
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        <div class="d-flex align-items-center">
            <span class="alert-icon-wrap me-2 text-primary">
                <i class="material-icons" style="font-size: 22px;">info</i>
            </span>
            <div class="alert-message flex-grow-1">
                <span>{{ $infoMessage }}</span>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
    </div>
@endif
