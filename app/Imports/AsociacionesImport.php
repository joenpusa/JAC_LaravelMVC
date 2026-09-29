<?php

namespace App\Imports;

use App\Models\Asociacion;
use App\Models\Municipio;
use App\Models\Funcionario;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;

class AsociacionesImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $municipioName = isset($row['municipio']) ? trim((string)$row['municipio']) : null;
        
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
            $funcionario = Funcionario::where('num_documento', trim((string)$docNumber))->first();
            return $funcionario ? $funcionario->id : null;
        };

        $nombre = $row['nombre_o_a_c'] ?? $row['nombre_oac'] ?? $row['razon_social'] ?? $row['nombre'] ?? 'Asociación S/N';
        
        return new Asociacion([
            'nombre' => trim((string)$nombre),
            'fecha_eleccion' => $parseDate($row['fecha_eleccion'] ?? null),
            'presidente_id' => $getFuncionarioId($row['documento_presidente'] ?? $row['num_documento_presidente'] ?? null),
            'vicepresidente_id' => $getFuncionarioId($row['documento_vicepresidente'] ?? $row['num_documento_vicepresidente'] ?? null),
            'secretario_id' => $getFuncionarioId($row['documento_secretario'] ?? $row['num_documento_secretario'] ?? null),
            'tesorero_id' => $getFuncionarioId($row['documento_tesorero'] ?? $row['num_documento_tesorero'] ?? null),
            'fiscal_id' => $getFuncionarioId($row['documento_fiscal'] ?? $row['num_documento_fiscal'] ?? null),
            'municipio_id' => $municipio->id,
            'personeria' => $row['personeria_juridica_no'] ?? $row['personeria'] ?? null,
            'res_personeria_juridica' => $row['res_personeria_juridica'] ?? $row['res_personeria_juridica_no'] ?? null,
            'fecha_res_personeria_juridica' => $parseDate($row['fecha_res_personeria_juridica'] ?? null),
            'auto_numero' => $row['auto_no'] ?? $row['auto_numero'] ?? null,
            'tipo_auto' => $row['tipo_auto'] ?? null,
            'fecha_auto' => $parseDate($row['fecha_auto'] ?? null),
            'fecha_inicio_periodo' => $parseDate($row['fecha_inicio_periodo'] ?? null),
            'fecha_final_periodo' => $parseDate($row['fecha_final_periodo'] ?? null),
            'tipo_oac' => $row['tipo_o_a_c'] ?? $row['tipo_oac'] ?? 'ASOCOMUNAL',
            'zona' => $row['zona'] ?? null,
        ]);
    }
}
