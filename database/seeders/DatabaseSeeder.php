<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $adminRole = Role::firstOrCreate(['name' => 'administrador']);
        $funcionarioRole = Role::firstOrCreate(['name' => 'funcionario']);

        User::firstOrCreate(
            ['email' => 'tic@nortedesantander.gov.co'],
            [
                'name' => 'Administrador Base',
                'password' => Hash::make('Gobernacion2024'),
                'role_id' => $adminRole->id
            ]
        );

        $this->call(DepartamentoSeeder::class);
        $this->call(MunicipioSeeder::class);
    }
}
