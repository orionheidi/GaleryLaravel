<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Photo;
use App\Gallery;

class PhotoController extends Controller
{
    // public function index()
    // {
    //     return Photo::with('gallery')->orderBy('id', 'DESC')->take(10)->get();
    // }
    public function store(Request $request,$galleryId)
    {
        $this->validate($request,
        [
            'url' => 'required'
            // |mimes:jpeg,jpg,png',   
        ]);

        $gallery = Gallery::findOrFail($galleryId);
       
        $photo = Photo::create([
            'url' => $request->get('url'),
            'gallery_id' => $gallery->id
        ]);

        return $photo;
    
       
    }
}
