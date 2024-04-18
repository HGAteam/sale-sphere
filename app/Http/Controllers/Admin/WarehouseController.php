<?php

namespace App\Http\Controllers\Admin;

use App\Exports\WarehousesExport;
use App\Http\Controllers\Controller;
use App\Imports\WarehousesImport;
use App\Models\Product;
use App\Models\Stock;
use App\Models\Warehouse;
use App\Models\ProductMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;
use Maatwebsite\Excel\Facades\Excel;
use DataTables;
use Carbon\Carbon;
use Str;
use Log;

class WarehouseController extends Controller
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
            ['url' => '#', 'label' => trans('Warehouses')],
        ];

        return view('pages.admin.warehouses.index',compact('breadcrumb'));
    }
    public function data()
    {
        if(Auth::user()->role == 'Admin'){
            $warehouseArray = Warehouse::orderBy('id','Desc')->get();
        }else{
            $warehouseArray = Warehouse::where('deleted_at', null)->orderBy('id','Desc')->get();
        }

        $warehouses = [];

        foreach ($warehouseArray as $value) {
            $data['id'] = $value->id;
            $data['name'] = $value->name;
            $data['slug'] = $value->slug;
            $data['location'] = $value->location;
            $data['address'] = $value->address;
            $data['status'] = $value->status;
            $data['branch_manager'] = $value->branch_manager;
            $data['phone'] = $value->phone;
            $data['mobile'] = $value->mobile;
            $data['details'] = $value->details;
            $data['cashiers'] = $value->cashiers;
            $data['created_at'] = Carbon::parse($value->created_at)->locale('es')->isoFormat('DD/MM/YYYY');
            $warehouses[] = $data;
        }

        return Datatables::of($warehouses)->make(true);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {

            $warehouse = new Warehouse();
            $warehouse->name = $request->name;
            $warehouse->slug = Str::slug($request->name);
            $warehouse->location = $request->location;
            $warehouse->address = $request->address;
            $warehouse->status = $request->status;
            $warehouse->branch_manager = $request->branch_manager;
            $warehouse->phone = $request->phone;
            $warehouse->mobile = $request->mobile;
            $warehouse->cashiers = $request->cashiers;
            $warehouse->details =$request->details;

            $warehouse->save();

            return response()->json(['message' => trans('Warehouse successfully created')], 200);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->validator->errors()->toArray()], 422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $warehouse = Warehouse::find($id);

        $stock = Stock::where('warehouse_id', $id)->where('status', 'To Enter Stock')->first();
        $added_products = Stock::where('warehouse_id', $id)->pluck('product_id')->toArray();
        // Obtener la lista completa de productos
        $all_products = Product::orderBy('name', 'ASC')->get();
        // Filtrar los productos que ya están en stock
        $available_products = $all_products->reject(function ($product) use ($added_products) {
            return in_array($product->id, $added_products);
        });


        $breadcrumb = [
            ['url' => '/home', 'label' => trans('Home')],
            ['url' => '/home/warehouses', 'label' => trans('Warehouses')],
            ['url' => '#', 'label' => $warehouse->name],
        ];

        return view('pages.admin.warehouses.show',compact('breadcrumb','warehouse','available_products','stock'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $warehouse = Warehouse::findOrFail($id);

        return response()->json($warehouse);
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
        try {
            // Obtener el usuario existente
            $warehouse = Warehouse::findOrFail($id);

            // Actualizar los campos del usuario
            $warehouse->name = $request->edit_name;
            $warehouse->slug = Str::slug($request->edit_name);
            $warehouse->location = $request->edit_location;
            $warehouse->address = $request->edit_address;
            $warehouse->status = $request->edit_status;
            $warehouse->branch_manager = $request->edit_branch_manager;
            $warehouse->phone = $request->edit_phone;
            $warehouse->mobile = $request->edit_mobile;
            $warehouse->cashiers =$request->edit_cashiers;
            $warehouse->details =$request->edit_details;
            // Guardar los cambios en la base de datos
            $warehouse->save();

            return response()->json(['message' => trans('User successfully updated')], 200);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->validator->errors()->toArray()], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   // Método en el controlador para eliminar el almacén
    public function destroy($id)
    {
        $warehouse = Warehouse::findOrFail($id);
        $warehouse->update([
            'status' => 0,
            'deleted_at' => now(),
        ]);
        return response()->json(['message' => trans('Warehouse marked as inactive.')]);
    }

    // Método en el controlador para restaurar el almacén
    public function restore($id)
    {
        $warehouse = Warehouse::findOrFail($id);
        $warehouse->update([
            'status' => 1,
            'deleted_at' => null,
        ]);
        return response()->json(['message' => trans('Warehouse restored.')]);
    }

    public function getProducts($id){
        $query = Stock::query();

        if (Auth::user()->role !== 'Admin') {
            $query->whereNull('deleted_at');
        }

        $stockArray = $query->where('warehouse_id',$id)->orderBy('id', 'desc')->get();

        $stocks = [];

        foreach ($stockArray as $value) {
            $data['id'] = $value->id;
            $data['product_id'] = $value->product->id;
            $data['warehouse_id'] = $value->warehouse->id;
            $data['name'] = $value->product->name;
            $data['image'] = $value->product->image;
            $data['brand'] = $value->product->brand->name;
            $data['category'] = $value->product->category->name;
            $data['barcode'] = $value->product->barcode;
            $data['description'] = $value->product->description;
            $data['status'] = $value->status;
            $data['purchase_price'] = $value->product->purchase_price;
            $data['selling_price'] = $value->product->selling_price;
            $data['wholesale_price'] = $value->product->wholesale_price;
            $data['quantity'] = $value->quantity;
            $data['unit'] = $value->product->unit;
            $data['updated_at'] = Carbon::parse($value->updated_at)->locale('es')->isoFormat('DD/MM/YYYY');
            $stocks[] = $data;
        }

        return Datatables::of($stocks)->make(true);
    }

    public function addProductsToWarehouse(Request $request, $id) {
        try {
            // Validar la solicitud
            $request->validate([
                'add_products' => 'required|array',
            ]);

            // Obtener el almacén
            $warehouse = Warehouse::findOrFail($id);

            // Obtener los productos ya agregados a este almacén
            $addedProducts = Stock::where('warehouse_id', $id)->pluck('product_id')->toArray();

            // Filtrar los productos que ya están en stock
            $newProducts = $request->has('add_products') ? array_diff($request->input('add_products'), $addedProducts) : [];

            // Agregar los nuevos productos al stock para la sucursal específica
            foreach ($newProducts as $productId) {
                // Log::info('Valor de $id:', ['id' => $id]);
                $stock = new Stock();
                $stock->warehouse_id = $id;
                $stock->product_id = $productId;
                $stock->status = 'Empty';
                $stock->save();
            }

            // Agrega un log para verificar los datos
            // Log::info('Datos del formulario:', $request->all());

            return response()->json(['message' => 'Productos agregados correctamente.'], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Almacén no encontrado.'], 404);
        } catch (ValidationException $e) {
            // Devolver errores de validación específicos
            return response()->json(['error' => $e->validator->errors()->first()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al agregar productos. Detalles: ' . $e->getMessage()], 500);
        }
    }

    public function getQuantityProduct($id,$product_id) {
        $product = Product::find($product_id);
        if ($product) {
            $quantity = $product->quantity;
            return response()->json(['quantity' => $quantity]);
        } else {
            return response()->json(['error' => 'El producto no existe'], 404);
        }
    }

    public function increaseQuantity(Request $request, $id, $product_id)
    {
        try {
            // Validar la solicitud antes de procesarla
            $request->validate([
                'quantity_to_add' => 'required|integer|min:1', // La cantidad debe ser un número entero positivo
            ]);

            // Obtener el stock
            $stock = Stock::where('warehouse_id', $id)->where('product_id', $product_id)->first();

            if (!$stock) {
                throw new \Exception('El stock no fue encontrado para el almacén y producto especificados.');
            }

            // Verificar si la cantidad a agregar es mayor que la cantidad disponible en el stock principal
            $product = $stock->product;
            if ($request->quantity_to_add > $product->quantity) {
                throw new \Exception('No hay suficientes existencias disponibles en el stock principal para agregar la cantidad especificada.');
            }

            // Verificar si la cantidad ingresada es 0 o nula
            if ($request->quantity_to_add === null || $request->quantity_to_add === 0) {
                throw new \Exception('La cantidad ingresada no puede ser nula o igual a 0.');
            }

            // Incrementar la cantidad
            $stock->quantity += $request->quantity_to_add;
            $stock->status = 'To Enter Stock';
            $stock->save();

            // Reducir la cantidad en el stock principal
            $product->quantity -= $request->quantity_to_add;
            $product->status = 'In Process';
            $product->save();

            $product_movement = new ProductMovement();
            $product_movement->product_id = $product_id;
            $product_movement->user_id = Auth::user()->id;
            $product_movement->quantity = $request->quantity_to_add;
            $product_movement->action = 'Stock Transfer';
            $product_movement->details = $product_movement->action.' from: Main Stock '.'to '.$stock->warehouse->name.' stock' ;
            $product_movement->save();


            return response()->json(['message' => trans('Se ha incrementado la cantidad para: ').$product->name . ' en ' . trans('almacén: '). $stock->warehouse->name], 200);
        } catch (ValidationException $validationException) {
            // Manejar errores de validación
            $errors = $validationException->validator->errors()->all();
            return response()->json(['error' => $errors], 422);
        } catch (\Exception $e) {
            // Capturar otras excepciones y proporcionar un mensaje genérico
            return response()->json(['error' => 'Ha ocurrido un error: ' . $e->getMessage()], 500);
        }
    }

    public function getValidationStock($id){
       $products = Stock::where('warehouse_id',$id)->where('status','To Enter Stock')->with('product')->get();
       return response()->json(['products' => $products], 200);
    }

    public function processValidation($id, Request $request)
    {
        try {
            // Buscar el producto correspondiente al ID y código de barras proporcionados
            $product = Product::where('id', $request->product_id)->where('barcode', $request->barcode)->first();

            if ($product) {
                // Obtener el stock del producto en la sucursal
                $stock = Stock::where('warehouse_id', $id)->where('product_id', $request->product_id)->first();
                // Actualizar el estado del producto a "In Stock"
                $stock->status = 'In Stock';
                $stock->save();

                if($product->quantity == 0){
                    $product->status = 'Processed';
                    $product->save();
                }

                return response()->json(['message' => 'Producto Validado con éxito'], 200);
                }

                return response()->json(['error' => 'El código ingresado no es correcto.'], 404);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Hubo un error al procesar la validación: ' . $th->getMessage()], 422);
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
            $import = new WarehousesImport;
            Excel::import($import, $file);

            // Verificar si hay warehouses duplicados
            $duplicates = $import->getDuplicates();

            if (!empty($duplicates)) {
                return response()->json([
                    'error' => 'Error durante la importación: Algunos sucursales ya existen en el listado.',
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
                $errorMessage = 'Error durante la importación: Ya existe una sucursal duplicada en el listado.';
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
        return Excel::download(new WarehousesExport, 'warehouses.xlsx');
    }
}
