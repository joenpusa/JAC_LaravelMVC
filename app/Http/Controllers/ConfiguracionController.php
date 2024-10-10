<?php

namespace App\Http\Controllers;

use App\Models\Configuracion;
use Illuminate\Http\Request;

class ConfiguracionController extends Controller
{
    public function index()
    {
        $config = Configuracion::first(); // Obtener la primera configuración
        return view('configuracion.index', compact('config'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_app' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'horario' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'telefono' => 'required|string|max:20',
            'email' => 'required|email|max:255',
        ]);

        $config = Configuracion::firstOrCreate([]);
        $config->nombre_app = $request->nombre_app;
        $config->direccion = $request->direccion;
        $config->horario = $request->horario;
        $config->telefono = $request->telefono;
        $config->email = $request->email;

        // Manejar la subida de logo
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
            $config->logo = $logoPath;
        }

        $config->save();

        return redirect()->back()->with('success', 'Configuración actualizada correctamente');
    }
}
