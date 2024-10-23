<?php

namespace App\Http\Controllers;

use App\Models\Comuna;
use App\Models\Municipio;
use Illuminate\Http\Request;

class ComunaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request )
    {
        $search = $request->input('search');

        $comunas = Comuna::with(['municipio'])
            ->when($search, function ($query, $search) {
                $query->where('comunas.nombre', 'like', "%{$search}%")
                    ->orWhereHas('municipio', function ($query) use ($search) {
                        $query->where('nombre_municipio', 'like', "%{$search}%");
                    });
            })->paginate(20);

        return view('comunas.index', compact('comunas', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $municipios = Municipio::all();
        return view('comunas.create', compact('municipios'));
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
            'nombre' => 'required',
            'municipio_id' => 'required|exists:municipios,id',
        ], [
            'municipio_id.exists' => 'El municipio no es valido.',
        ]);
        Comuna::create($request->all());
        return redirect()->route('comunas.index')->with('success', 'Comuna creada exitosamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comuna  $comuna
     * @return \Illuminate\Http\Response
     */
    public function show(Comuna $comuna)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comuna  $comuna
     * @return \Illuminate\Http\Response
     */
    public function edit(Comuna $comuna)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comuna  $comuna
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comuna $comuna)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comuna  $comuna
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comuna $comuna)
    {
        $comuna->delete();
        return redirect()->route('comunas.index')->with('success', 'Comuna eliminada exitosamente.');
    }
}
