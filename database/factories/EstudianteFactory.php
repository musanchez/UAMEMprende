<?php

namespace Database\Factories;

use App\Models\Estudiante;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class EstudianteFactory extends Factory
{
    protected $model = Estudiante::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'cif' => $this->faker->unique()->regexify('[A-Z0-9]{10}'),
            'nombre' => $this->faker->firstName,
            'apellido' => $this->faker->lastName,
            'celular' => $this->faker->phoneNumber,
            'status' => true, // Opcionalmente puedes ajustar el valor de 'status'
            'email' => $this->faker->unique()->safeEmail,
            'password' => Hash::make('password'), // Establece la contraseña predeterminada
            'carrera_id' => 1, // Ajusta según el ID de la carrera correspondiente
            // No incluyas 'admin' aquí, ya que siempre será false
        ];
    }
}
