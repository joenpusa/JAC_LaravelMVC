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
