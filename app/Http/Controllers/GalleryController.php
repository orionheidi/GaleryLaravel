<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  Illuminate\Pagination\Paginator;
use App\Gallery;
use App\User;
use App\Photo;
use Illuminate\Support\Facades\Auth;
use db;

class GalleryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['only' => ['my-galeries','store']]);
    }
    public function index()
    {
            $galleries = Gallery::with('photos','user')->orderBy('id', 'DESC')->take(10)->get();  
             return $galleries;
        
    }

    public function myGalleries(){

        //   if(Auth::check()){
            return Gallery::with('photos','user')->where('user_id',auth()->user()->id)->orderBy('id', 'DESC')->take(10)->get();
        // }
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $this->validate($request,
        [
            'name' => 'required|min:2|max:255',
            'description' => 'string|max:1000', 
            'photos' => 'required|array|min:1',
            'photos.*' => ['regex:/^(http)?s?:?(\/\/[^\‘]*\.(?:png|jpg|jpeg))/']
        ]);
        // \Log::info(print_r($request->all(),true));

        $gallery = Gallery::create([
            'name' => $request->get('name'),
            'description' => $request->get('description'),       
            'user_id' => auth()->user()->id,

        ]);
        $photos =[];
        foreach ($request->get('photos') as  $photo) {
        $photos[] = new Photo(['url' => $photo]);
        }
        $gallery->photos()->saveMany($photos);
        return $gallery;
        // Gallery::create($request->all());
    }


    public function show($id)
    {
        return Gallery::with('photos','user')->findOrFail($id);
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, Gallery $gallery)
    {
        $this->validate($request,
        [
            'name' => 'required|min:2|max:255',
            'description' => 'string|max:1000',      
        ]);
        
        $gallery->update($request->all());
        return $gallery;
    }

  
    public function destroy($id)
    {
        return Gallery::destroy($id);
    }
}
