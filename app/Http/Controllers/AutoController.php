<?php

namespace App\Http\Controllers;

use App\Models\Auto;
use App\Models\Junta;
use App\Models\Asociacion;
use App\Models\Configuracion;
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
            'tipo' => 'nullable|string|max:20',
            'usuario_id' => 'required|exists:users,id',
        ]);

        try {
            // datos de owner
            if ($request->owner_type == 'App\Models\Junta') {
                $owner = Junta::find($request->owner_id);
                $view = 'certificados.auto_jac';
            } else {
                $owner = Asociacion::find($request->owner_id);
                $view = 'certificados.auto_aso';
            }

            if (strtolower($request->tipo) === 'resolución' || strtolower($request->tipo) === 'resolucion') {
                $view = 'certificados.resolucion';
            }

            if (!$owner) {
                return back()->withErrors(['custom' => 'No se encontró la entidad correspondiente.']);
            }

            // Crear el registro en la base de datos sin el archivo aún
            $auto = new Auto();
            $auto->fecha = now();
            $auto->numero = $request->numero;
            $auto->tipo = $request->tipo;
            $auto->owner_type = $request->owner_type;
            $auto->owner_id = $request->owner_id;
            $auto->usuario_id = $request->usuario_id;
            $auto->save();

            // Obtener la configuración de la aplicación
            $config = Configuracion::first();

            // Generar PDF
            $pdf = PDF::loadView($view, compact('auto', 'config', 'owner'));

            // Nombre de archivo dinámico
            $tipo_nombre = strtoupper($request->tipo ?? 'AUTO');
            $filename = $tipo_nombre . '_' . $auto->id . '_' . now()->format('YmdHis') . '.pdf';
            $directory = public_path('autosGenerates');

            if (!File::exists($directory)) {
                File::makeDirectory($directory, 0755, true);
            }

            $path = $directory . '/' . $filename;

            // Guardar el archivo
            $pdf->save($path);

            // Actualizar registro con la ruta del archivo
            $auto->keyarchivo = 'autosGenerates/' . $filename;
            $auto->save();

            return back()->with('success', ($request->tipo ? strtoupper($request->tipo) : 'AUTO') . ' generado exitosamente.');
        } catch (\Throwable $e) {
            \Log::error('Error al generar documento: ' . $e->getMessage(), [
                'line' => $e->getLine(),
                'file' => $e->getFile(),
                'trace' => $e->getTraceAsString(),
            ]);

            // Eliminar registro si se creó antes de fallar el archivo
            if (isset($auto) && $auto->exists) {
                $auto->delete();
            }

            return back()->withErrors(['custom' => 'Ocurrió un error al generar el documento: ' . $e->getMessage()]);
        }
    }

    public function destroy(Auto $auto)
    {
        try {
            if ($auto->keyarchivo && File::exists(public_path($auto->keyarchivo))) {
                File::delete(public_path($auto->keyarchivo));
            }
            $auto->delete();
            return back()->with('success', 'Documento eliminado.');
        } catch (\Throwable $e) {
            \Log::error('Error al eliminar AUTO: ' . $e->getMessage());
            return back()->withErrors(['custom' => 'Error al eliminar el documento: ' . $e->getMessage()]);
        }
    }
}
