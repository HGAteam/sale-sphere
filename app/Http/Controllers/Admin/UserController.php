<?php

namespace App\Http\Controllers\Admin;

use App\Exports\UserExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UpdatePersonalInfoRequest;
use App\Imports\UserImport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use DataTables;
use Illuminate\Validation\ValidationException;
use Str;
use File;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Database\QueryException;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
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
            ['url' => '/home/users', 'label' => trans('Users')]
        ];


        return view('pages.admin.users.index', compact('breadcrumb'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function data()
    {
        if(Auth::user()->role == 'Admin'){
            $userArray = User::where('id','!=',Auth::user()->id)->orderBy('id', 'Desc')->get();
        }else{
            $userArray = User::where('role', '!=', 'Admin')->where('id', '!=', Auth::user()->id)->where('status','!=','Deleted')->get();
        }

        $users = [];

        foreach ($userArray as $value) {
            $data['id'] = $value->id;
            $data['role'] = $value->role;
            $data['slug'] = $value->slug;
            $data['name'] = $value->name.' '. $value->lastname;
            $data['email'] = $value->email;
            $data['avatar'] = $value->avatar;
            $data['phone'] = $value->phone;
            $data['mobile'] = $value->mobile;
            $data['status'] = $value->status;
            $data['created_at'] = Carbon::parse($value->created_at)->locale('es')->isoFormat('DD/MM/YYYY');
            $users[] = $data;
        }

        return Datatables::of($users)->make(true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUserRequest $request)
    {
        try {

            if($request->file('image')){
                // Obtener la imagen del formulario
                $image = $request->file('image');

                // Generar un nombre único para la imagen
                $imageName = time() . '.' . $image->getClientOriginalExtension();

                // Guardar la imagen original en el sistema de archivos
                $imagePath = public_path('images/users/') . $imageName;
                $image->move(public_path('images/users/'), $imageName);

                // Puedes almacenar la ruta de la imagen redimensionada en tu base de datos si es necesario
                $resizedImagePath = 'images/users/'  . $imageName;
                // Redimensionar la imagen (ajusta a un tamaño específico)
                Image::make($imagePath)->fit(640, 640)->save(public_path($resizedImagePath));
            }

            $user = new User();
            $user->name = $request->name;
            $user->lastname = $request->lastname;
            $user->slug = Str::slug($request->name.'-'.$request->lastname);
            $user->role = $request->role;
            $user->phone = $request->phone;
            $user->mobile = $request->mobile;
            $user->address = $request->address;
            $user->location = $request->location;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            if($request->file('image')){
                $user->avatar = $resizedImagePath;
            }
            $user->save();

            return response()->json(['message' => trans('User successfully created')], 200);
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
       $user = User::find($id);
       $breadcrumb = [
        ['url' => '/home', 'label' => trans('Home')],
        ['url' => '/home/users', 'label' => trans('Users')],
        ['url' => '#', 'label' => trans('Profile')]
    ];

    return view('pages.admin.users.show', compact('breadcrumb','user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);

        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $id)
    {
        try {
            // Obtener el usuario existente
            $user = User::findOrFail($id);

            // Borrar la imagen anterior si existe
            if ($user->avatar && $user->avatar != null && $request->file('edit_image') != '') {
                $oldImagePath = public_path($user->avatar);
                if (File::exists($oldImagePath)) {
                    File::delete($oldImagePath);
                    $user->avatar = null;
                }
            }

            // Actualizar los campos del usuario
            $user->name = $request->edit_name;
            $user->lastname = $request->edit_lastname;
            $user->slug = Str::slug($request->edit_name . '-' . $request->edit_lastname);
            $user->role = $request->edit_role;
            $user->phone = $request->edit_phone;
            $user->mobile = $request->edit_mobile;
            $user->address = $request->edit_address;
            $user->location = $request->edit_location;
            if($request->edit_email == $user->email){}
            else{
                $user->email = $request->edit_email;
            }

            // Actualizar la imagen solo si se proporciona una nueva imagen
            if ($request->file('edit_image') && $request->file('edit_image') != null && $request->file('edit_image') != '') {
                $image = $request->file('edit_image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $imagePath = public_path('images/users/') . $imageName;
                $image->move(public_path('images/users/'), $imageName);
                $resizedImagePath = 'images/users/' . $imageName;
                Image::make($imagePath)->fit(640, 640)->save(public_path($resizedImagePath));
                $user->avatar = $resizedImagePath;
            }
            if($user->status == "Deleted" && $request->edit_status != $user->status){
                $user->deleted_at = null;
            }

            if(auth()->user()->role == 'Admin'){
                if($user->status != "Deleted" && $request->edit_status == 'Deleted'){
                    $user->deleted_at = now();
                }
            }
            // Guardar los cambios en la base de datos
            $user->save();

            return response()->json(['message' => trans('User successfully updated')], 200);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->validator->errors()->toArray()], 422);
        }
    }

    public function updatePersonalInfo(UpdatePersonalInfoRequest $request, $id)
    {
        try {
            // Obtener el usuario existente
            $user = User::findOrFail($id);
            // Actualizar los campos del usuario
            $user->name = $request->name;
            $user->lastname = $request->lastname;
            $user->slug = Str::slug($request->name . '-' . $request->lastname);
            $user->address = $request->address;
            $user->location = $request->location;
            $user->phone = $request->phone;
            $user->mobile = $request->mobile;
            if($request->email != $user->email){
                $user->email = $request->email;
            }
            // Actualizar la imagen solo si se proporciona una nueva imagen
            if ($request->hasFile('image')) {
                // Borrar la imagen anterior si existe
                if ($user->avatar) {
                    $oldImagePath = public_path($user->avatar);
                    if (File::exists($oldImagePath)) {
                        File::delete($oldImagePath);
                    }
                }
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $imagePath = public_path('images/users/') . $imageName;
                $image->move(public_path('images/users/'), $imageName);
                $resizedImagePath = 'images/users/' . $imageName;

                // Redimensionar y corregir la orientación de la imagen
                Image::make($imagePath)
                    ->resize(640, 640, function ($constraint) {
                        $constraint->aspectRatio(); // Mantener la proporción original
                    })
                    ->orientate() // Corregir la orientación
                    ->save(public_path($resizedImagePath));

                $user->avatar = $resizedImagePath;
            }

            // Guardar los cambios en la base de datos
            $user->save();

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
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);

            // Cambiar el estado a "Inactive" o "Deleted" según tu columna 'status'
            $user->update([
                'status' => 'Deleted',
                'deleted_at' => now(), // Opcional, para establecer la marca de tiempo de eliminación
            ]);

             // Puedes devolver una respuesta JSON o redirigir a la página que desees
            return response()->json(['message' => trans('User status changed to Deleted')]);

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
            $import = new UserImport;
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
        return Excel::download(new UserExport, 'users.xlsx');
    }
}
