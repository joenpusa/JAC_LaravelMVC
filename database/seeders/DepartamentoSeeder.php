<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('departamentos')->insert([
            ['codigo' => '54', 'nombre_dpto' => 'Norte de Santander', 'codigo_pais' => 'CO'],
        ]);
    }
}
