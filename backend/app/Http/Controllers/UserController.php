<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public function allUser()
    {
        $users =User::orderBy('id')->pluck('id');
        return response()->json($users);
    }
}
