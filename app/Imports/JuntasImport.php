<?php

namespace App\Imports;

use App\Models\Junta;
use App\Models\Municipio;
use App\Models\Funcionario;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;

class JuntasImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $municipioName = $row['municipio'] ?? null;
        
        if (!$municipioName) {
            return null; 
        }

        $municipio = Municipio::where('nombre_municipio', 'like', '%' . $municipioName . '%')->first();
        if (!$municipio) {
            return null; 
        }

        $parseDate = function($value) {
            if (!$value) return null;
            try {
                if (is_numeric($value)) {
                    return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value)->format('Y-m-d');
                }
                return Carbon::parse($value)->format('Y-m-d');
            } catch (\Exception $e) {
                return null;
            }
        };

        $getFuncionarioId = function($docNumber) {
            if (!$docNumber) return null;
            $funcionario = Funcionario::where('num_documento', $docNumber)->first();
            return $funcionario ? $funcionario->id : null;
        };

        $nombre = $row['nombre_o_a_c'] ?? $row['nombre_oac'] ?? 'S/N';
        
        return new Junta([
            'nombre' => $nombre,
            'fecha_eleccion' => $parseDate($row['fecha_eleccion'] ?? null),
            'presidente_id' => $getFuncionarioId($row['documento_presidente'] ?? null),
            'vicepresidente_id' => $getFuncionarioId($row['documento_vicepresidente'] ?? null),
            'secretario_id' => $getFuncionarioId($row['documento_secretario'] ?? null),
            'tesorero_id' => $getFuncionarioId($row['documento_tesorero'] ?? null),
            'fiscal_id' => $getFuncionarioId($row['documento_fiscal'] ?? null),
            'municipio_id' => $municipio->id,
            'personeria' => $row['personeria_juridica_no'] ?? null,
            'auto_numero' => $row['auto_no'] ?? null,
            'tipo_auto' => $row['tipo_auto'] ?? null,
            'fecha_auto' => $parseDate($row['fecha_auto'] ?? null),
            'fecha_inicio_periodo' => $parseDate($row['fecha_inicio_periodo'] ?? null),
            'fecha_final_periodo' => $parseDate($row['fecha_final_periodo'] ?? null),
            'tipo_oac' => $row['tipo_o_a_c'] ?? $row['tipo_oac'] ?? null,
            'zona' => $row['zona'] ?? null,
        ]);
    }
}
