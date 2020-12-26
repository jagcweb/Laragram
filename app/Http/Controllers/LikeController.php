<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use App\Models\Image;

class LikeController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function like($image_id) {

        $user = \Auth::user();

        //Comprobar si ya existe like:
        $isset_like = Like::where('user_id', $user->id)
                ->where('image_id', $image_id)
                ->count();

        if ($isset_like == 0) {
            $like = new Like();
            $like->user_id = $user->id;
            $like->image_id = (int) $image_id;

            $like->save();

            return response()->json([
                        'like' => $like
            ]);
        } else {
            return response()->json([
                        'message' => 'El like ya existe'
            ]);
        }
    }

    public function dislike($image_id) {
        $user = \Auth::user();

        //Comprobar si ya existe like:
        $like = Like::where('user_id', $user->id)
                ->where('image_id', $image_id)
                ->first();

        if ($like) {

            $like->delete();

            return response()->json([
                        'like' => $like,
                        'message' => 'Has dado dislike'
            ]);
        } else {
            return response()->json([
                        'message' => 'El like no existe'
            ]);
        }
    }

    public function imageLikes($id) {
        $image = Image::find($id);

        return view('like.likes', [
            'image' => $image
        ]);
    }

    public function userLikes() {
        $user = \Auth::user();
        $likes = Like::orderBy('id', 'desc')->where('user_id', $user->id)->get();

        return view('like.user-likes', [
            'likes' => $likes
        ]);
    }

}
