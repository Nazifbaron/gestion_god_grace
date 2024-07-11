<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\ResetCode;
use App\Http\Requests\AdminRequest;
use App\Http\Requests\submitRequest;
use Exception;
use Carbon\Carbon;
use App\Notifications\SendEmailToAdmin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index(User $user){
        $admins = User::paginate(10);
        return view('admin/index',compact('admins'));
    }
    public function create(){
        return view('admin/create');
    }

    public function edit(User $user){
        return view('admin/edit',compact('user'));
    }

    //enrégistrer un admin et envoyer un email
    public function store(User $user,AdminRequest $request){
           // dd($request);
        try{
            
//logique de création de compte administrateur
            $user = new User();

            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make('default');

            $user->save();
//envoie de mail pour que l'utilisateur confirme son compte

//envoie de code de vérification
                if($user){

                    try{
                        ResetCode::where('email',$user->email)->delete();

                        $code = rand(1000,4000);
    
                        $data = [
                            'code'=> $code,
                            'email'=> $user->email
                        ];
                        ResetCode::create($data);
    
                        Notification::route('mail', $user->email)->notify(new SendEmailToAdmin($code,$user->email));
    
                        //redirection de l'utilisateur sur une nouvelle route
                        return redirect()->route(' ')->with('success_msg','l\'administrateur à bien été ajouter');
                   
                    }catch(Exception $e){
                        //dd($e);
                    }
                    
                    }


        }catch(Exception $e){
            dd($e);
           //throw new Exception('Une erreur est survenue lors de la création de cet administrateur');
        }
    }

    public function update(User $user,UpdateAdminRequest $request){
        try{
//logique de mise à jour de compte de l'administrateur
        }catch(Exception $e){
            throw new Exception('Une erreur est survenue lors de la modification de cet administrateur');
        }
    }

    public function delete(User $user){
        try{
            
            $connectAdmin = Auth::user()->id;

            if($connectAdmin != $user->id){
                $user->delete();
                return redirect()->back()->with('success_msg','Administrateurs supprimer avec success');
    
            }else{
                return redirect()->back()->with('error_msg','Impossible de supprimer son compte');
    
            }
            
//logique de suppression de compte de l'administrateur
        }catch(Exception $e){
            throw new Exception('Une erreur est survenue lors de la suppression de cet administrateur');
        }
    }

    public function defineAccess($email){
        $checkUserExist = User::where('email',$email)->first();

        if($checkUserExist){
            return redirect()->route('auth.validate-account', compact('email'));
        }else {
            return redirect()->route('login');
        }

    }

    public function submit(submitRequest $request){
        $user = User::where('email',$request->email)->first();

        if($user){
            $user->password = Hash::make($request->password);
            $user->email_verified_at = Carbon::now();
            $user->update();

            if ($user) {
               $existCode = ResetCode::Where('email',$user->email)->count();

                if ( $existCode >= 1) {
                    ResetCode::Where('email',$user->email)->delete();
                }
            }

            return redirect()->route('login')->with('success_msg','Vos accès on bien été définie');
                   
        }
    }
}
