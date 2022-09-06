<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
     /* fonction page d accueil user */
     public function accueilUser(){
        return view('dashboardUser');
    }

    /* fonction page d accueil admin */
    public function accueilAdmin(){
        $users = User::where('role','=','user')->get();
        return view('dashboard',[
            'users' => $users,
        ]);
    }

    
}
