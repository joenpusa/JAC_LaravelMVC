<?php

namespace App\Http\Controllers;

use App\Models\Asociacion;
use App\Models\Funcionario;
use App\Models\Comuna;
use App\Models\Municipio;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;

class AsociacionController extends Controller
{

    public function index(Request $request)
{
    $search = $request->input('search');

    $municipios = Municipio::orderBy('nombre_municipio')->get();
    $asociaciones = Asociacion::with(['presidente', 'municipio'])
        ->when($search, function ($query, $search) {
            $query->where('nombre', 'like', "%{$search}%")
                ->orWhereHas('presidente', function ($query) use ($search) {
                    $query->where('nombre', 'like', "%{$search}%")
                          ->orWhere('num_documento', 'like', "%{$search}%");
                })
                ->orWhereHas('municipio', function ($query) use ($search) {
                    $query->where('nombre_municipio', 'like', "%{$search}%");
                })
                ->orWhere('resolucion', 'like', "%{$search}%");
        })
        ->paginate(20);

    return view('asociaciones.index', compact('asociaciones', 'municipios'));
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
        return view('asociaciones.create', compact('funcionarios', 'comunas', 'municipios'));
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
            'personeria' => 'required|string|max:255',
            'vicepresidente_id' => 'nullable|exists:funcionarios,id',
            'tesorero_id' => 'nullable|exists:funcionarios,id',
            'fiscal_id' => 'nullable|exists:funcionarios,id',
            'comuna_id' => 'nullable|exists:comunas,id',
            'municipio_id' => 'required|exists:municipios,id',
        ], [
            'presidente_id.exists' => 'El presidente debe ser un funcionario registrado.',
            'secretario_id.exists' => 'El secretario debe ser un funcionario registrado.',
            'vicepresidente_id.exists' => 'El vicepresidente debe ser un funcionario registrado.',
            'tesorero_id.exists' => 'El tesorero debe ser un funcionario registrado.',
            'fiscal_id.exists' => 'El fiscal debe ser un funcionario registrado.',
            'comuna_id.exists' => 'la comuna debe estar registrada.',
            'municipio_id.exists' => 'El municipio debe estar registrado.',
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
        $municipios = Municipio::all();
        $asociacion->load(['documentos', 'comisiones', 'autos', 'carpetas']);
        return view('asociaciones.edit', compact('asociacion','funcionarios','comunas','municipios'));
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

    public function getPorMunicipio($municipioId)
    {
        $asociaciones = Asociacion::where('municipio_id', $municipioId)->get();
        return response()->json($asociaciones);
    }

    public function export(Request $request)
    {
        // dd($request->all());
        $municipioId = $request->input('municipio_id');

        $query = \App\Models\Asociacion::with(['municipio', 'presidente']);

        if ($municipioId !== 'all') {
            $query->where('municipio_id', $municipioId);
            $municipio = \App\Models\Municipio::find($municipioId);
            $filename = 'asociaciones_' . Str::slug($municipio->nombre_municipio) . '.xlsx';
        } else {
            $filename = 'asoicaciones_todos_los_municipios.xlsx';
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
