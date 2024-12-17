<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Documento;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Junta;
use App\Models\Asociacion;

class DocumentoController extends Controller
{

    public function store(Request $request)
    {
        // Validación
        $request->validate([
            'nomanexo' => 'required|string|max:255',
            'archivo' => 'required|file|mimes:pdf,docx|max:5120',
            'documentable_type' => 'required|string|in:junta,asociacion',
            'documentable_id' => 'required|integer',
        ], [
            'archivo.required' => 'El archivo es requerido.',
            'archivo.max' => 'El archivo debe ser menor a 5MB.',
            'archivo.mimes' => 'El archivo debe ser un archivo PDF o un archivo de Word.',
            'documentable_type.required' => 'El tipo de documento es requerido.',
        ]);

        // Verificar si la relación existe (junta o asociacion)
        if ($request->documentable_type === 'junta') {
            $relatedModel = Junta::findOrFail($request->documentable_id);
            $folder = 'documentos_juntas/';
        } elseif ($request->documentable_type === 'asociacion') {
            $relatedModel = Asociacion::findOrFail($request->documentable_id);
            $folder = 'documentos_asociaciones/';
        }

        // Procesar el archivo
        if ($request->hasFile('archivo')) {
            $archivo = $request->file('archivo');
            $nombreArchivo = time() . '_' . $archivo->getClientOriginalName();
            $rutaCarpeta = $folder . $request->documentable_id;
            $rutaArchivo = $archivo->storeAs($rutaCarpeta, $nombreArchivo, 'public');
        }

        // Crear el documento
        $relatedModel->documentos()->create([
            'nomanexo' => $request->nomanexo,
            'keyanexo' => $rutaArchivo,
            'user_id' => Auth::user()->id,
        ]);

        return redirect()->back()->with('success', 'Documento cargado correctamente');
    }


    public function show($id)
    {
        $documento = Documento::find($id);

        if (!$documento) {
            return redirect()->back()->with('error', 'El documento no existe.');
        }

        if (Storage::disk('public')->exists($documento->keyanexo)) {
            $url = Storage::url($documento->keyanexo);
            return redirect($url);
        } else {
            return redirect()->back()->with('error', 'El archivo no se encuentra en el sistema.');
        }
    }

    public function destroy($id)
    {
        $documento = Documento::find($id);

        if (!$documento) {
            return redirect()->back()->with('error', 'El documento no existe.');
        }

        if (Storage::disk('public')->exists($documento->keyanexo)) {
            $deleted = Storage::disk('public')->delete($documento->keyanexo);
            if (!$deleted) {
                return redirect()->back()->with('error', 'No se pudo eliminar el archivo. Valide permisos de escritura.');
            }
        } else {
            return redirect()->back()->with('error', 'Archivo no encontrado ' . $documento->keyanexo);
        }

        $documento->delete();

        return redirect()->back()->with('success', 'Documento eliminado correctamente');
    }
}
