<?php

namespace App\Http\Controllers;

use App\Models\Asociacion;
use App\Models\Funcionario;
use App\Models\Comuna;
use App\Models\Municipio;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\AsociacionesImport;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;

class AsociacionController extends Controller
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
        $asociaciones = Asociacion::with(['presidente', 'municipio'])
            ->when($search, function ($query, $search) {
                $query->where('asociaciones.nombre', 'like', "%{$search}%")
                    ->orWhereHas('presidente', function ($query) use ($search) {
                        $query->where('nombre', 'like', "%{$search}%")
                              ->orWhere('num_documento', 'like', "%{$search}%");
                    })
                    ->orWhereHas('municipio', function ($query) use ($search) {
                        $query->where('nombre_municipio', 'like', "%{$search}%");
                    })
                    ->orWhere('asociaciones.resolucion', 'like', "%{$search}%");
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
            'fecha_resolucion' => 'nullable|date',
            'res_personeria_juridica' => 'nullable|string|max:255',
            'fecha_res_personeria_juridica' => 'nullable|date',
            'fecha_eleccion' => 'nullable|date',
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

        if (!empty($funcionarios)) {
            // Consulta si alguno ya está asignado en otra asociación
            $existe = Asociacion::where(function ($query) use ($funcionarios) {
                $query->whereIn('presidente_id', $funcionarios)
                      ->orWhereIn('vicepresidente_id', $funcionarios)
                      ->orWhereIn('secretario_id', $funcionarios)
                      ->orWhereIn('tesorero_id', $funcionarios)
                      ->orWhereIn('fiscal_id', $funcionarios);
            })->exists();

            if ($existe) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['funcionario' => 'Uno o más funcionarios ya están asignados en otra Asociación.']);
            }
        }

        Asociacion::create($request->all());
        return redirect()->route('asociaciones.index')->with('success', 'Asociación creada exitosamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Asociacion  $asociacion
     * @return \Illuminate\Http\Response
     */
    public function show(Asociacion $asociacion)
    {
        return view('asociaciones.show', compact('asociacion'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Asociacion  $asociacion
     * @return \Illuminate\Http\Response
     */
    public function edit(Asociacion $asociacion)
    {
        $funcionarios = Funcionario::all();
        $comunas = Comuna::all();
        $municipios = Municipio::all();
        $asociacion->load(['documentos', 'comisiones', 'autos', 'carpetas']);
        return view('asociaciones.edit', compact('asociacion', 'funcionarios', 'comunas', 'municipios'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Asociacion  $asociacion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Asociacion $asociacion)
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
            'fecha_resolucion' => 'nullable|date',
            'res_personeria_juridica' => 'nullable|string|max:255',
            'fecha_res_personeria_juridica' => 'nullable|date',
            'fecha_eleccion' => 'nullable|date',
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

        $funcionarios = array_filter($funcionarios);

        if (!empty($funcionarios)) {
            $existe = Asociacion::where('id', '!=', $asociacion->id)
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
                    ->withErrors(['funcionario' => 'Uno o más funcionarios ya están asignados en otra Asociación.']);
            }
        }

        $asociacion->update($request->all());
        return redirect()->route('asociaciones.index')->with('success', 'Asociación actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Asociacion  $asociacion
     * @return \Illuminate\Http\Response
     */
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
        $municipioId = $request->input('municipio_id');

        $query = Asociacion::with([
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
            $filename = 'asociaciones_' . Str::slug($municipio->nombre_municipio ?? 'municipio') . '.xlsx';
        } else {
            $filename = 'asociaciones_todos_los_municipios.xlsx';
        }

        $asociaciones = $query->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Encabezados completos: Asociación y Dignatarios
        $headers = [
            'Municipio',
            'Comuna',
            'Razón Social',
            'Resolución',
            'Fecha Resolución',
            'Personería Jurídica',
            'Res. Personería Jurídica',
            'Fecha Res. Personería Jurídica',
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

        foreach ($asociaciones as $asociacion) {
            $comisionados = $asociacion->comisiones->isNotEmpty()
                ? $asociacion->comisiones->map(function ($c) {
                    return "{$c->nomcomision}: {$c->nomcomisionado} ({$c->doccomisionado})";
                })->implode(' | ')
                : '';

            $rows[] = array_merge(
                [
                    $asociacion->municipio->nombre_municipio ?? 'N/A',
                    $asociacion->comuna->nombre_comuna ?? '',
                    $asociacion->nombre ?? '',
                    $asociacion->resolucion ?? '',
                    $asociacion->fecha_resolucion ?? '',
                    $asociacion->personeria ?? '',
                    $asociacion->res_personeria_juridica ?? '',
                    $asociacion->fecha_res_personeria_juridica ?? '',
                    $asociacion->tipo_oac ?? '',
                    $asociacion->zona ?? '',
                    $asociacion->fecha_eleccion ?? '',
                    $asociacion->fecha_inicio_periodo ?? '',
                    $asociacion->fecha_final_periodo ?? '',
                    $asociacion->auto_numero ?? '',
                    $asociacion->tipo_auto ?? '',
                    $asociacion->fecha_auto ?? '',
                ],
                $extractDignatario($asociacion->presidente),
                $extractDignatario($asociacion->vicepresidente),
                $extractDignatario($asociacion->secretario),
                $extractDignatario($asociacion->tesorero),
                $extractDignatario($asociacion->fiscal),
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
        ], [
            'file.required' => 'El archivo es requerido.',
            'file.mimes' => 'El archivo debe ser un Excel (.xlsx, .xls) o CSV (.csv).',
        ]);

        try {
            Excel::import(new AsociacionesImport, $request->file('file'));
            return redirect()->route('asociaciones.index')->with('success', 'Asociaciones importadas exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('asociaciones.index')->with('error', 'Error al importar los datos: ' . $e->getMessage());
        }
    }

    public function plantilla()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $headers = [
            'MUNICIPIO',
            'AUTO No.',
            'TIPO AUTO',
            'FECHA AUTO',
            'FECHA ELECCION',
            'FECHA INICIO PERIODO',
            'FECHA FINAL PERIODO',
            'NOMBRE O.A.C.',
            'PERSONERIA JURIDICA No.',
            'RES. PERSONERIA JURIDICA No.',
            'FECHA RES. PERSONERIA JURIDICA',
            'TIPO O.A.C.',
            'ZONA',
            '# DOCUMENTO PRESIDENTE',
            '# DOCUMENTO VICEPRESIDENTE',
            '# DOCUMENTO SECRETARIO',
            '# DOCUMENTO TESORERO',
            '# DOCUMENTO FISCAL'
        ];

        $exampleRow = [
            'ABREGO',
            '1001',
            'AUTO RECONOCIMIENTO',
            '2026-06-23',
            '2026-04-26',
            '2026-07-01',
            '2030-06-30',
            'ASOCIACION DE JUNTAS DE ACCION COMUNAL DE ABREGO - ASOCOMUNAL',
            '001/2000-I-15',
            '123/2026',
            '2026-05-10',
            'ASOCOMUNAL',
            'URBANA',
            '5415783',
            '13141346',
            '37333479',
            '13140780',
            '1094573830'
        ];

        $sheet->fromArray([$headers, $exampleRow], null, 'A1');

        $highestColumn = $sheet->getHighestDataColumn();
        $sheet->getStyle("A1:{$highestColumn}1")->getFont()->setBold(true);
        $sheet->getStyle("A1:{$highestColumn}1")->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFEFEFEF');
        $sheet->freezePane('A2');

        $highestColumnIndex = Coordinate::columnIndexFromString($highestColumn);
        for ($col = 1; $col <= $highestColumnIndex; $col++) {
            $sheet->getColumnDimensionByColumn($col)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);
        $tempFile = tempnam(sys_get_temp_dir(), 'plantilla_asociaciones');
        $writer->save($tempFile);

        return response()->download($tempFile, 'plantilla_asociaciones.xlsx')->deleteFileAfterSend(true);
    }
}
