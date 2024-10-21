<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MunicipioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('municipios')->insert([
            ['codigo' => '54051', 'nombre_municipio' => 'ARBOLEDAS', 'codigo_dpto' => '54'],
            ['codigo' => '54223', 'nombre_municipio' => 'CUCUTILLA', 'codigo_dpto' => '54'],
            ['codigo' => '54313', 'nombre_municipio' => 'GRAMALOTE', 'codigo_dpto' => '54'],
            ['codigo' => '54418', 'nombre_municipio' => 'LOURDES', 'codigo_dpto' => '54'],
            ['codigo' => '54660', 'nombre_municipio' => 'SALAZAR', 'codigo_dpto' => '54'],
            ['codigo' => '54680', 'nombre_municipio' => 'SANTIAGO', 'codigo_dpto' => '54'],
            ['codigo' => '54871', 'nombre_municipio' => 'VILLA CARO', 'codigo_dpto' => '54'],
            ['codigo' => '54109', 'nombre_municipio' => 'BUCARASICA', 'codigo_dpto' => '54'],
            ['codigo' => '54250', 'nombre_municipio' => 'EL TARRA', 'codigo_dpto' => '54'],
            ['codigo' => '54720', 'nombre_municipio' => 'SARDINATA', 'codigo_dpto' => '54'],
            ['codigo' => '54810', 'nombre_municipio' => 'TIBÚ', 'codigo_dpto' => '54'],
            ['codigo' => '54003', 'nombre_municipio' => 'ABREGO', 'codigo_dpto' => '54'],
            ['codigo' => '54128', 'nombre_municipio' => 'CACHIRÁ', 'codigo_dpto' => '54'],
            ['codigo' => '54206', 'nombre_municipio' => 'CONVENCIÓN', 'codigo_dpto' => '54'],
            ['codigo' => '54245', 'nombre_municipio' => 'EL CARMEN', 'codigo_dpto' => '54'],
            ['codigo' => '54344', 'nombre_municipio' => 'HACARÍ', 'codigo_dpto' => '54'],
            ['codigo' => '54385', 'nombre_municipio' => 'LA ESPERANZA', 'codigo_dpto' => '54'],
            ['codigo' => '54398', 'nombre_municipio' => 'LA PLAYA', 'codigo_dpto' => '54'],
            ['codigo' => '54498', 'nombre_municipio' => 'OCAÑA', 'codigo_dpto' => '54'],
            ['codigo' => '54670', 'nombre_municipio' => 'SAN CALIXTO', 'codigo_dpto' => '54'],
            ['codigo' => '54800', 'nombre_municipio' => 'TEORAMA', 'codigo_dpto' => '54'],
            ['codigo' => '54001', 'nombre_municipio' => 'CÚCUTA', 'codigo_dpto' => '54'],
            ['codigo' => '54261', 'nombre_municipio' => 'EL ZULIA', 'codigo_dpto' => '54'],
            ['codigo' => '54405', 'nombre_municipio' => 'LOS PATIOS', 'codigo_dpto' => '54'],
            ['codigo' => '54553', 'nombre_municipio' => 'PUERTO SANTANDER', 'codigo_dpto' => '54'],
            ['codigo' => '54673', 'nombre_municipio' => 'SAN CAYETANO', 'codigo_dpto' => '54'],
            ['codigo' => '54874', 'nombre_municipio' => 'VILLA DEL ROSARIO', 'codigo_dpto' => '54'],
            ['codigo' => '54125', 'nombre_municipio' => 'CÁCOTA', 'codigo_dpto' => '54'],
            ['codigo' => '54174', 'nombre_municipio' => 'CHITAGÁ', 'codigo_dpto' => '54'],
            ['codigo' => '54480', 'nombre_municipio' => 'MUTISCUA', 'codigo_dpto' => '54'],
            ['codigo' => '54518', 'nombre_municipio' => 'PAMPLONA', 'codigo_dpto' => '54'],
            ['codigo' => '54520', 'nombre_municipio' => 'PAMPLONITA', 'codigo_dpto' => '54'],
            ['codigo' => '54743', 'nombre_municipio' => 'SILOS', 'codigo_dpto' => '54'],
            ['codigo' => '54099', 'nombre_municipio' => 'BOCHALEMA', 'codigo_dpto' => '54'],
            ['codigo' => '54172', 'nombre_municipio' => 'CHINÁCOTA', 'codigo_dpto' => '54'],
            ['codigo' => '54239', 'nombre_municipio' => 'DURANIA', 'codigo_dpto' => '54'],
            ['codigo' => '54347', 'nombre_municipio' => 'HERRÁN', 'codigo_dpto' => '54'],
            ['codigo' => '54377', 'nombre_municipio' => 'LABATECA', 'codigo_dpto' => '54'],
            ['codigo' => '54599', 'nombre_municipio' => 'RAGONVALIA', 'codigo_dpto' => '54'],
            ['codigo' => '54820', 'nombre_municipio' => 'TOLEDO', 'codigo_dpto' => '54'],
        ]);
    }
}
