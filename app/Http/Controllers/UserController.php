<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Image;
use App\Models\User;

class UserController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function config() {
        return view('user.config');
    }

    public function update(Request $request) {
        $user = \Auth::user();
        $id = $user->id;
        $validate = $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'nick' => ['required', 'string', 'max:255', 'unique:users,nick,' . $id],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $id]
        ]);

        $name = $request->input('name');
        $surname = $request->input('surname');
        $nick = $request->input('nick');
        $email = $request->input('email');

        $user->name = $name;
        $user->surname = $surname;
        $user->email = $email;
        $user->nick = $nick;

        //Subir la img:

        $image_path = $request->file('image_path');
        if ($image_path) {
            $extension = $image_path->getClientOriginalExtension();
            if ($extension == 'png' || $extension == 'jpg' || $extension == 'jpeg' || $extension == 'gif') {


                //Si nos llega el objeto de la imagen usamos el storage.
                //Con el time hacemos que el nombre de la img sea unico y obtenemos el nombre original que cargó el cliente.
                $image_path_name = time() . $image_path->getClientOriginalName();

                //Guardamos en la carpeta storage/app/users
                \Storage::disk('users')->put($image_path_name, \File::get($image_path));

                // Seteo el nombre de la imagen en el objeto.
                $user->image = $image_path_name;
            } else {
                return redirect()->route('config')->with(['message-error' => 'No estás cargando una imagen. Comprueba el formato']);
            }
        }

        $user->update();

        return redirect()->route('config')->with(['message' => 'Usuario actualizado con éxito!']);
    }

    public function getImage($filename) {
        //Obtenemos la imagen del storage que vamos a pasar por la url como param.
        $file = \Storage::disk('users')->get($filename);

        //Devolvemos una respuesta con la imagen y el codigo 200 (éxito)
        return new Response($file, 200);
    }

    public function userImages($id) {

        $user = User::find($id);
        $images = Image::orderBy('id', 'desc')->where('user_id', $user->id)->get();

        return view('user.user-images', [
            'user' => $user,
            'images' => $images
        ]);
    }

    public function allUsers($search = null) {
        if(!empty($search)) {
            $users = User::where('nick', 'LIKE', '%'.$search.'%')
                    ->orWhere('name', 'LIKE', '%'.$search.'%')
                    ->orWhere('surname', 'LIKE', '%'.$search.'%')
                    ->orderBy('nick', 'asc')->get();
        }else{
            $users = User::orderBy('nick', 'asc')->get();
        }
        

        return view('user.gente', [
            'users' => $users,
            'search' => $search
        ]);
    }

}
