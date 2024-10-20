<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use App\Models\Configuracion;
use Illuminate\Http\Request;

class ConfiguracionController extends Controller
{
    public function index()
    {
        $config = Configuracion::first();
        return view('configuracion.index', compact('config'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_app' => 'required|string|max:30',
            'nom_entidad' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'horario' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'telefono' => 'required|string|max:40',
            'email' => 'required|email|max:255',
        ]);
        $config = Configuracion::first();
        if (!$config) {
            $config = new Configuracion;
        }
        $config->nombre_app = $request->nombre_app;
        $config->nom_entidad = $request->nom_entidad;
        $config->direccion = $request->direccion;
        $config->horario = $request->horario;
        $config->telefono = $request->telefono;
        $config->email = $request->email;

        if ($request->hasFile('logo')) {
            if ($config->logo && file_exists(public_path('images/' . $config->logo))) {
                unlink(public_path('images/' . $config->logo));
            }

            $logoFile = $request->file('logo');
            $logoName = time() . '_' . $logoFile->getClientOriginalName();
            $logoFile->move(public_path('images'), $logoName);

            $config->logo = 'images/' . $logoName;
        }

        $config->save();
        Cache::forget('app_config');

        return redirect()->back()->with('success', 'Configuración actualizada correctamente');
    }
}
