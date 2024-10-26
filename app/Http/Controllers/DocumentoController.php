<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Documento;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DocumentoController extends Controller
{


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nomanexo' => 'required|string|max:255|max:5120',
            'archivo' => 'required|file|mimes:pdf,docx',
            'junta_id' => 'required|exists:juntas,id',
        ], [
            'archivo.required' => 'El archivo es requerido.',
            'archivo.max' => 'El archivo debe ser menor a 5MB.',
            'archivo.mimes' => 'El archivo debe ser un archivo PDF o un archivo de Word.',
            'junta_id.exists' => 'La junta no es valida.',
        ]);
        if ($request->hasFile('archivo')) {
            $archivo = $request->file('archivo');
            $nombreArchivo = time() . '_' . $archivo->getClientOriginalName();
            $rutaCarpeta = 'documentos_juntas/' . $request->junta_id;
            $rutaArchivo = $archivo->storeAs($rutaCarpeta, $nombreArchivo, 'public');
        }
        Documento::create([
            'nomanexo' => $request->nomanexo,
            'keyanexo' => $rutaArchivo,
            'junta_id' => $request->junta_id,
            'user_id' => Auth::user()->id
        ]);
        return redirect()->back()->with('success', 'Documento cargado correctamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $documento = Documento::find($id);
        if (!$documento) {
            return redirect()->back()->with('error', 'El documento no existe.');
        }
        if ($documento->keyanexo) {
            if (Storage::disk('public')->exists($documento->keyanexo)) {
                $deleted = Storage::disk('public')->delete($documento->keyanexo);
                if (!$deleted) {
                    return redirect()->back()->with('error', 'No se pudo eliminar el archivo. valide permisos de escritura');
                }
            }else{
                return redirect()->back()->with('error', 'Archivo no encontrado ' . $documento->keyanexo);
            }
        }
        $documento->delete();

        return redirect()->back()->with('success', 'Documento eliminado correctamente');
    }
}
