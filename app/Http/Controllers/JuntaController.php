<?php

namespace App\Http\Controllers;

use App\Models\Junta;
use App\Models\Funcionario;
use App\Models\Comuna;
use Illuminate\Http\Request;

class JuntaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $juntas = Junta::with('presidente', 'comuna')->get();
        return view('juntas.index', compact('juntas'));
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
        return view('juntas.create', compact('funcionarios', 'comunas'));
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
        Junta::create($request->all());
        return redirect()->route('juntas.index')->with('success', 'JAC creada exitosamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Junta  $junta
     * @return \Illuminate\Http\Response
     */
    public function show(Junta $junta)
    {
        return view('juntas.show', compact('junta'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Junta  $junta
     * @return \Illuminate\Http\Response
     */
    public function edit(Junta $junta)
    {
        $funcionarios = Funcionario::all();
        $comunas = Comuna::all();
        return view('juntas.edit', compact('junta','funcionarios','comunas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Junta  $junta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Junta $junta)
    {
        $junta->update($request->all());
        return redirect()->route('juntas.index')->with('success', 'Junta actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Junta  $junta
     * @return \Illuminate\Http\Response
     */
    public function destroy(Junta $junta)
    {
        $junta->delete();
        return redirect()->route('juntas.index')->with('success', 'Junta eliminada exitosamente.');
    }
}
