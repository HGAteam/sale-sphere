<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Stock;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\StoreProductRequest;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductImport;
use App\Exports\ProductExport;
use Illuminate\Http\Request;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use DataTables;
use File;
use Auth;
use Str;
use Log;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $breadcrumb = [
            ['url' => '/home', 'label' => trans('Home')],
            ['url' => '#', 'label' => trans('Products')],
        ];

        return view('pages.admin.products.index',compact('breadcrumb'));
    }

    public function data()
    {
        $query = Product::query();

        if (Auth::user()->role !== 'Admin') {
            $query->whereNull('deleted_at');
        }

        $productArray = $query->orderBy('id', 'desc')->get();
        $products = [];

        foreach ($productArray as $value) {
            // Obtener la información del stock asociado al producto
            // $stock = Stock::where('product_id', $value->id)->latest()->first();

            $data = [
                'id' => $value->id,
                'name' => $value->name,
                'image' => $value->image,
                'brand' => $value->brand->name,
                'category' => $value->category->name,
                'barcode' => $value->barcode,
                'description' => $value->description,
                'status' => $value->status, // Asumiendo que el estado se obtiene del stock
                'purchase_price' => $value->purchase_price,
                'selling_price' => $value->selling_price,
                'wholesale_price' => $value->wholesale_price,
                'quantity' => $value->quantity, // Asumiendo que la cantidad se obtiene del stock
                'unit' => $value->unit,
                'updated_at' => Carbon::parse($value->updated_at)->locale('es')->isoFormat('DD/MM/YYYY'),
            ];

            $products[] = $data;
        }

        return Datatables::of($products)->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $breadcrumb = [
            ['url' => '/home', 'label' => trans('Home')],
            ['url' => '/home/products', 'label' => trans('Products')],
            ['url' => '#', 'label' => trans('Add Product')],
        ];

        return view('pages.admin.products.create',compact('breadcrumb'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {
        try{
            $product = new Product();
            $product->name = $request->name;
            $product->slug = Str::slug($request->name);
            $product->brand_id = $request->brands;
            $product->category_id = $request->categories;
            $product->barcode = $request->barcode;
            $product->description = $request->description;

            if($request->hasFile('image')){
                $image = $request->file('image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $imagePath = public_path('images/products/') . $imageName;
                $image->move(public_path('images/products/'), $imageName);
                $resizedImagePath = 'images/products/' . $imageName;

                // Redimensionar y corregir la orientación de la imagen
                Image::make($imagePath)
                    ->resize(640, 640, function ($constraint) {
                        $constraint->aspectRatio(); // Mantener la proporción original
                    })
                    ->orientate() // Corregir la orientación
                    ->save(public_path($resizedImagePath));

                $product->image = $resizedImagePath;
            }

            $product->purchase_price = $request->purchase_price;
            $product->selling_price = $request->selling_price;
            $product->wholesale_price = $request->wholesale_price;
            $product->requires_returnable =  $request->has('returnable');
            $product->requires_stock =  $request->has('require_stock');
            $product->quantity = $request->quantity;
            $product->unit = $request->unit;
            $product->save();

            // if($request->require_stock == 1){
            //     $stock = new Stock();
            //     $stock->warehouse_id = $request->warehouses;
            //     if($request->quantity > 0 && $request->quantity < 10){
            //         $stock->status = 'Request Stock';
            //     }

            //     if($request->quantity == 0 || $request->quantity < 0){
            //         $stock->status = 'Out Stock';
            //     }

            //     if($request->quantity > 10){
            //         $stock->status = 'In Stock';
            //     }
            //     $stock->quantity = $request->quantity;
            //     $stock->save();
            // }

            return response()->json(['message' => trans('Product successfully created')], 200);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->validator->errors()->toArray()], 422);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        return response()->json($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try{
            $product = Product::findOrFail($id);

            if ($request->file('edit_image')) {
                // Borrar la imagen anterior si existe
                if ($product->image && $product->image != null && $request->file('edit_image') != '') {
                    $oldImagePath = public_path($product->image);
                    if (File::exists($oldImagePath)) {
                        File::delete($oldImagePath);
                    }
                }
            }

            $product->name = $request->edit_name;
            $product->slug = Str::slug($request->edit_name);
            $product->brand_id = $request->edit_brands;
            $product->category_id = $request->edit_categories;
            $product->barcode = $request->edit_barcode;
            $product->description = $request->edit_description;

            if($request->file('edit_image')){
                $image = $request->file('edit_image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $imagePath = public_path('images/products/') . $imageName;
                $image->move(public_path('images/products/'), $imageName);
                $resizedImagePath = 'images/products/' . $imageName;

                // Redimensionar y corregir la orientación de la imagen
                Image::make($imagePath)
                    ->resize(640, 640, function ($constraint) {
                        $constraint->aspectRatio();// Mantener la proporción original
                    })
                    ->orientate()// Corregir la orientación
                    ->save(public_path($resizedImagePath));

                $product->image = $resizedImagePath;
            }

            $product->purchase_price = $request->edit_purchase_price;
            $product->selling_price = $request->edit_selling_price;
            $product->wholesale_price = $request->edit_wholesale_price;
            $product->requires_returnable =  $request->has('edit_returnable');
            $product->requires_stock =  $request->has('edit_requires_stock');

            $product->quantity = $request->edit_quantity;
            $product->unit = $request->edit_unit;
            $product->save();

            return response()->json(['message' => trans('Product successfully updated')], 200);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->validator->errors()->toArray()], 422);
        }catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        try {
            $stock = Stock::wher('product_id',$id)->where('warehouse_id',$request->warehouse)->first();

            // Cambiar el estado a "Inactive" o "Deleted" según tu columna 'status'
            $stock->update([
                'status' => 'Deleted',
                'deleted_at' => now(), // Opcional, para establecer la marca de tiempo de eliminación
            ]);

             // Puedes devolver una respuesta JSON o redirigir a la página que desees
            return response()->json(['message' => trans('Product Deleted for').' '.$stock->warehouse->name.'.']);

        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->validator->errors()->toArray()], 422);
        }
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv',
        ]);

        try {
            $file = $request->file('file');

            // Importar el archivo CSV
            $import = new ProductImport;
            Excel::import($import, $file);

            // Verificar si hay productos duplicados
            $duplicates = $import->getDuplicates();

            if (!empty($duplicates)) {
                return response()->json([
                    'error' => 'Error durante la importación: Algunos productos ya existen en el listado.',
                    'duplicates' => $duplicates,
                ], 422);
            }

            return response()->json(['message' => 'Importación exitosa'], 200);
        } catch (\Maatwebsite\Excel\Exceptions\NoTypeDetectedException $e) {
            return response()->json(['error' => 'No se pudo detectar el tipo de archivo.'], 500);
        } catch (QueryException $e) {
            $errorCode = $e->getCode();

            // Código de error específico para la violación de la restricción UNIQUE
            if ($errorCode == '23000') {
                $errorMessage = 'Error durante la importación: Ya existen productos duplicados en el listado.';
                return response()->json(['error' => $errorMessage], 422);
            }

            // Log del error específico de la base de datos
            // Log::error('Error en la importación: ' . $e->getMessage());

            // Responder con el mensaje de error general
            return response()->json(['error' => 'Error durante la importación. Consulta los registros para más detalles.'], 500);
        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();

            // Log del error general
            // Log::error('Error durante la importación: ' . $errorMessage);

            // Responder con el mensaje de error general
            return response()->json(['error' => 'Error durante la importación. Consulta los registros para más detalles.'], 500);
        }
    }

    public function export(Request $requet){
        return Excel::download(new ProductExport, 'products.xlsx');
    }

    public function increaseQuantity(Request $request, $id)
    {
        // Validar la solicitud antes de procesarla
        $request->validate([
            'quantity_to_add' => 'required|integer|min:1', // La cantidad debe ser un número entero positivo
        ]);

        try {
            $product = Product::findOrFail($id);
            // if($product->quantity+$request->quantity > 0){
            //     $product->status = "To Enter Stock";
            // } else {
            //     $product->status = "To Enter Stock";
            // }
            $product->quantity = $product->quantity + $request->quantity_to_add;
            $product->save();

            return response()->json(['message' => trans('La cantidad se ha incrementado correctamente')], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function increaseProductPrice(Request $request)
    {
        try {
            // Obtener todos los productos o un producto específico según la selección del usuario
            if ($request->filled('from_product')) {
                // Si se proporciona un producto específico, actualizar solo ese producto
                $product = Product::findOrFail($request->from_product);

                // Verificar si el producto es encontrado antes de continuar
                if (!$product instanceof Product) {
                    return response()->json(['error' => trans('Producto no encontrado').'.'], 404);
                }

                // Aplicar el incremento en los precios según los valores proporcionados en la solicitud
                $this->applyIncreasePrice($product, 'purchase_price', $request->increase_purchase_price);
                $this->applyIncreasePrice($product, 'wholesale_price', $request->increase_wholesale_price);
                $this->applyIncreasePrice($product, 'selling_price', $request->increase_selling_price);

                // Guardar los cambios en el producto específico
                $product->save();

                return response()->json(['message' => trans('Precio del producto').' '.$product->name.' '.trans('actualizado correctamente.')], 200);
            } else {
                // Si no se proporciona un producto específico, actualizar todos los productos
                $products = Product::all();

                // Verificar y aplicar el incremento en los precios según los valores proporcionados en la solicitud
                foreach ($products as $product) {
                    $this->applyIncreasePrice($product, 'purchase_price', $request->increase_purchase_price);
                    $this->applyIncreasePrice($product, 'wholesale_price', $request->increase_wholesale_price);
                    $this->applyIncreasePrice($product, 'selling_price', $request->increase_selling_price);

                    // Guardar los cambios en cada producto
                    $product->save();
                }

                return response()->json(['message' => trans('Precios de todos los productos actualizados correctamente.')], 200);
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Producto no encontrado.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => trans('Error al actualizar los precios. Detalles:').' '. $e->getMessage()], 500);
        }
    }

    // Auxiliary function for applying the increment in a specific price field
    private function applyIncreasePrice($product, $field, $increase)
    {
        if ($increase && is_numeric($increase)) {
            $porcentaje = ($increase / 100) + 1;
            $product->{$field} *= $porcentaje;
        }
    }

}
