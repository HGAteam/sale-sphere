<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \App\Models\Customer;
use Carbon\Carbon;
use DataTables;
use Illuminate\Validation\ValidationException;
use Str;
use Auth;
use File;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Database\QueryException;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\CustomersImport;
use App\Exports\CustomersExport;

class CustomerController extends Controller
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
            ['url' => '#', 'label' => trans('Customers')],
        ];
        $customers = Customer::all()->count();

        return view('pages.admin.customers.index',compact('breadcrumb','customers'));
    }

    public function data()
    {
        $customerArray = Customer::all();
        $customers = [];

        foreach ($customerArray as $value) {
            $data['id'] = $value->id;
            $data['name'] = $value->name;
            $data['image'] = $value->image;
            $data['lastname'] = $value->lastname;
            $data['dni'] = $value->dni;
            $data['status'] = $value->status;
            $data['address'] = $value->address;
            $data['location'] = $value->location;
            $data['email'] = $value->email;
            $data['phone'] = $value->phone;
            $data['mobile'] = $value->mobile;
            $data['created_at'] = Carbon::parse($value->created_at)->locale('es')->isoFormat('DD/MM/YYYY');
            $customers[] = $data;
        }

        return Datatables::of($customers)->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            $customer = new Customer();
            $customer->name = $request->name;
            $customer->lastname = $request->lastname;
            $customer->slug = Str::slug($request->name.'-'.$request->lastname);
            $customer->email = $request->email;
            $customer->dni = $request->dni;
            $customer->phone = $request->phone;
            $customer->mobile = $request->mobile;
            $customer->address = $request->address;
            $customer->location = $request->location;
            if($request->file('image')){
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getCustomerOriginalExtension();
                $imagePath = public_path('images/customers/') . $imageName;
                $image->move(public_path('images/customers/'), $imageName);
                $resizedImagePath = 'images/customers/' . $imageName;

                // Redimensionar y corregir la orientación de la imagen
                Image::make($imagePath)->resize(640, 640, function ($constraint) {
                        $constraint->aspectRatio(); // Mantener la proporción original
                    })
                    ->orientate() // Corregir la orientación
                    ->save(public_path($resizedImagePath));

                $customer->image = $resizedImagePath;
            }
            $customer->details = $request->details;
            $customer->save();

            return response()->json(['message' => trans('Customer successfully created')], 200);
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
        $customer = Customer::findOrFail($id);
        $breadcrumb = [
            ['url' => '/home', 'label' => trans('Home')],
            ['url' => '/home/customers', 'label' => trans('Customers')],
            ['url' => '#', 'label' => $customer->name.' '.$customer->lastname],
        ];

        return view('pages.admin.customers.show',compact('breadcrumb','customer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        return response()->json($customer);
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
            $customer = Customer::findOrFail($id);

            // Borrar la imagen anterior si existe
            if ($customer->image && $customer->image != null && $request->file('edit_image') != '') {
                $oldImagePath = public_path($customer->image);
                if (File::exists($oldImagePath)) {
                    File::delete($oldImagePath);
                    $customer->image = null;
                }
            }

            // Actualizar los campos del usuario
            $customer->name = $request->edit_name;
            $customer->dni = $request->edit_dni;
            $customer->lastname = $request->edit_lastname;
            $customer->slug = Str::slug($request->edit_name . '-' . $request->edit_lastname);
            $customer->phone = $request->edit_phone;
            $customer->mobile = $request->edit_mobile;
            $customer->address = $request->edit_address;
            $customer->location = $request->edit_location;
            $customer->status = $request->edit_status;

            if($request->edit_status != 'Deleted'){
                $customer->deleted_at = NULL;
            }else{
                $customer->deleted_at = now();
            }

            if($request->edit_email == $customer->email){}
            else{
                $customer->email = $request->edit_email;
            }

            // Actualizar la imagen solo si se proporciona una nueva imagen
            if ($request->file('edit_image') && $request->file('edit_image') != null && $request->file('edit_image') != '') {
                if($request->file('edit_image')){
                    $image = $request->file('edit_image');
                    $imageName = time() . '.' . $image->getCustomerOriginalExtension();
                    $imagePath = public_path('images/customers/') . $imageName;
                    $image->move(public_path('images/customers/'), $imageName);
                    $resizedImagePath = 'images/customers/' . $imageName;

                    // Redimensionar y corregir la orientación de la imagen
                    Image::make($imagePath)
                        ->resize(640, 640, function ($constraint) {
                            $constraint->aspectRatio(); // Mantener la proporción original
                        })
                        ->orientate() // Corregir la orientación
                        ->save(public_path($resizedImagePath));

                    $customer->image = $resizedImagePath;
                }
            }

            // Guardar los cambios en la base de datos
            $customer->details = $request->edit_details;

            $customer->save();

            return response()->json(['message' => trans('Customer successfully updated')], 200);
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
    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->update([
            'status' => 0,
            'deleted_at' => now(),
        ]);
        return response()->json(['message' => trans('Customer marked as inactive.')]);
    }

    // Método en el controlador para restaurar el almacén
    public function restore($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->update([
            'status' => 1,
            'deleted_at' => null,
        ]);
        return response()->json(['message' => trans('Customer restored.')]);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv',
        ]);

        try {
            $file = $request->file('file');

            // Importar el archivo CSV
            $import = new CustomersImport;
            Excel::import($import, $file);

            // Verificar si hay productos duplicados
            $duplicates = $import->getDuplicates();

            if (!empty($duplicates)) {
                return response()->json([
                    'error' => 'Error durante la importación: Algunos usuarios ya existen en el listado.',
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
                $errorMessage = 'Error durante la importación: Ya existe un usuario duplicado en el listado.';
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
        return Excel::download(new CustomersExport, 'users.xlsx');
    }
}
