<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tutor>
 */
class TutorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

            $firstName = $this->faker->firstName();
            $lastName1 = $this->faker->lastName();
            $lastName2 = $this->faker->lastName();
            $dob = $this->faker->date('Y-m-d'); // Fecha de nacimiento
            $sex = $this->faker->randomElement(['H', 'M']); // Sexo: H (Hombre) o M (Mujer)
            $state = $this->faker->randomElement([
                'AS', 'BS', 'CS', 'CL', 'DF', 'GT', 'HG', 'JC', 'MC', 'MN', 'MS', 'NT', 'NL', 'OC', 'PL', 'QR', 'SP', 'SL', 'SR', 'TC', 'TS', 'TL', 'YN', 'ZS'
            ]); // Estado de nacimiento

            // Extracción de los apellidos y nombre para el CURP
            $apellido1 = strtoupper(substr($lastName1, 0, 2)); // Primeras dos letras del primer apellido
            $apellido2 = strtoupper(substr($lastName2, 0, 1)); // Primera letra del segundo apellido
            $primerNombre = strtoupper(substr($firstName, 0, 1)); // Primera letra del primer nombre

            // Fecha de nacimiento en formato AA/MM/DD
            $fechaNacimiento = str_replace("-", "", substr($dob, 2, 8)); // Eliminar guiones

            // Generar la homoclave (tres caracteres aleatorios)
            $homoclave = strtoupper($this->faker->lexify('?????')); // Tres letras aleatorias

            // Formar el CURP completo (18 caracteres)
            $curp = $apellido1 . $apellido2 . $primerNombre . $fechaNacimiento . $sex . $state . $homoclave;

            // Asegurarse que el CURP tenga exactamente 18 caracteres
            $curp = substr($curp, 0, 18);


            return [
                'curp' => $curp,
                'nombre' => $this->faker->firstName(),
                'apellidoP' => $this->faker->lastName(),
                'apellidoM' => $this->faker->lastName(),
                'calle' => $this->faker->address(),
                'exterior' => $this->faker->numberBetween(000,1000),
                'interior' => $this->faker->numberBetween(000,1000),
                'localidad' => $this->faker->city(),
                'colonia' => $this->faker->citySuffix(),
                'cp' => $this->faker->postcode(),
                'municipio' => $this->faker->cityPrefix(),
                'estado' => $this->faker->state(),
                'telefono' => $this->faker->phoneNumber(),
                'celular' => $this->faker->phoneNumber(),
                'email' => $this->faker->email(),
                'parentesco' => $this->faker->randomElement(['Padre', 'Madre', 'Tutor']),
                'ocupacion' => $this->faker->randomElement(['Estudiante', 'Empleado', 'Empresario', 'Otro']),
                //  Student::all()->random()->id // Relación con la tabla de estudiantes (students)
           ];
    }
}
