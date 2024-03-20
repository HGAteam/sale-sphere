<?php

namespace App\Exports;

use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Illuminate\Support\Facades\File;
class ProductExport implements FromCollection, WithMultipleSheets
{
    public function collection()
    {
        // Obtener productos con relaciones
        $products = Product::with(['brand', 'category'])->get();

        // Mapear datos para incluir información relacionada
        $mappedData = $products->map(function ($product) {
            return [
                'ID' => $product->id,
                'Name' => $product->name,
                'Brand' => $product->brand->name,
                'Category' => $product->category->name,
                'Purchase Price' => $product->purchase_price,
                'Selling Price' => $product->selling_price,
                'Wholesale Price' => $product->wholesale_price,
                'Quantity' => $product->quantity,
                'Unit' => trans("{$product->unit}"),
                'Status' => trans("{$product->status}"),
            ];
        });

        return $mappedData;
    }

    public function sheets(): array
    {
        $sheets = [];

        // Hoja principal con productos (usando la colección mapeada)
        $sheets[] = new ProductsSheet($this->collection());

        // Otras hojas con relaciones
        $sheets[] = new BrandsSheet();
        $sheets[] = new CategoriesSheet();

        return $sheets;
    }
}

class ProductsSheet implements FromCollection, WithHeadings, WithTitle
{
    protected $data;

    public function __construct(Collection $data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data;
    }

    public function headings(): array
    {
        // Encabezados para la hoja de productos
        return [
            'ID',
            trans('Name'),
            trans('Brand'),
            trans('Category'),
            trans('Purchase Price'),
            trans('Selling Price'),
            trans('Wholesale Price'),
            trans('Quantity'),
            trans('Unit'),
            trans('Status')
        ];
    }

    public function title(): string
    {
        return 'Productos'; // Nombre que asignas a la hoja
    }
}

// Clases de hojas para otras relaciones
class BrandsSheet implements FromCollection, WithHeadings, WithTitle
{

    public function collection()
    {
       // Obtener marcas con relaciones y seleccionar solo los campos deseados
       $brands = Brand::select('id', 'name', 'slug', 'status', 'details')->get();

       // Traducir los valores de la columna 'status' usando el archivo JSON de traducciones
       $brands = $brands->map(function ($brand) {
           // Obtener el contenido del archivo JSON de traducciones
           $translations = json_decode(file_get_contents(resource_path('lang/es.json')), true);

           // Traducir el estado
           $brand->status = $translations[$brand->status] ?? $brand->status;

           return $brand;
       });

       return $brands;
    }

    public function headings(): array
    {
        // Encabezados para la hoja de marcas
        return [
            'ID',
            trans('Name'),
            trans('Slug'),
            trans('Status'),
            trans('Details'),
        ];
    }
    public function title(): string
    {
        return 'Marcas'; // Nombre que asignas a la hoja
    }
}

class CategoriesSheet implements FromCollection, WithHeadings, WithTitle
{
    public function collection()
    {
        // Obtener datos de la relación 'category'
        $categories = Category::select('id', 'name', 'slug', 'status', 'details')->get();
        $categories = $categories->map(function ($category) {
            // Obtener el contenido del archivo JSON de traducciones
            $translations = json_decode(file_get_contents(resource_path('lang/es.json')), true);

            // Traducir el estado
            $category->status = $translations[$category->status] ?? $category->status;

            return $category;
        });

        return $categories;
    }

    public function headings(): array
    {
        // Encabezados para la hoja de categorías
        return [
            'ID',
            trans('Name'),
            trans('Slug'),
            trans('Status'),
            trans('Details')
        ];
    }
    public function title(): string
    {
        return 'Categorias'; // Nombre que asignas a la hoja
    }
}
