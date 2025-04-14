<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carpeta;

class CarpetaController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'libro' => 'required|string',
            'causal' => 'required|string',
            'fecha' => 'required|date',
            'folios' => 'required|integer',
            'owner_type' => 'required|string',
            'owner_id' => 'required|integer',
            'usuario_id' => 'required|exists:users,id',
        ]);

        Carpeta::create($request->all());

        return back()->with('success', 'Carpeta registrada exitosamente.');
    }

}
