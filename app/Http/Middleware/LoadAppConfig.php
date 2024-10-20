<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use App\Models\Configuracion;

class LoadAppConfig
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        //$config = Cache::remember('app_config', 60 * 60, function () {
            $config = Configuracion::first();

        //});
        if (!$config) {
            $config = (object) [
                'nombre_app' => 'Nombre App',
                'nom_entidad' => 'Nombre de la entidad por definir',
                'direccion' => 'sin definir',
                'horario' => 'Horario por definir',
                'email' => 'Email sin definir',
                'telefono' => 'telefono sin definir',
                'logo' => 'default-logo.png',
            ];
        }

        View::share('appConfig', $config);

        return $next($request);
    }
}
