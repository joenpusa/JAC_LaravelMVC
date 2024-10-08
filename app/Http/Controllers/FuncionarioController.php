<?php

namespace App\Http\Controllers;

use App\Models\Funcionario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FuncionarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $funcionarios = Funcionario::query();
        if ($search) {
            $funcionarios = $funcionarios->where('nombre', 'LIKE', "%{$search}%")
                                        ->orWhere('tipo_documento', 'LIKE', "%{$search}%")
                                        ->orWhere('num_documento', 'LIKE', "%{$search}%")
                                        ->orWhere('profesion', 'LIKE', "%{$search}%");
        }

        $funcionarios = $funcionarios->orderBy('nombre', 'asc')->paginate(20);

        return view('funcionarios.index', compact('funcionarios', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('funcionarios.create');
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
             'tipo_documento' => 'required',
             'num_documento' => 'required|unique:funcionarios',
             'num_afiliacion' => 'required',
             'genero' => 'required',
             'direccion' => 'required',
             'profesion' => 'required',
             'discapacidad' => 'required',
             'grupo_etnico' => 'required',
             'email' => 'required',
         ],[
            'num_documento.unique' => 'El número de documento ya está registrado.',
        ]);

        Funcionario::create($request->all());
        return redirect()->route('funcionarios.index')->with('success', 'Funcionario creado exitosamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Funcionario  $funcionario
     * @return \Illuminate\Http\Response
     */
    public function show(Funcionario $funcionario)
    {
        return view('funcionarios.show', compact('funcionario'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Funcionario  $funcionario
     * @return \Illuminate\Http\Response
     */
    public function edit(Funcionario $funcionario)
    {
        return view('funcionarios.edit', compact('funcionario'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Funcionario  $funcionario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Funcionario $funcionario)
    {
        $request->validate([
            'nombre' => 'required',
            'tipo_documento' => 'required',
            'num_documento' => 'required|unique:funcionarios,num_documento,'.$funcionario->id,
            'num_afiliacion' => 'required',
            'genero' => 'required',
            'direccion' => 'required',
            'profesion' => 'required',
        ]);

        $funcionario->update($request->all());
        return redirect()->route('funcionarios.index')->with('success', 'Funcionario actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Funcionario  $funcionario
     * @return \Illuminate\Http\Response
     */
    public function destroy(Funcionario $funcionario)
    {

        $funcionario->delete();
        return redirect()->route('funcionarios.index')->with('success', 'Funcionario eliminado exitosamente.');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'document' => 'required|file|max:5120',
            'funcionario_id' => 'required|numeric',
        ]);

        $funcionario = Funcionario::find($request->funcionario_id);

        if (!$funcionario) {
            return response()->json(['error' => 'Funcionario no encontrado'], 404);
        }

        if ($funcionario->key_anexo) {
            Storage::disk('public')->delete('documents/funcionarios/'.$funcionario->key_anexo);
        }

        $file = $request->file('document');
        $originalFileName = $file->getClientOriginalName();
        $filePath = time() . '_' . $originalFileName;
        $file->storeAs('documents/funcionarios', $filePath, 'public');

        $funcionario->name_anexo = $originalFileName;
        $funcionario->key_anexo = $filePath;
        $funcionario->save();

        return response()->json(['success' => 'Archivo subido con éxito', 'fileName' => $originalFileName]);
    }
}
