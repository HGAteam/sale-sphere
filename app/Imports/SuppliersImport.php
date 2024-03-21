<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\Importable;
use App\Models\Supplier;
use Str;

class SuppliersImport implements ToCollection
{
    use Importable;

    protected $importedSuppliers = [];
    protected $duplicates = [];

    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            $supplierData = [
                'social_reason' => $row[0],
                'contact' => $row[1],
                'email' => $row[2],
                'cuit' => $row[3],
                'address' => $row[4],
                'location' => $row[5],
                'phone' => $row[6],
                'mobile' => $row[7],
                'details' => $row[8],
            ];

            // Validación de los datos
            $validator = Validator::make($supplierData, [
                'social_reason' => 'required|string',
                'contact' => 'required|string',
                'cuit' => 'required|string',
                'address' => 'required|string',
                'location' => 'required|string',
                'email' => 'required|email|unique:users,email',
            ]);

            if ($validator->fails()) {
                // Log de errores de validación
                // \Log::error('Error de validación en la importación: ' . $validator->errors()->first());
                continue;
            }

            // Verificar si el usuario ya existe
            $existingSupplier = Supplier::where('name', $row[0])->first();

            if ($existingSupplier) {
                $this->duplicates[] = $supplierData;
            } else {
                // Generar el slug a partir del campo name
                $slug = Str::slug($row[0]);

                // Crear el producto
                Supplier::create([
                    'social_reason' => $row[0],
                    'slug' => $slug,
                    'contact' => $row[1],
                    'email' => $row[2],
                    'cuit' => $row[3],
                    'address' => $row[4],
                    'location' => $row[5],
                    'phone' => $row[6],
                    'mobile' => $row[7],
                    'details' => $row[8],
                ]);
                // Agregar los datos del user al array de importación
                $this->importedSuppliers[] = $supplierData;
            }
        }
    }

    public function getDuplicates()
    {
        return $this->duplicates;
    }
}
