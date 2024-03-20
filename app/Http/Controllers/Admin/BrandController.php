<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use File;
use DataTables;
use Str;
use Illuminate\Validation\ValidationException;
use Intervention\Image\ImageManagerStatic as Image;
use Carbon\Carbon;
class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $breadcrumb = [
            ['url' => '/home', 'label' => trans('Brand')],
            ['url' => '/home/brands', 'label' => trans('Brands')],
        ];

        return view('pages.admin.brands.index',compact('breadcrumb'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function data()
    {
        if(auth()->user()->role == 'Admin'){
            $brandArray = Brand::orderBy('id','Desc')->get();
        }else{
            $brandArray = Brand::where('status','!=','Deleted')->where('deleted_at','!=',null)->orderBy('id','Desc')->get();
        }

        $brands = [];

        foreach ($brandArray as $value) {
            $data['id'] = $value->id;
            $data['name'] = $value->name;
            $data['image'] = $value->image;
            $data['status'] = $value->status;
            $data['details'] = $value->details;
            $data['created_at'] = Carbon::parse($value->created_at)->locale('es')->isoFormat('DD/MM/YYYY');
            $brands[] = $data;
        }

        return Datatables::of($brands)->make(true);
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
            $brand = new Brand();
            $brand->name = $request->name;
            $brand->slug = Str::slug($request->name);
            if($request->file('image')){
                $image = $request->file('image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $imagePath = public_path('images/categories/') . $imageName;
                $image->move(public_path('images/categories/'), $imageName);
                $resizedImagePath = 'images/categories/' . $imageName;

                // Redimensionar y corregir la orientación de la imagen
                Image::make($imagePath)
                    ->resize(640, 640, function ($constraint) {
                        $constraint->aspectRatio(); // Mantener la proporción original
                    })
                    ->orientate() // Corregir la orientación
                    ->save(public_path($resizedImagePath));

                $brand->image = $resizedImagePath;
            }
            $brand->status = $request->status;
            $brand->details = $request->details;

            $brand->save();

            return response()->json(['message' => trans('Brand successfully created')], 200);

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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $brand = Brand::findOrFail($id);
        return response()->json($brand);
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
            $brand = Brand::findOrFail($id);

            // Borrar la imagen anterior si existe
            if ($brand->image && $brand->image != null && $request->file('edit_image') != '') {
                $oldImagePath = public_path($brand->image);
                if (File::exists($oldImagePath)) {
                    File::delete($oldImagePath);
                    $brand->image = null;
                }
            }

            // Actualizar los campos del usuario
            $brand->name = $request->edit_name;
            $brand->status = $request->edit_status;
            $brand->slug = Str::slug($request->edit_name);
            $brand->details = $request->edit_details;

            // Actualizar la imagen solo si se proporciona una nueva imagen
            if ($request->file('edit_image') && $request->file('edit_image') != null && $request->file('edit_image') != '') {
                $image = $request->file('edit_image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $imagePath = public_path('images/brands/') . $imageName;
                $image->move(public_path('images/brands/'), $imageName);
                $resizedImagePath = 'images/brands/' . $imageName;

                // Redimensionar y corregir la orientación de la imagen
                Image::make($imagePath)
                    ->resize(640, 640, function ($constraint) {
                        $constraint->aspectRatio(); // Mantener la proporción original
                    })
                    ->orientate() // Corregir la orientación
                    ->save(public_path($resizedImagePath));

                $brand->image = $resizedImagePath;
            }

            // Guardar los cambios en la base de datos
            $brand->save();

            return response()->json(['message' => trans('Brand successfully updated')], 200);
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
            $brand = Brand::findOrFail($id);

            // Cambiar el estado a "Inactive" o "Deleted" según tu columna 'status'
            $brand->update([
                'status' => 'Deleted',
                // Opcional, para establecer la marca de tiempo de eliminación
                'deleted_at' => now(),
            ]);

             // Puedes devolver una respuesta JSON o redirigir a la página que desees
            return response()->json(['message' => trans('Brand status changed to Deleted')]);

        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->validator->errors()->toArray()], 422);
        }
    }
}
