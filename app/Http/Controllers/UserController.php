<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Gallery;

class UserController extends Controller
{
    public function index()
    {
        return User::with('galleries','comments')->orderBy('id', 'DESC')->take(10)->get();
    }

    public function show($id)
    {
        return User::with('galleries','comments')->findOrFail($id);
    }
}
