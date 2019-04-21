<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Gallery;
use  Illuminate\Pagination\Paginator;

class UserController extends Controller
{
    public function index()
    {
        return User::with('galleries.photos','comments')->orderBy('id', 'DESC')->take(10)->get();
    }

    public function show($id)
    {
        return User::with('galleries.photos','comments')->findOrFail($id);
    }
}
