<?php

namespace App\Http\Controllers;

use App\Models\Certificado;
use Illuminate\Http\Request;
use App\Models\Junta;
use App\Models\Asociacion;
use App\Models\Configuracion;
use PDF;

class CertificadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $certificados = Certificado::query();

        if ($search) {
            $certificados = $certificados->where('nombre_junta', 'LIKE', "%{$search}%")
                                        ->orWhere('documento_dignario', 'LIKE', "%{$search}%")
                                        ->orWhere('nombre_dignatario', 'LIKE', "%{$search}%")
                                        ->orWhere('codigo_hash', 'LIKE', "%{$search}%")
                                        ->orWhere('created_at', 'LIKE', "%{$search}%");;
        }
        $certificados = $certificados->orderBy('created_at', 'desc')->paginate(20);
        return view('certificados.index', compact('certificados'));
    }

    public function generar(Request $request)
    {
        try {
            $validated = $request->validate([
                'junta_id' => 'required|exists:juntas,id',
                'cargo' => 'required|in:PRESIDENTE,VICEPRESIDENTE,SECRETARIO,TESORERO,FISCAL',
                'num_documento' => 'required|numeric',
            ],[
                'num_documento.numeric' => 'El documento debe ser numérico.',
                'junta_id.exists' => 'La junta no fue encontrada.',
                'cargo.required' => 'Debe seleccionar un cargo.',
                'cargo.in' => 'El cargo seleccionado no es válido.',
            ]);
            $junta = Junta::find($validated['junta_id']);

            $relacionCargo = strtolower($validated['cargo']); // presidente, vicepresidente, etc.
            $dignatario = $junta->{$relacionCargo};

            if ($junta && $dignatario && $dignatario->num_documento == $validated['num_documento']) {
                $certificado = Certificado::create([
                    'nombre_dignatario'             => $dignatario->nombre,
                    'cargo'                         => $validated['cargo'],
                    'auto_numero'                   => $junta->auto_numero,
                    'comuna'                        => $junta->municipio ? $junta->municipio->nombre_municipio : 'N/A',
                    'nombre_junta'                  => $junta->nombre,
                    'codigo_hash'                   => uniqid(),
                    'resolucion'                    => $junta->resolucion ?: 'No Registra',
                    'fecha_resolucion'              => $junta->fecha_resolucion ?? date('Y-m-d'),
                    'fecha_eleccion'                => $junta->fecha_eleccion ?? date('Y-m-d'),
                    'documento_dignario'            => $dignatario->num_documento,
                    'tipo'                          => 'Junta'
                ]);
                $config = Configuracion::first();
                $pdf = PDF::loadView('certificados.certificado', compact('certificado','config','junta'));
                return $pdf->download('certificado.pdf');
            } else {
                return redirect()->back()->withErrors(['num_documento' => 'El número de documento no coincide con el ' . strtolower($validated['cargo']) . ' de la junta seleccionada.']);
            }
        }catch(\Exception $e){
            return redirect()->back()->withErrors(['error' => 'Ocurrió un error al procesar su solicitud.']);
        }
    }

    public function generarAso(Request $request)
    {
        try {
            $validated = $request->validate([
                'asociacion_id' => 'required|exists:asociaciones,id',
                'cargo' => 'required|in:PRESIDENTE,VICEPRESIDENTE,SECRETARIO,TESORERO,FISCAL',
                'num_documentoAso' => 'required|numeric',
            ],[
                'num_documentoAso.numeric' => 'El documento debe ser numérico.',
                'asociacion_id.exists' => 'La asociación no fue encontrada.',
                'cargo.required' => 'Debe seleccionar un cargo.',
                'cargo.in' => 'El cargo seleccionado no es válido.',
            ]);

            $asociacion = Asociacion::with(['municipio', 'presidente', 'vicepresidente', 'secretario', 'tesorero', 'fiscal'])->find($validated['asociacion_id']);

            $relacionCargo = strtolower($validated['cargo']); // presidente, vicepresidente, etc.
            $dignatario = $asociacion ? $asociacion->{$relacionCargo} : null;

            if ($asociacion && $dignatario && $dignatario->num_documento == $validated['num_documentoAso']) {
                $certificado = Certificado::create([
                    'nombre_dignatario'             => $dignatario->nombre,
                    'cargo'                         => $validated['cargo'],
                    'auto_numero'                   => $asociacion->auto_numero,
                    'comuna'                        => $asociacion->municipio ? $asociacion->municipio->nombre_municipio : 'N/A',
                    'nombre_junta'                  => $asociacion->nombre,
                    'codigo_hash'                   => uniqid(),
                    'resolucion'                    => $asociacion->resolucion ?: 'No Registra',
                    'fecha_resolucion'              => $asociacion->fecha_resolucion ?? date('Y-m-d'),
                    'fecha_eleccion'                => $asociacion->fecha_eleccion ?? date('Y-m-d'),
                    'documento_dignario'            => $dignatario->num_documento,
                    'tipo'                          => 'Asociación'
                ]);
                $config = Configuracion::first();
                $pdf = PDF::loadView('certificados.certificado', compact('certificado', 'config', 'asociacion'));
                return $pdf->download('certificadoAsociacion.pdf');
            } else {
                return redirect()->back()->withErrors(['num_documento' => 'El número de documento no coincide con el ' . strtolower($validated['cargo']) . ' de la asociación seleccionada.']);
            }
        }catch(\Exception $e){
            return redirect()->back()->withErrors(['error' => 'Ocurrió un error al procesar su solicitud.']);
        }
    }

    public function validar(Request $request)
    {
        try {
            $request->validate([
                'fecha_certificado' => 'required|date',
                'cod_certificado' => 'required|string|max:25',
            ]);
            // Buscar el certificado en la base de datos
            $certificado = Certificado::whereDate('created_at', $request->fecha_certificado)
                ->where('codigo_hash', $request->cod_certificado)
                ->first();
            if (!$certificado) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['error' => 'El certificado no es válido o los datos no coinciden con nuestros registros.'])
                    ->with('tab', 'validate');
            }

            // Actualizar el campo 'verificado' a 'Si'
            $certificado->update(['verificado' => 'Si']);

            $fecha = \Carbon\Carbon::parse($certificado->created_at)->format('d/m/Y');
            $tipo = $certificado->tipo === 'Asociación' ? 'Asociación de Juntas' : 'Junta de Acción Comunal';
            $mensaje = "Certificado verificado con éxito. Fue generado el {$fecha} para la {$tipo} \"{$certificado->nombre_junta}\".";

            return redirect()->back()
                ->with('success', $mensaje)
                ->with('certificado_validado', [
                    'codigo'     => $certificado->codigo_hash,
                    'fecha'      => $fecha,
                    'tipo'       => $tipo,
                    'nombre'     => $certificado->nombre_junta,
                    'municipio'  => $certificado->comuna,
                    'cargo'      => $certificado->cargo,
                    'resolucion' => ($certificado->resolucion && $certificado->resolucion !== 'No Registra') ? $certificado->resolucion : null,
                ])
                ->with('tab', 'validate');
        }catch(\Exception $e){
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Ocurrió un error al procesar su solicitud.'])
                ->with('tab', 'validate');
        }
    }
}
