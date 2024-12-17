<?php

namespace App\Http\Controllers;

use App\Models\Asociacion;
use App\Models\Funcionario;
use App\Models\Comuna;
use Illuminate\Http\Request;

class AsociacionController extends Controller
{

    public function index(Request $request)
{
    $search = $request->input('search');

    $asociaciones = Asociacion::with(['presidente', 'comuna'])
        ->when($search, function ($query, $search) {
            $query->where('nombre', 'like', "%{$search}%")
                ->orWhereHas('presidente', function ($query) use ($search) {
                    $query->where('nombre', 'like', "%{$search}%")
                          ->orWhere('num_documento', 'like', "%{$search}%");
                })
                ->orWhereHas('comuna', function ($query) use ($search) {
                    $query->where('nombre', 'like', "%{$search}%");
                })
                ->orWhere('resolucion', 'like', "%{$search}%");
        })
        ->paginate(20);

    return view('asociaciones.index', compact('asociaciones'));
}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $funcionarios = Funcionario::all();
        $comunas = Comuna::all();
        return view('asociaciones.create', compact('funcionarios', 'comunas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'presidente_id' => 'required|exists:funcionarios,id',
            'secretario_id' => 'required|exists:funcionarios,id',
            'vicepresidente_id' => 'required|exists:funcionarios,id',
            'tesorero_id' => 'required|exists:funcionarios,id',
            'fiscal_id' => 'required|exists:funcionarios,id',
            'comuna_id' => 'required|exists:comunas,id',
            'concil1_id' => 'required|exists:funcionarios,id',
            'concil2_id' => 'required|exists:funcionarios,id',
            'concil3_id' => 'required|exists:funcionarios,id',
            'delegado1_id' => 'required|exists:funcionarios,id',
            'delegado2_id' => 'required|exists:funcionarios,id',
            'delegado3_id' => 'required|exists:funcionarios,id',
        ], [
            'presidente_id.exists' => 'El presidente debe ser un funcionario registrado.',
            'secretario_id.exists' => 'El secretario debe ser un funcionario registrado.',
            'vicepresidente_id.exists' => 'El vicepresidente debe ser un funcionario registrado.',
            'tesorero_id.exists' => 'El tesorero debe ser un funcionario registrado.',
            'fiscal_id.exists' => 'El fiscal debe ser un funcionario registrado.',
            'comuna_id.exists' => 'la comuna debe estar registrada.',
            'concil1_id.exists' => 'El conciliador 1 debe ser un funcionario registrado.',
            'concil2_id.exists' => 'El conciliador 2 debe ser un funcionario registrado.',
            'concil3_id.exists' => 'El conciliador 3 debe ser un funcionario registrado.',
            'delegado1_id.exists' => 'El delegado 1 debe ser un funcionario registrado.',
            'delegado2_id.exists' => 'El delegado 1 debe ser un funcionario registrado.',
            'delegado3_id.exists' => 'El delegado 1 debe ser un funcionario registrado.',
        ]);
        Asociacion::create($request->all());
        return redirect()->route('asociaciones.index')->with('success', 'Asociación creada exitosamente.');
    }


    public function show(Asociacion $asociacion)
    {
        return view('asociaciones.show', compact('asociacion'));
    }


    public function edit(Asociacion $asociacion)
    {
        $funcionarios = Funcionario::all();
        $comunas = Comuna::all();
        $asociacion->load(['documentos' => function ($query) {
            $query->where('documentable_type', Asociacion::class);
        }]);
        return view('asociaciones.edit', compact('asociacion','funcionarios','comunas'));
    }


    public function update(Request $request, Asociacion $asociacion)
    {
        $asociacion->update($request->all());
        return redirect()->route('asociaciones.index')->with('success', 'Asociación actualizada exitosamente.');
    }


    public function destroy(Asociacion $asociacion)
    {
        $asociacion->delete();
        return redirect()->route('asociaciones.index')->with('success', 'Asociación eliminada exitosamente.');
    }
}
