<?php

namespace App\Http\Controllers;

use App\Models\Certificado;
use Illuminate\Http\Request;
use App\Models\Junta;
use App\Models\Asociacion;
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //En caso de que en la sesion el funcionarios los cree de manera manual
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Certificado  $certificado
     * @return \Illuminate\Http\Response
     */
    public function show(Certificado $certificado)
    {
        //
    }

    public function generar(Request $request)
    {
        try {
            $validated = $request->validate([
                'junta_id' => 'required|exists:juntas,id',
                'num_documento' => 'required|numeric',
            ],[
                'num_documento.numeric' => 'El documento debe ser numérico.',
                'junta_id.exists' => 'La junta no fue encontrada.',
            ]);
            $junta = Junta::find($validated['junta_id']);

            if ($junta && $junta->presidente && $junta->presidente->num_documento == $validated['num_documento']) {

                $certificado = Certificado::create([
                    'nombre_dignatario' => $junta->presidente->nombre,
                    'comuna' => $junta->comuna->nombre,
                    'nombre_junta' => $junta->nombre,
                    'codigo_hash' => uniqid(),
                    'resolucion' => $junta->resolucion,
                    'fecha_resolucion' => $junta->fecha_resolucion,
                    'fecha_eleccion' => $junta->fecha_eleccion,
                    'documento_dignario' => $junta->presidente->num_documento,
                    'tipo' => 'Junta'
                ]);
                $pdf = PDF::loadView('certificados.certificado', compact('certificado'));
                return $pdf->download('certificado.pdf');
            } else {
                return redirect()->back()->withErrors(['num_documento' => 'El número de documento no coincide con el presidente de la junta seleccionada.']);
            }
        }catch(\Exception $e){
            return redirect()->back()->withErrors('error', 'Ocurrió un error al procesar su solicitud.');
        }
    }

    public function generarAso(Request $request)
    {

        try {
            $validated = $request->validate([
                'asociacion_id' => 'required|exists:asociaciones,id',
                'num_documento' => 'required|numeric',
            ],[
                'num_documento.numeric' => 'El documento debe ser numérico.',
                'asociacion_id.exists' => 'La asociacion no fue encontrada.',
            ]);
            $asociacion = Asociacion::find($validated['asociacion_id']);

            if ($asociacion && $asociacion->presidente && $asociacion->presidente->num_documento == $validated['num_documento']) {

                $certificado = Certificado::create([
                    'nombre_dignatario' => $asociacion->presidente->nombre,
                    'comuna' => $asociacion->comuna->nombre,
                    'nombre_junta' => $asociacion->nombre,
                    'codigo_hash' => uniqid(),
                    'resolucion' => $asociacion->resolucion,
                    'fecha_resolucion' => $asociacion->fecha_resolucion,
                    'fecha_eleccion' => $asociacion->fecha_eleccion,
                    'documento_dignario' => $asociacion->presidente->num_documento,
                    'tipo' => 'Asociación'
                ]);
                $pdf = PDF::loadView('certificados.certificado', compact('certificado'));
                return $pdf->download('certificadoAsociacion.pdf');
            } else {
                return redirect()->back()->withErrors(['num_documento' => 'El número de documento no coincide con el presidente de la asociacion seleccionada.']);
            }
        }catch(\Exception $e){
            return redirect()->back()->withErrors('error', 'Ocurrió un error al procesar su solicitud.');
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
                return redirect()->back()->withErrors(['error' => 'El certificado no es válido.']);
            }

            // Actualizar el campo 'verificado' a 'Si'
            $certificado->update(['verificado' => 'Si']);
            return redirect()->back()->with('success', 'Certificado encontrado con éxito.');
        }catch(\Exception $e){
            return redirect()->back()->withErrors('error', 'Ocurrió un error al procesar su solicitud.');
        }
    }
}
