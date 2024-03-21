<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\Importable;
use App\Models\Product;
use Str;

class ProductsImport implements ToCollection
{
    use Importable;

    protected $importedProducts = [];
    protected $duplicates = [];

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $productData = [
                'name' => $row[0],
                'brand_id' => $row[1],
                'category_id' => $row[2],
                'barcode' => $row[3],
                'purchase_price' => $row[4],
                'selling_price' => $row[5],
                'wholesale_price' => $row[6],
                'quantity' => $row[7],
                'description' => $row[8],
            ];

            // Validación de los datos
            $validator = Validator::make($productData, [
                'name' => 'required|string',
                'brand_id' => 'required|numeric',
                'category_id' => 'required|numeric',
                'barcode' => 'required|numeric',
                'purchase_price' => 'required|numeric',
                'selling_price' => 'required|numeric',
                'wholesale_price' => 'required|numeric',
                'quantity' => 'required|numeric',
                'description' => 'required|string',
            ]);

            if ($validator->fails()) {
                // Log de errores de validación
                // \Log::error('Error de validación en la importación: ' . $validator->errors()->first());
                continue;
            }

            // Verificar si el producto ya existe
            $existingProduct = Product::where('name', $row[0])->first();

            if ($existingProduct) {
                $this->duplicates[] = $productData;
            } else {
                // Generar el slug a partir del campo name
                $slug = Str::slug($row[0]);

                // Determinar el estado del stock
                $status = $row[7] <= 0 ? 'Empty' : 'To Enter Stock';

                // Crear el producto
                Product::create([
                    'name' => $row[0],
                    'slug' => $slug,
                    'brand_id' => $row[1],
                    'category_id' => $row[2],
                    'barcode' => $row[3],
                    'purchase_price' => $row[4],
                    'selling_price' => $row[5],
                    'wholesale_price' => $row[6],
                    'quantity' => $row[7],
                    'description' => $row[8],
                    'status' => $status,
                ]);

                // Agregar los datos del producto al array de importación
                $this->importedProducts[] = $productData;
            }
        }
    }

    public function getDuplicates()
    {
        return $this->duplicates;
    }
}
