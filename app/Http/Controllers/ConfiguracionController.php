<?php

namespace App\Http\Controllers;

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

        $config = Configuracion::firstOrCreate([
            'nombre_app' => $request->nombre_app,
            'nom_entidad' => $request->nom_entidad,
            'direccion' => $request->direccion,
            'horario' => $request->horario,
            'telefono' => $request->telefono,
            'email' => $request->email,
        ]);

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

        return redirect()->back()->with('success', 'Configuración actualizada correctamente');
    }
}
