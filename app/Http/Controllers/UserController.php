<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
  
    /* fonction listes des utilisateurs */
    public function accueilAdmin(){
        if(Auth::user()->role == 'user'){
            return view('dashboardUser');
        }
        else{
            $users = User::where('role','=','user')->orderBy('id', 'DESC')->get();
            return view('dashboard',[
                'users' => $users,
            ]);
        }
    }

    /* function de renvoie au formulaire user */
    public function create(){
        return view('user/form-user');
    } 

    /* fonction d ajout d un utilisateur */
    public function store(Request $request){
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make("passer1234"),
            'role' => 'user'
        ]);
        return redirect('/dashboard');
        
    }

    /* fonction de suppression d un utilisateur */
    public function delete(User $user){
        User::find($user)->delete();
        return redirect('/dashboard');
    }

}
