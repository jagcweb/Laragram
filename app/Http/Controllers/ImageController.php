<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;
use Illuminate\Http\Response;

class ImageController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function create() {
        return view('image.create');
    }

    public function save(Request $request) {

        //validacion
        $validate = $this->validate($request, [
            'description' => ['required'],
            'image_path' => ['required', 'image']
        ]);

        $image_path = $request->file('image_path');
        $descripcion = $request->input('description');

        $user = \Auth::user();
        $imagen = new Image();
        $imagen->user_id = $user->id;
        $imagen->image_path = null;
        $imagen->description = $descripcion;

        if ($image_path) {
            $image_path_name = time() . $image_path->getClientOriginalName();
            \Storage::disk('images')->put($image_path_name, \File::get($image_path));
            $imagen->image_path = $image_path_name;
        }
        
        $imagen->save(); //hace el insert sin tener que preocuparse por nada mas.
        
        return redirect()->route('home')->with(['message'=>'La foto ha sido subida correctamente!']);
    }
    
    public function getImage($filename) {
        //Obtenemos la imagen del storage que vamos a pasar por la url como param.
        $file = \Storage::disk('images')->get($filename);

        //Devolvemos una respuesta con la imagen y el codigo 200 (éxito)
        return new Response($file, 200);
    }
    
    public function updateForm($id) {
        $user = \Auth::user();
        $image = Image::find($id);
        
        if($user && $user->id == $image->user_id){
            
            return view('image.update', [
                "image" => $image
            ]);
        }else{
            return redirect()->route('home');
        }
        
    }
    
    public function update(Request $request) {
        
        $validate = $this->validate($request, [
            'description' => ['required'],
            'image_path' => ['required', 'image']
        ]);
        
        $image_id = $request->input('image_id');
        $image_path = $request->file('image_path');
        $descripcion = $request->input('description');
        
        $image = Image::find($image_id);
         if ($image_path) {
            $image_path_name = time() . $image_path->getClientOriginalName();
            \Storage::disk('images')->delete($image->image_path);
            \Storage::disk('images')->put($image_path_name, \File::get($image_path));
            $image->image_path = $image_path_name;
            $image->description = $descripcion;
        }
        
        $image->update();
        
        return redirect()->route('user.images', ['id' => \Auth::user()->id])->with(['message' => 'Imagen actualizada!']);
    }
    
    public function delete($id){
        $user = \Auth::user();
        $image = Image::find($id);
        
        if($user && $user->id == $image->user_id){
            
            //Eliminar comentarios y likes
            $image->comments()->delete();
            $image->likes()->delete();
           
            $image->delete();
            
            //Eliminar el fichero
            \Storage::disk('images')->delete($image->image_path);

            return redirect()->route('home', ['id' => $image->image_id])->with([
                        'message' => 'Imagen borrada!'
            ]);
        }else{
            return redirect()->route('home', ['id' => $image->image_id])->with([
                        'message' => 'Error al borrar la imagen.'
            ]);
        }
    }
    

}
