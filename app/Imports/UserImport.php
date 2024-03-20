<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\Importable;
use App\Models\User;
use Str;

class UserImport implements ToCollection
{
    use Importable;

    protected $importedUsers = [];
    protected $duplicates = [];

    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            $userData = [
                'name' => $row[0],
                'lastname' => $row[1],
                'role' => $row[2],
                'phone' => $row[3],
                'mobile' => $row[4],
                'address' => $row[5],
                'location' => $row[6],
                'email' => $row[7],
            ];

            // Validación de los datos
            $validator = Validator::make($userData, [
                'name' => 'required|string',
                'lastname' => 'required|string',
                'role' => 'required|string',
                'status' => 'required|string',
                'email' => 'required|email|unique:users,email',
            ]);

            if ($validator->fails()) {
                // Log de errores de validación
                // \Log::error('Error de validación en la importación: ' . $validator->errors()->first());
                continue;
            }

            // Verificar si el usuario ya existe
            $existingUser = User::where('name', $row[0])->first();

            if ($existingUser) {
                $this->duplicates[] = $userData;
            } else {
                // Generar el slug a partir del campo name
                $slug = Str::slug($row[0]);

                // Crear el producto
                User::create([
                    'name' => $row[0],
                    'slug' => $slug,
                    'lastname' => $row[1],
                    'role' => $row[2],
                    'phone' => $row[3],
                    'mobile' => $row[4],
                    'address' => $row[5],
                    'location' => $row[6],
                    'email' => $row[7],
                    'password' => Hash::make($row[0].$row[1]),
                ]);

                // Agregar los datos del user al array de importación
                $this->importedUsers[] = $userData;
            }
        }
    }

    public function getDuplicates()
    {
        return $this->duplicates;
    }
}
