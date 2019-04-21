<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Gallery;
use App\Comment;

class CommentController extends Controller
{
    public function store(Request $request)
    {

        $this->validate($request,
        [
            'text' => 'required|max:1000'      
        ]);

        // $gallery = Gallery::findOrFail($request->gallery_id);

        // $comment = Comment::create([
        //     'text' => $request->text,
        //     'user_id' => auth()->user()->id,
        //     'gallery_id' => $gallery->id
        // ]);
        // return $comment;

        $comment = Comment::create($request->all());        
        return Comment::with('user')->findOrFail($comment->id);

    }

    public function destroy($id)
    {
        return Comment::destroy($id);
    }
}
