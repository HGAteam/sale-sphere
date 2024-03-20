<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\Importable;
use App\Models\Warehouse;
use Str;

class WarehousesImport implements ToCollection
{
    use Importable;

    protected $importedWarehouses = [];

    protected $duplicates = [];

    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            $warehouseData = [
                'name' => $row[0],
                'location' => $row[1],
                'address' => $row[2],
                'branch_manager' => $row[3],
                'phone' => $row[4],
                'mobile' => $row[5],
                'cashiers' => $row[6],
                'details' => $row[7],
            ];

            // Validación de los datos
            $validator = Validator::make($warehouseData, [
                'name' => 'required|string',
                'location' => 'required|string',
                'address' => 'required|string',
                'status' => 'required|string',
                'branch_manager' => 'required|string',
                'cashiers' => 'required|numeric|min:1',
            ]);

            if ($validator->fails()) {
                // Log de errores de validación
                // \Log::error('Error de validación en la importación: ' . $validator->errors()->first());
                continue;
            }

            // Verificar si el sucursal ya existe
            $existingWarehouse = Warehouse::where('name', $row[0])->first();

            if ($existingWarehouse) {
                $this->duplicates[] = $warehouseData;
            } else {
                // Generar el slug a partir del campo name
                $slug = Str::slug($row[0]);

                // Crear el producto
                Warehouse::create([
                    'name' => $row[0],
                    'slug' => $slug,
                    'location' => $row[1],
                    'address' => $row[2],
                    'branch_manager' => $row[3],
                    'phone' => $row[4],
                    'mobile' => $row[5],
                    'cashiers' => $row[6],
                    'details' => $row[7],
                ]);

                // Agregar los datos del user al array de importación
                $this->importedWarehouses[] = $warehouseData;
            }
        }
    }

    public function getDuplicates()
    {
        return $this->duplicates;
    }
}
