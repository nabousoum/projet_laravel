<?php


namespace App\Http\Controllers;

//ini_set('max_execution_time', 600);

use App\Models\User;
use App\Imports\UsersImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
  
    /* fonction accueil */
    public function accueil(){
        if(Auth::user()->role == 'user'){
            return view('dashboardUser');
        }
        else{
            $users = User::where('role','=','user')
            ->orderBy('id', 'DESC')
            ->simplePaginate(10);
            return view('dashboard',[
                'users' => $users,
            ]);
        }
    }

    /* function de renvoie au formulaire user */
    public function create(){
        return view('dashboard',[
            'user2' =>''
        ]);
        Alert::info('Message de Success', 'enregistrement de l utilisateur reussi');
        return redirect('/dashboard');
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
        Alert::success('Message de Success', 'enregistrement de l utilisateur reussi');
        return redirect('/dashboard');
        
    }

    /* fonction de suppression d un utilisateur */
    public function delete(Request $request){
        $user = User::find($request->id);
        $user->update([
            'isDelete'=>'yes',
        ]);
        Alert::error('Message de Success', 'suppression de l utilisateur reussi');
        return redirect('/dashboard');
    }

    /* fonction de restauration d un utilisateur */
    public function restore(Request $request){
        $user = User::find($request->id);
        $user->update([
            'isDelete'=>'no',
        ]);
        Alert::error('Message de Success', 'restauration de l utilisateur reussi');
        return redirect('/dashboard');
    }

    /* fonction d edition d un user get*/
    public function update($id, Request $request){
        $user = User::where('id', $id)->first();
       
        return view ('dashboard',[
            'user'=>$user
        ]);
    }

    /* fonction d edition de l utilisateur post*/
    public function edit(Request $request){
        $user = User::find($request->id);
        $user->update([
            'name'=>$request->name,
            'email'=>$request->email
        ]);
        Alert::info('Message de Success', 'modification de l utilisateur reussi');
        return redirect('/dashboard');
    }

    /* insertion en masse avec csv */
    public function storeCsv(Request $request){
        $file = $request->file('file');
        Excel::import(new UsersImport,$file);
        Alert::info('Message de Success', ' importation du fichier excel reussi');
        return redirect('/dashboard');
    }
    
}
