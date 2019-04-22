<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  Illuminate\Pagination\Paginator;
use App\Gallery;
use App\User;
use App\Photo;
use Illuminate\Support\Facades\Auth;
use DB;

class GalleryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['only' => ['my-galeries','store','update']]);
    }
    // public function index()
    // {
    // //  {      $galleries = Gallery::with(['comments', 'user'])->join('users', 'users.id','=','galleries.user_id')
    // //         ->select('galleries.*')
    // //         ->orderBy('id', 'DESC')
    // //         ->paginate(10);

    //         // $galleries =DB::table('galleries')
    //         // ->join('photos', 'galleries.id', '=', 'photos.id')
    //         // ->join('users', 'users.id', '=', 'galleries.user_id')
    //         // ->select('galleries.id','galleries.name','galleries.created_at','users.first_name', 'photos.url')
    //         // ->orderBy('id', 'DESC')
    //         // ->paginate(10);
           
    //     //  $galleries = DB::table('galleries')->with('photos','user')->orderBy('id', 'DESC')->paginate(10);
    //         $galleries = Gallery::with('photos','user','comments.user')->orderBy('id', 'DESC')->take(10)->get();  
    //         return $galleries;
        
    // }

    public function index(Request $request)
    {   
        return Gallery::getGalleries($request)
        ->orderBy('created_at', 'desc')
        ->get();
    }

    public function myGalleries(){

            return Gallery::with('photos','user','comments.user')->where('user_id',auth()->user()->id)->orderBy('id', 'DESC')->take(10)->get();  

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
    }


    public function show($id)
    {
        return Gallery::with('photos','user','comments.user')->findOrFail($id);
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {  
        $this->validate($request,
        [
            'name' => 'required|min:2|max:255',
            'description' => 'string|max:1000', 
            'photos' => 'required|array|min:1',
            'photos.*' => ['regex:/^(http)?s?:?(\/\/[^\‘]*\.(?:png|jpg|jpeg))/']
        ]);
        
        $gallery = Gallery::find($id);
        $photos = Photo::where('gallery_id', $request->id)->get();
        $photosInDb = [];
        foreach ($photos as $photo) {
            $photosInDb[] = $photo->url;
        }
      
        // $photosToDelete = array_diff($photosInDb, $request->photos);
        // $photosToSkip = array_diff($photosInDb, $photosToDelete);
        // $photosToCreate = array_diff($request->photos, $photosToDelete, $photosToSkip);
        // if (!empty($photosToDelete)) {
        //     photo::deleteMultiple($photosToDelete, $id);
        // }
        // if (!empty($photosToCreate)) {
        // Photo::create($photosInDb, $id);
        // }
        $gallery->update($request->all());
    }

 

  
    public function destroy($id)
    {
        return Gallery::destroy($id);
    }
}
