<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FuncionarioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nombre' => $this->faker->name,
            'tipo_documento' => $this->faker->randomElement(['DNI', 'Pasaporte', 'Cédula']),
            'num_documento' => $this->faker->unique()->numerify('##########'), // 10 dígitos aleatorios
            'num_afiliacion' => $this->faker->numerify('##########'), // Número de afiliación aleatorio
            'genero' => $this->faker->randomElement(['Masculino', 'Femenino']),
            'direccion' => $this->faker->address,
            'profesion' => $this->faker->jobTitle,
            'grupo_etnico' => $this->faker->randomElement(['Grupo 1', 'Grupo 2', 'Grupo 3']),
            'discapacidad' => $this->faker->boolean, // true o false aleatorio
            'name_anexo' => $this->faker->word,
            'key_anexo' => $this->faker->uuid,
            'email' => $this->faker->unique()->safeEmail,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
