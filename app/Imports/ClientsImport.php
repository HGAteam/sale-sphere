<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\Importable;
use App\Models\Client;
use Str;

class ClientsImport implements ToCollection
{
    use Importable;

    protected $importedClients = [];
    protected $duplicates = [];

    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            $clientData = [
                'name' => $row[0],
                'lastname' => $row[1],
                'email' => $row[2],
                'dni' => $row[3],
                'address' => $row[4],
                'location' => $row[5],
                'phone' => $row[6],
                'mobile' => $row[7],
                'details' => $row[8],
            ];

            // Validación de los datos
            $validator = Validator::make($clientData, [
                'name' => 'required|string',
                'lastname' => 'required|string',
                'dni' => 'required|string',
                'location' => 'required|string',
                'status' => 'required|string',
                'email' => 'required|email|unique:users,email',
            ]);

            if ($validator->fails()) {
                // Log de errores de validación
                // \Log::error('Error de validación en la importación: ' . $validator->errors()->first());
                continue;
            }

            // Verificar si el usuario ya existe
            $existingClient = Client::where('name', $row[0])->first();

            if ($existingClient) {
                $this->duplicates[] = $clientData;
            } else {
                // Generar el slug a partir del campo name
                $slug = Str::slug($row[0]);

                // Crear el producto
                Client::create([
                    'name' => $row[0],
                    'slug' => $slug,
                    'lastname' => $row[1],
                    'email' => $row[2],
                    'dni' => $row[3],
                    'address' => $row[4],
                    'location' => $row[5],
                    'phone' => $row[6],
                    'mobile' => $row[7],
                    'details' => $row[8],
                ]);

                // Agregar los datos del user al array de importación
                $this->importedClients[] = $clientData;
            }
        }
    }

    public function getDuplicates()
    {
        return $this->duplicates;
    }
}
