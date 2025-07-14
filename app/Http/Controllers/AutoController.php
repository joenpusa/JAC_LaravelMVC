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

        // datos de owner
        if ($request->owner_type == 'App\Models\Junta') {
            $owner = Junta::find($request->owner_id);
            $view = 'certificados.auto_jac';
            $cargos = [
                'CONCILIADOR 1',
                'CONCILIADOR 2',
                'CONCILIADOR 3',
                'CONCILIADOR 4',
                'DELEGADO PRINCIPAL 1',
                'DELEGADO PRINCIPAL 2',
                'DELEGADO PRINCIPAL 3',
                'DELEGADO PRINCIPAL 4',
            ];
        } else {
            $owner = Asociacion::find($request->owner_id);
            $view = 'certificados.auto_aso';
            $cargos = [
                'CONCILIADOR 1',
                'CONCILIADOR 2',
                'CONCILIADOR 3',
                'CONCILIADOR 4',
                'FISCAL SUPLENTE',
                'DELEGADO PRINCIPAL 1',
                'DELEGADO SUPLEMENTE 1',
                'DELEGADO PRINCIPAL 2',
                'DELEGADO SUPLEMENTE 2',
                'DELEGADO PRINCIPAL 3',
                'DELEGADO SUPLEMENTE 3',
                'DELEGADO PRINCIPAL 4',
                'DELEGADO SUPLEMENTE 4',
            ];
        }

        if (strtolower($request->tipo) === 'resolución' || strtolower($request->tipo) === 'resolucion') {
            $view = 'certificados.resolucion';
        }

        // Verifico si ya tiene todos los comisionados
        $comisionados = $owner->comisiones()->get();
        foreach ($cargos as $cargo) {
            $comision = $owner->comisiones->firstWhere('nomcomision', $cargo);
            if (!$comision) {
                return back()->withErrors(['custom' => 'Falta el comisionado ' . $cargo . ' para generar el documento.']);
            }
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
