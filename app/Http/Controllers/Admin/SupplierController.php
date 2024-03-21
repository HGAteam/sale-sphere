<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier;
use Carbon\Carbon;
use DataTables;
use Illuminate\Validation\ValidationException;
use Str;
use File;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Database\QueryException;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\SuppliersImport;
use App\Exports\SuppliersExport;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $breadcrumb = [
            ['url' => '/', 'label' => trans('Home')],
            ['url' => '#', 'label' => trans('Suppliers')],
        ];
        $suppliers = Supplier::all()->count();

        return view('pages.admin.suppliers.index',compact('breadcrumb', 'suppliers'));
    }
    public function data()
    {
        $supplierArray = Supplier::all();
        $suppliers = [];

        foreach ($supplierArray as $value) {
            $data['id'] = $value->id;
            $data['social_reason'] = $value->social_reason;
            $data['image'] = $value->image;
            $data['contact'] = $value->contact;
            $data['cuit'] = $value->cuit;
            $data['status'] = $value->status;
            $data['address'] = $value->address;
            $data['location'] = $value->location;
            $data['email'] = $value->email;
            $data['phone'] = $value->phone;
            $data['mobile'] = $value->mobile;
            $data['created_at'] = Carbon::parse($value->created_at)->locale('es')->isoFormat('DD/MM/YYYY');
            $data['details'] = $value->details;
            $suppliers[] = $data;
        }

        return Datatables::of($suppliers)->make(true);
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
            $supplier = new Supplier();
            $supplier->social_reason = $request->social_reason;
            $supplier->contact = $request->name.' '.$request->lastname;
            $supplier->slug = Str::slug($supplier->contact);
            $supplier->email = $request->email;
            $supplier->cuit = $request->cuit;
            $supplier->phone = $request->phone;
            $supplier->mobile = $request->mobile;
            $supplier->address = $request->address;
            $supplier->location = $request->location;
            $supplier->details = $request->details;
            if($request->file('image')){
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $imagePath = public_path('images/suppliers/') . $imageName;
                $image->move(public_path('images/suppliers/'), $imageName);
                $resizedImagePath = 'images/suppliers/' . $imageName;

                // Redimensionar y corregir la orientación de la imagen
                Image::make($imagePath)
                    ->resize(640, 640, function ($constraint) {
                        $constraint->aspectRatio(); // Mantener la proporción original
                    })
                    ->orientate() // Corregir la orientación
                    ->save(public_path($resizedImagePath));

                    $supplier->image = $resizedImagePath;
            }
            $supplier->save();

            return response()->json(['message' => trans('Supplier successfully created')], 200);
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
        $supplier = Supplier::findOrFail($id);
        $breadcrumb = [
            ['url' => '/home', 'label' => trans('Home')],
            ['url' => '/home/suppliers', 'label' => trans('Suppliers')],
            ['url' => '#', 'label' => $supplier->name.' '.$supplier->lastname],
        ];

        return view('pages.admin.suppliers.show',compact('breadcrumb','supplier'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $supplier = Supplier::findOrFail($id);

        $fullName = $supplier->contact;
        $nameParts = explode(' ', $fullName);
        $name = $nameParts[0];
        $lastName = end($nameParts);

        $supplierData = [
            'id' => $supplier->id,
            'social_reason' => $supplier->social_reason,
            'name' => $name,
            'lastname' => $lastName,
            'cuit' => $supplier->cuit,
            'status' => $supplier->status,
            'address' => $supplier->address,
            'location' => $supplier->location,
            'email' => $supplier->email,
            'phone' => $supplier->phone,
            'mobile' => $supplier->mobile,
            'created_at' => $supplier->created_at,
            'details' => $supplier->details,
        ];

        return response()->json($supplierData);
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
            $supplier = Supplier::findOrFail($id);

            // Borrar la imagen anterior si existe
            if ($supplier->image && $supplier->image != null && $request->file('edit_image') != '') {
                $oldImagePath = public_path($supplier->image);
                if (File::exists($oldImagePath)) {
                    File::delete($oldImagePath);
                    $supplier->image = null;
                }
            }

            // Actualizar los campos del usuario
            if ($supplier->contact == $request->edit_name.' '.$request->edit_lastname) {
            } else {
                $supplier->contact = $request->edit_name.' '.$request->edit_lastname;
                $supplier->slug = Str::slug($supplier->contact);
            }

            $supplier->cuit = $request->edit_cuit;

            if($supplier->status == "Deleted" && $request->edit_status != $supplier->status){
                $supplier->deleted_at = null;
            }

            if(auth()->user()->role == 'Admin'){
                if($supplier->status != "Deleted" && $request->edit_status == 'Deleted'){
                    $supplier->deleted_at = now();
                }
            }
            $supplier->status = $request->edit_status;
            $supplier->phone = $request->edit_phone;
            $supplier->mobile = $request->edit_mobile;
            $supplier->address = $request->edit_address;
            $supplier->location = $request->edit_location;
            if($request->edit_email == $supplier->email){}
            else{
                $supplier->email = $request->edit_email;
            }
            $supplier->details = $request->edit_details;

            // Actualizar la imagen solo si se proporciona una nueva imagen
            if ($request->file('edit_image') && $request->file('edit_image') != null && $request->file('edit_image') != '') {
                $image = $request->file('edit_image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $imagePath = public_path('images/suppliers/') . $imageName;
                $image->move(public_path('images/suppliers/'), $imageName);
                $resizedImagePath = 'images/suppliers/' . $imageName;

                // Redimensionar y corregir la orientación de la imagen
                Image::make($imagePath)
                    ->resize(640, 640, function ($constraint) {
                        $constraint->aspectRatio(); // Mantener la proporción original
                    })
                    ->orientate() // Corregir la orientación
                    ->save(public_path($resizedImagePath));

                    $supplier->image = $resizedImagePath;
            }

            // Guardar los cambios en la base de datos
            $supplier->save();

            return response()->json(['message' => trans('Supplier successfully updated')], 200);
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
        try {
            $supplier = Supplier::findOrFail($id);

            // Cambiar el estado a "Inactive" o "Deleted" según tu columna 'status'
            $supplier->update([
                'status' => 'Deleted',
                'deleted_at' => now(), // Opcional, para establecer la marca de tiempo de eliminación
            ]);

             // Puedes devolver una respuesta JSON o redirigir a la página que desees
            return response()->json(['message' => trans('Supplier status changed to Deleted')]);

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
            $import = new SuppliersImport;
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
        return Excel::download(new SuppliersExport, 'users.xlsx');
    }
}
