<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Image;

class CommentController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function comments($id) {
        $image = Image::find($id);

        return view('comment.comments', [
            'image' => $image
        ]);
    }

    public function save(Request $request) {

        $image_id = $request->input('image_id');
        $user = \Auth::user();
        $content = $request->input('content');

        $comment = new Comment();
        $comment->image_id = $image_id;
        $comment->user_id = $user->id;
        $comment->content = $content;

        $comment->save();

        return redirect()->route('comments', ['id' => $comment->image_id])->with([
                    'message' => 'Has publicado un comentario'
        ]);
    }

    public function delete($id) {
        $user = \Auth::user();

        $comment = Comment::find($id);

        if ($user && $user->id = $comment->user_id) {
            $comment->delete();

            return redirect()->route('comments', ['id' => $comment->image_id])->with([
                        'message' => 'Comentario borrado!'
            ]);
        } else {
            return redirect()->route('comments', ['id' => $comment->image_id])->with([
                        'message' => 'El comentario no se ha borrado!'
            ]);
        }
    }

}
