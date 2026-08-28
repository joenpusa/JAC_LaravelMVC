<?php

namespace App\Imports;

use App\Models\Funcionario;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class FuncionariosImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Avoid inserting if basic data is missing
        if (!isset($row['nombre']) || !isset($row['cedula'])) {
            return null;
        }

        // Check if exists to avoid unique constraint error
        $exists = Funcionario::where('num_documento', $row['cedula'])->first();
        if ($exists) {
            return null;
        }

        return new Funcionario([
            'nombre'         => $row['nombre'],
            'tipo_documento' => 'Cedula de Ciudadania',
            'num_documento'  => $row['cedula'],
            'telefono'       => $row['celular'] ?? null,
            'discapacidad'   => 0,
        ]);
    }
}
