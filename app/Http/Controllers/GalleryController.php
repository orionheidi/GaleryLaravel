<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Gallery;

class GalleryController extends Controller
{
    public function index()
    {
        return Gallery::with('user')->paginate(10);
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
        ]);
        \Log::info(print_r($request->all(),true));
        return Gallery::create($request->all());
    }


    public function show($id)
    {
        return Gallery::findOrFail($id);
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
