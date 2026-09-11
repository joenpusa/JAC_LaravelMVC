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
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\Fill;
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
            'presidente_id' => 'nullable|exists:funcionarios,id',
            'secretario_id' => 'nullable|exists:funcionarios,id',
            'vicepresidente_id' => 'nullable|exists:funcionarios,id',
            'tesorero_id' => 'nullable|exists:funcionarios,id',
            'fiscal_id' => 'nullable|exists:funcionarios,id',
            'comuna_id' => 'nullable|exists:comunas,id',
            'municipio_id' => 'required|exists:municipios,id',
            'personeria' => 'nullable|string|max:255',
            'nombre' => 'required|string|max:255',
            'resolucion' => 'nullable|string|max:255',
            'auto_numero' => 'nullable|string|max:255',
            'tipo_auto' => 'nullable|string|max:255',
            'fecha_auto' => 'nullable|date',
            'fecha_inicio_periodo' => 'nullable|date',
            'fecha_final_periodo' => 'nullable|date',
            'tipo_oac' => 'nullable|string|max:255',
            'zona' => 'nullable|string|max:255',
        ], [
            'presidente_id.exists' => 'El presidente debe ser un funcionario registrado.',
            'secretario_id.exists' => 'El secretario debe ser un funcionario registrado.',
            'vicepresidente_id.exists' => 'El vicepresidente debe ser un funcionario registrado.',
            'tesorero_id.exists' => 'El tesorero debe ser un funcionario registrado.',
            'fiscal_id.exists' => 'El fiscal debe ser un funcionario registrado.',
            'comuna_id.exists' => 'la comuna debe estar registrada.',
            'municipio_id.exists' => 'El municipio debe estar registrado.',
        ]);
        $funcionarios = [
            $request->presidente_id,
            $request->vicepresidente_id,
            $request->secretario_id,
            $request->tesorero_id,
            $request->fiscal_id,
        ];

        // Filtra nulos
        $funcionarios = array_filter($funcionarios);

        // Consulta si alguno ya está asignado en otra junta
        $existe = Junta::where(function ($query) use ($funcionarios) {
            $query->whereIn('presidente_id', $funcionarios)
                  ->orWhereIn('vicepresidente_id', $funcionarios)
                  ->orWhereIn('secretario_id', $funcionarios)
                  ->orWhereIn('tesorero_id', $funcionarios)
                  ->orWhereIn('fiscal_id', $funcionarios);
        })->exists();

        if ($existe) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['funcionario' => 'Uno o más funcionarios ya están asignados en otra Junta.']);
        }
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
        $funcionarios = [
            $request->presidente_id,
            $request->vicepresidente_id,
            $request->secretario_id,
            $request->tesorero_id,
            $request->fiscal_id,
        ];

        $funcionarios = array_filter($funcionarios);

        $existe = Junta::where('id', '!=', $junta->id)
            ->where(function ($query) use ($funcionarios) {
                $query->whereIn('presidente_id', $funcionarios)
                      ->orWhereIn('vicepresidente_id', $funcionarios)
                      ->orWhereIn('secretario_id', $funcionarios)
                      ->orWhereIn('tesorero_id', $funcionarios)
                      ->orWhereIn('fiscal_id', $funcionarios);
            })->exists();

        if ($existe) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['funcionario' => 'Uno o más funcionarios ya están asignados en otra Junta.']);
        }
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
        $municipioId = $request->input('municipio_id');

        $query = Junta::with([
            'municipio',
            'comuna',
            'presidente',
            'vicepresidente',
            'secretario',
            'tesorero',
            'fiscal',
            'comisiones'
        ]);

        if ($municipioId !== 'all') {
            $query->where('municipio_id', $municipioId);
            $municipio = Municipio::find($municipioId);
            $filename = 'juntas_' . Str::slug($municipio->nombre_municipio ?? 'municipio') . '.xlsx';
        } else {
            $filename = 'juntas_todos_los_municipios.xlsx';
        }

        $juntas = $query->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Encabezados completos: Junta y Dignatarios
        $headers = [
            'Municipio',
            'Comuna',
            'Razón Social',
            'Resolución',
            'Fecha Resolución',
            'Personería Jurídica',
            'Tipo O.A.C.',
            'Zona',
            'Fecha Elección',
            'Fecha Inicio Periodo',
            'Fecha Final Periodo',
            'Auto No.',
            'Tipo Auto',
            'Fecha Auto',

            'Presidente - Tipo Documento',
            'Presidente - No. Documento',
            'Presidente - Nombre',
            'Presidente - Teléfono',
            'Presidente - Email',
            'Presidente - Dirección',
            'Presidente - Profesión',
            'Presidente - Género',

            'Vicepresidente - Tipo Documento',
            'Vicepresidente - No. Documento',
            'Vicepresidente - Nombre',
            'Vicepresidente - Teléfono',
            'Vicepresidente - Email',
            'Vicepresidente - Dirección',
            'Vicepresidente - Profesión',
            'Vicepresidente - Género',

            'Secretario - Tipo Documento',
            'Secretario - No. Documento',
            'Secretario - Nombre',
            'Secretario - Teléfono',
            'Secretario - Email',
            'Secretario - Dirección',
            'Secretario - Profesión',
            'Secretario - Género',

            'Tesorero - Tipo Documento',
            'Tesorero - No. Documento',
            'Tesorero - Nombre',
            'Tesorero - Teléfono',
            'Tesorero - Email',
            'Tesorero - Dirección',
            'Tesorero - Profesión',
            'Tesorero - Género',

            'Fiscal - Tipo Documento',
            'Fiscal - No. Documento',
            'Fiscal - Nombre',
            'Fiscal - Teléfono',
            'Fiscal - Email',
            'Fiscal - Dirección',
            'Fiscal - Profesión',
            'Fiscal - Género',

            'Comisionados',
        ];

        $extractDignatario = function ($funcionario) {
            if (!$funcionario) {
                return ['', '', '', '', '', '', '', ''];
            }
            return [
                $funcionario->tipo_documento ?? '',
                $funcionario->num_documento ?? '',
                $funcionario->nombre ?? '',
                $funcionario->telefono ?? '',
                $funcionario->email ?? '',
                $funcionario->direccion ?? '',
                $funcionario->profesion ?? '',
                $funcionario->genero ?? '',
            ];
        };

        $rows = [$headers];

        foreach ($juntas as $junta) {
            $comisionados = $junta->comisiones->isNotEmpty()
                ? $junta->comisiones->map(function ($c) {
                    return "{$c->nomcomision}: {$c->nomcomisionado} ({$c->doccomisionado})";
                })->implode(' | ')
                : '';

            $rows[] = array_merge(
                [
                    $junta->municipio->nombre_municipio ?? 'N/A',
                    $junta->comuna->nombre_comuna ?? '',
                    $junta->nombre ?? '',
                    $junta->resolucion ?? '',
                    $junta->fecha_resolucion ?? '',
                    $junta->personeria ?? '',
                    $junta->tipo_oac ?? '',
                    $junta->zona ?? '',
                    $junta->fecha_eleccion ?? '',
                    $junta->fecha_inicio_periodo ?? '',
                    $junta->fecha_final_periodo ?? '',
                    $junta->auto_numero ?? '',
                    $junta->tipo_auto ?? '',
                    $junta->fecha_auto ?? '',
                ],
                $extractDignatario($junta->presidente),
                $extractDignatario($junta->vicepresidente),
                $extractDignatario($junta->secretario),
                $extractDignatario($junta->tesorero),
                $extractDignatario($junta->fiscal),
                [
                    $comisionados,
                ]
            );
        }

        $sheet->fromArray($rows, null, 'A1');

        $highestColumn = $sheet->getHighestDataColumn();

        // Estilos para encabezado
        $sheet->getStyle("A1:{$highestColumn}1")->getFont()->setBold(true);
        $sheet->getStyle("A1:{$highestColumn}1")->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFEFEFEF');

        // Congelar fila de encabezados
        $sheet->freezePane('A2');

        // Autoajuste del ancho de columnas
        $highestColumnIndex = Coordinate::columnIndexFromString($highestColumn);
        for ($col = 1; $col <= $highestColumnIndex; $col++) {
            $sheet->getColumnDimensionByColumn($col)->setAutoSize(true);
        }

        // Crear archivo temporal
        $writer = new Xlsx($spreadsheet);
        $tempFile = tempnam(sys_get_temp_dir(), 'excel');
        $writer->save($tempFile);

        return response()->download($tempFile, $filename)->deleteFileAfterSend(true);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv,txt|max:5120',
        ],[
            'file.required' => 'El archivo es requerido.',
            'file.mimes' => 'El archivo debe ser un Excel (.xlsx, .xls) o CSV (.csv).',
        ]);

        try {
            \Maatwebsite\Excel\Facades\Excel::import(new \App\Imports\JuntasImport, $request->file('file'));
            return redirect()->route('juntas.index')->with('success', 'Juntas importadas exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('juntas.index')->with('error', 'Error al importar los datos: ' . $e->getMessage());
        }
    }
}
