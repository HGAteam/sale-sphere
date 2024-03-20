<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use DataTables;
use Str;
use File;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;
use Intervention\Image\ImageManagerStatic as Image;
class CategoryController extends Controller
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
            ['url' => '/home/categories', 'label' => trans('Categories')],
        ];

        return view('pages.admin.categories.index',compact('breadcrumb'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function data()
    {
        if(auth()->user()->role == 'Admin'){
            $categoryArray = Category::orderBy('id','Desc')->get();
        }else{
            $categoryArray = Category::where('status','!=','Deleted')->where('deleted_at','!=',null)->orderBy('id','Desc')->get();
        }
        $categories = [];

        foreach ($categoryArray as $value) {
            $data['id'] = $value->id;
            $data['name'] = $value->name;
            $data['image'] = $value->image;
            $data['status'] = $value->status;
            $data['details'] = $value->details;
            $data['created_at'] = Carbon::parse($value->created_at)->locale('es')->isoFormat('DD/MM/YYYY');
            $categories[] = $data;
        }

        return Datatables::of($categories)->make(true);
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
        $category = new Category();
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);

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

            $category->image = $resizedImagePath;
        }

        $category->status = $request->status;
        $category->details = $request->details;

        $category->save();

        return response()->json(['message' => trans('Category successfully created')], 200);

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
        $category = Category::findOrFail($id);
        return response()->json($category);
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
            $category = Category::findOrFail($id);

            // Borrar la imagen anterior si existe
            if ($category->image && $category->image != null && $request->file('edit_image') != '') {
                $oldImagePath = public_path($category->image);
                if (File::exists($oldImagePath)) {
                    File::delete($oldImagePath);
                    $category->image = null;
                }
            }

            // Actualizar los campos del usuario
            $category->name = $request->edit_name;
            $category->status = $request->edit_status;
            $category->slug = Str::slug($request->edit_name);
            $category->details = $request->edit_details;

            // Actualizar la imagen solo si se proporciona una nueva imagen
            if ($request->file('edit_image') && $request->file('edit_image') != null && $request->file('edit_image') != '') {
                $image = $request->file('edit_image');
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

                $category->image = $resizedImagePath;
            }

            // Guardar los cambios en la base de datos
            $category->save();

            return response()->json(['message' => trans('Category successfully updated')], 200);
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
            $category = Category::findOrFail($id);

            // Cambiar el estado a "Inactive" o "Deleted" según tu columna 'status'
            $category->update([
                'status' => 'Deleted',
                'deleted_at' => now(), // Opcional, para establecer la marca de tiempo de eliminación
            ]);

             // Puedes devolver una respuesta JSON o redirigir a la página que desees
            return response()->json(['message' => trans('Category status changed to Deleted')]);

        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->validator->errors()->toArray()], 422);
        }

    }
}
