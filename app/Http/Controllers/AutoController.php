<?php

namespace App\Http\Controllers;

use App\Models\Auto;
use Illuminate\Http\Request;
use PDF;
use Illuminate\Support\Facades\File;


class AutoController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'numero' => 'required|string|max:5',
            'owner_type' => 'required|string',
            'owner_id' => 'required|integer',
            'usuario_id' => 'required|exists:users,id',
        ]);

        // Crear el registro en la base de datos sin el archivo aún
        $auto = new Auto();
        $auto->fecha = now();
        $auto->numero = $request->numero;
        $auto->owner_type = $request->owner_type;
        $auto->owner_id = $request->owner_id;
        $auto->usuario_id = $request->usuario_id;
        $auto->save();
        // Generar el PDF usando la vista certificados.auto
        $pdf = PDF::loadView('certificados.auto', compact('auto'));

        // Definir nombre único y ruta del archivo
        $filename = 'AUTO_'.$auto->id.'_'.now()->format('YmdHis').'.pdf';
        $directory = public_path('autosGenerates');

        // Verificar si existe la carpeta, si no, crearla
        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true); // permisos, recursivo
        }

        $path = $directory.'/'.$filename;

        // Guardar el archivo
        $pdf->save($path);

        // Actualizar registro con la ruta del archivo
        $auto->keyarchivo = 'autosGenerates/'.$filename;
        $auto->save();

        return back()->with('success', 'AUTO generado exitosamente.');
    }

    public function destroy(Auto $auto)
    {
        $auto->delete();
        return back()->with('success', 'AUTO eliminado.');
    }
}
