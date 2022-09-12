<?php


namespace App\Http\Controllers;

//ini_set('max_execution_time', 600);

use App\Models\User;
use App\Exports\UsersExport;
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
            ->paginate(10);
            return view('dashboard',[
                'users' => $users,
            ]);
        }
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
        Alert::success('enregistrement de l utilisateur reussi');
        return redirect('/dashboard');
        
    }

    /* fonction de suppression d un utilisateur */
    public function delete(Request $request){
        $user = User::find($request->id);
        if($user->isDelete == "no"){
            $user->update([
                'isDelete'=>'yes',
            ]);
            Alert::info('archivage de l utilisateur reussi');
        }
        else if($user->isDelete == "yes"){
            $user->update([
                'isDelete'=>'no',
            ]);
            Alert::info('restauration de l utilisateur reussi');
        }
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
        Alert::info('modification de l utilisateur reussi');
        return redirect('/dashboard');
    }

    /* insertion en masse avec csv */
    public function storeCsv(Request $request){
        $file = $request->file('file');
        Excel::import(new UsersImport,$file);
        Alert::success(' importation du fichier excel reussi');
        return redirect('/dashboard');
    }

    /* fonction d exportation du fichier csv */
    public function exportCsv(Request $request){
        $date_debut = $request->start_date;
        $date_fin =  $request->end_date;;
        // dd($date_debut);
        return Excel::download(new UsersExport($date_debut,$date_fin),'users.pdf',\Maatwebsite\Excel\Excel::DOMPDF);
    }
    
}
