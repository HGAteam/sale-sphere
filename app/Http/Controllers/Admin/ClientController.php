<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \App\Models\Client;
use Carbon\Carbon;
use DataTables;
use Illuminate\Validation\ValidationException;
use Str;
use Auth;
use File;
use Intervention\Image\ImageManagerStatic as Image;
class ClientController extends Controller
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
            ['url' => '#', 'label' => trans('Clients')],
        ];
        $clients = Client::all()->count();

        return view('pages.admin.clients.index',compact('breadcrumb','clients'));
    }

    public function data()
    {
        $clientArray = Client::all();
        $clients = [];

        foreach ($clientArray as $value) {
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
            $clients[] = $data;
        }

        return Datatables::of($clients)->make(true);
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
            $client = new Client();
            $client->name = $request->name;
            $client->lastname = $request->lastname;
            $client->slug = Str::slug($request->name.'-'.$request->lastname);
            $client->email = $request->email;
            $client->dni = $request->dni;
            $client->phone = $request->phone;
            $client->mobile = $request->mobile;
            $client->address = $request->address;
            $client->location = $request->location;
            if($request->file('image')){
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $imagePath = public_path('images/clients/') . $imageName;
                $image->move(public_path('images/clients/'), $imageName);
                $resizedImagePath = 'images/clients/' . $imageName;

                // Redimensionar y corregir la orientación de la imagen
                Image::make($imagePath)->resize(640, 640, function ($constraint) {
                        $constraint->aspectRatio(); // Mantener la proporción original
                    })
                    ->orientate() // Corregir la orientación
                    ->save(public_path($resizedImagePath));

                $client->image = $resizedImagePath;
            }
            $client->details = $request->details;
            $client->save();

            return response()->json(['message' => trans('Client successfully created')], 200);
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
        $client = Client::findOrFail($id);
        return response()->json($client);
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
            $client = Client::findOrFail($id);

            // Borrar la imagen anterior si existe
            if ($client->image && $client->image != null && $request->file('edit_image') != '') {
                $oldImagePath = public_path($client->image);
                if (File::exists($oldImagePath)) {
                    File::delete($oldImagePath);
                    $client->image = null;
                }
            }

            // Actualizar los campos del usuario
            $client->name = $request->edit_name;
            $client->dni = $request->edit_dni;
            $client->lastname = $request->edit_lastname;
            $client->slug = Str::slug($request->edit_name . '-' . $request->edit_lastname);
            $client->phone = $request->edit_phone;
            $client->mobile = $request->edit_mobile;
            $client->address = $request->edit_address;
            $client->location = $request->edit_location;
            $client->status = $request->edit_status;

            if($request->edit_status != 'Deleted'){
                $client->deleted_at = NULL;
            }else{
                $client->deleted_at = now();
            }

            if($request->edit_email == $client->email){}
            else{
                $client->email = $request->edit_email;
            }

            // Actualizar la imagen solo si se proporciona una nueva imagen
            if ($request->file('edit_image') && $request->file('edit_image') != null && $request->file('edit_image') != '') {
                if($request->file('edit_image')){
                    $image = $request->file('edit_image');
                    $imageName = time() . '.' . $image->getClientOriginalExtension();
                    $imagePath = public_path('images/clients/') . $imageName;
                    $image->move(public_path('images/clients/'), $imageName);
                    $resizedImagePath = 'images/clients/' . $imageName;

                    // Redimensionar y corregir la orientación de la imagen
                    Image::make($imagePath)
                        ->resize(640, 640, function ($constraint) {
                            $constraint->aspectRatio(); // Mantener la proporción original
                        })
                        ->orientate() // Corregir la orientación
                        ->save(public_path($resizedImagePath));

                    $client->image = $resizedImagePath;
                }
            }

            // Guardar los cambios en la base de datos
            $client->details = $request->edit_details;

            $client->save();

            return response()->json(['message' => trans('Client successfully updated')], 200);
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
            $client = Client::findOrFail($id);

            // Cambiar el estado a "Inactive" o "Deleted" según tu columna 'status'
            $client->update([
                'status' => 'Deleted',
                'deleted_at' => now(), // Opcional, para establecer la marca de tiempo de eliminación
            ]);

             // Puedes devolver una respuesta JSON o redirigir a la página que desees
            return response()->json(['message' => trans('Client status changed to Deleted')]);

        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->validator->errors()->toArray()], 422);
        }
    }
}
