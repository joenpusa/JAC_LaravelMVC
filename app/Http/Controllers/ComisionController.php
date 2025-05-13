<?php

namespace App\Http\Controllers;

use App\Models\Comision;
use Illuminate\Http\Request;

class ComisionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nomcomision' => 'required|string|max:255',
            'nomcomisionado' => 'required|string|max:255',
            'doccomisionado' => 'required|string|max:30',
            'owner_type' => 'required|string',
            'owner_id' => 'required|integer',
        ]);

        // Normalizar owner_type a modelo completo
        $ownerType = $request->owner_type === 'junta' ? 'App\Models\Junta' : 'App\Models\Asociacion';

        Comision::create([
            'nomcomision' => $request->nomcomision,
            'nomcomisionado' => $request->nomcomisionado,
            'doccomisionado' => $request->doccomisionado,
            'owner_type' => $ownerType,
            'owner_id' => $request->owner_id,
        ]);

        return back()->with('success', 'Comisionado creado correctamente.');
    }

    public function destroy($id)
    {
        $comision = Comision::findOrFail($id);
        $comision->delete();

        return back()->with('success', 'Comisión eliminada correctamente.');
    }

}
