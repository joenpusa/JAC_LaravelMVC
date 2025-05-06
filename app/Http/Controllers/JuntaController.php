<?php

namespace App\Http\Controllers;

use App\Models\Junta;
use App\Models\Funcionario;
use App\Models\Comuna;
use App\Models\Municipio;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;

class JuntaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $municipios = Municipio::orderBy('nombre_municipio')->get();
        $juntas = Junta::with(['presidente', 'municipio'])
            ->when($search, function ($query, $search) {
                $query->where('juntas.nombre', 'like', "%{$search}%")
                    ->orWhereHas('presidente', function ($query) use ($search) {
                        $query->where('nombre', 'like', "%{$search}%")
                              ->orWhere('num_documento', 'like', "%{$search}%");
                    })
                    ->orWhereHas('municipio', function ($query) use ($search) {
                        $query->where('nombre_municipio', 'like', "%{$search}%");
                    })
                    ->orWhere('juntas.resolucion', 'like', "%{$search}%");
            })->paginate(20);

        return view('juntas.index', compact('juntas', 'municipios'));
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
        $municipios = Municipio::all();
        return view('juntas.create', compact('funcionarios', 'comunas', 'municipios'));
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
            'secretario_id' => 'nullable|exists:funcionarios,id',
            'vicepresidente_id' => 'nullable|exists:funcionarios,id',
            'tesorero_id' => 'nullable|exists:funcionarios,id',
            'fiscal_id' => 'nullable|exists:funcionarios,id',
            'comuna_id' => 'nullable|exists:comunas,id',
            'municipio_id' => 'required|exists:municipios,id',
            'personeria' => 'required|string|max:255',
            'nombre' => 'required|string|max:255',
            'resolucion' => 'nullable|string|max:255',
        ], [
            'presidente_id.exists' => 'El presidente debe ser un funcionario registrado.',
            'secretario_id.exists' => 'El secretario debe ser un funcionario registrado.',
            'vicepresidente_id.exists' => 'El vicepresidente debe ser un funcionario registrado.',
            'tesorero_id.exists' => 'El tesorero debe ser un funcionario registrado.',
            'fiscal_id.exists' => 'El fiscal debe ser un funcionario registrado.',
            'comuna_id.exists' => 'la comuna debe estar registrada.',
            'municipio_id.exists' => 'El municipio debe estar registrado.',
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
        $municipios = Municipio::all();
        $junta->load(['documentos', 'comisiones', 'autos', 'carpetas']);
        return view('juntas.edit', compact('junta','funcionarios','comunas','municipios'));
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

    public function getPorMunicipio($municipioId)
    {
        $juntas = Junta::where('municipio_id', $municipioId)->get();
        return response()->json($juntas);
    }

    public function export(Request $request)
    {
        // dd($request->all());
        $municipioId = $request->input('municipio_id');

        $query = \App\Models\Junta::with(['municipio', 'presidente']);

        if ($municipioId !== 'all') {
            $query->where('municipio_id', $municipioId);
            $municipio = \App\Models\Municipio::find($municipioId);
            $filename = 'juntas_' . Str::slug($municipio->nombre_municipio) . '.xlsx';
        } else {
            $filename = 'juntas_todos_los_municipios.xlsx';
        }

        $juntas = $query->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Encabezados
        $sheet->fromArray([
            ['Municipio', 'Razón Social', 'Resolución', 'Presidente', 'Dirección', 'Email']
        ], null, 'A1');

        // Datos
        $row = 2;
        foreach ($juntas as $junta) {
            $sheet->setCellValue("A{$row}", $junta->municipio->nombre_municipio ?? 'N/A');
            $sheet->setCellValue("B{$row}", $junta->nombre);
            $sheet->setCellValue("C{$row}", $junta->resolucion);
            $sheet->setCellValue("D{$row}", $junta->presidente->nombre ?? 'N/A');
            $sheet->setCellValue("E{$row}", $junta->presidente->direccion ?? 'N/A');
            $sheet->setCellValue("F{$row}", $junta->presidente->email ?? 'N/A');
            $row++;
        }

        // Crear archivo temporal
        $writer = new Xlsx($spreadsheet);
        $tempFile = tempnam(sys_get_temp_dir(), 'excel');
        $writer->save($tempFile);

        return response()->download($tempFile, $filename)->deleteFileAfterSend(true);
    }


}
