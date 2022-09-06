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
            $users = User::where('role','=','user')->where('isDelete','=','no')->orderBy('id', 'DESC')->simplePaginate(5);
            return view('dashboard',[
                'users' => $users,
            ]);
        }
    }

    /* function de renvoie au formulaire user */
    public function create(){
        return view('user/form-user',[
            'user' =>''
        ]);
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
            'role' => 'user',
            'isDelete'=>'no'
        ]);
        return redirect('/dashboard');
        
    }

    /* fonction de suppression d un utilisateur */
    public function delete(Request $request){
        $user = User::find($request->id);
        $user->update([
            'isDelete'=>'yes',
        ]);
        return redirect('/dashboard');
    }

    /* fonction d edition d un user */
    public function update($id, Request $request){
        $user = User::where('id', $id)->first();
       
        return view ('user/form-user',[
            'user'=>$user
        ]);
    }

    /* */
    public function edit(Request $request){
        $user = User::find($request->id);
        $user->update([
            'name'=>$request->name,
            'email'=>$request->email
        ]);
        return redirect('/dashboard');
    }

}
