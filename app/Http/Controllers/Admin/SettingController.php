<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Http\Requests\UpdateSettingsRequest;
use Illuminate\Validation\ValidationException;
use File;
use Intervention\Image\ImageManagerStatic as Image;

class SettingController extends Controller
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
            ['url' => '#', 'label' => trans('Settings')],
            // ['url' => '/productos/zapatos', 'label' => 'Zapatos'],
        ];

        $setting = Setting::findOrFail(1);
        return view('pages.admin.settings.index',compact('breadcrumb','setting'));
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
    public function store(UpdateSettingsRequest $request)
    {
        try {
            $setting = Setting::findOrFail(1);

            // Borrar la imagen anterior si existe
            if ($setting->logo && $setting->logo != null && $request->file('logo') != '') {
                $oldImagePath = public_path($setting->logo);
                if (File::exists($oldImagePath)) {
                    File::delete($oldImagePath);
                    $setting->logo = null;
                }
            }

            $setting->business_name = $request->business_name;
            $setting->owner_name = $request->owner_name;
            $setting->email = $request->email;
            $setting->cuit = $request->cuit;
            $setting->central_location = $request->central_location;
            $setting->location_code = $request->location_code;
            $setting->phone = $request->phone;
            $setting->mobile = $request->mobile;
            if ($request->hasFile('logo')) {
                // Ajusta la lógica de almacenamiento de archivos según tus necesidades
                // Obtener la imagen del formulario
                $image = $request->file('logo');

                // Generar un nombre único para la imagen
                $imageName = time() . '_' . $image->getClientOriginalName();

                // Guardar la imagen original en el sistema de archivos
                $imagePath = public_path('images/company/') . $imageName;
                $image->move(public_path('images/company/'), $imageName);

                // Puedes almacenar la ruta de la imagen redimensionada en tu base de datos si es necesario
                $resizedImagePath = 'images/company/'  . $imageName;
                // Redimensionar la imagen (ajusta a un tamaño específico)
                Image::make($imagePath)->fit(640, 640)->save(public_path($resizedImagePath));
                $setting->logo = $resizedImagePath;
            }
            $setting->save();

            // Puedes devolver una respuesta adecuada, por ejemplo, una redirección o un mensaje JSON
            return response()->json(['message' => trans('Settings successfully updated')], 200);
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
