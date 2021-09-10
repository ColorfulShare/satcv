<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Country;
use Illuminate\Support\Facades\Auth;
use App\Notifications\TwoFactorCode;

class UserController extends Controller
{
    public function __construct()
    {

    }
    public function listUser()
    {
        $user = User::all();


        return view('users.list-users')
            ->with('user', $user);
    }

    public function listKyc()
    {
        $user = User::where('verify', '0')->get();

        return view('users.list-kyc')
            ->with('user', $user);
    }

    public function showUser($id)
    {

        $user = user::find($id);
        $country = Country::where('id', $user->country_id);

        
        return view('users.show-user')
            ->with('country', $country)
            ->with('user', $user);
    }

    public function verifyUser($id)
    {   
        $user = user::find($id);

        $user->verify = '1';
        $user->status = '1';
        $user->save();

        return redirect()->route('users.list-kyc')
        ->with('success', 'El usuario ha sido verificado de manera exitosa !!!');    
    }

    public function denyUser(Request $request, $id)
    {
        $user = user::find($id);
        $user->msj_admin = $request->msj_admin;
        $user->save();

        return redirect()->route('users.list-kyc')
            ->with('warning', 'Se ha rechazado la solicitud del usuario de manera exitosa');    
    }

    public function two_factor_challenge()
    {
        return view('profile.two-factor-authentication-form');
    }

    public function sendMailFactorCode(Request $request)
    {
        
        $user = User::find($request->user);
    
        if($user->MailTwoFactorCode()){
            return response()->json(['success' => true, 'message' => 'Código de verificacion enviado al correo exitosamente']);
        }else{
            return response()->json(['success' => false, 'message' => 'Error al enviar el código de verificacion.']);
        }
            
    }

      public function cambiar_type(Request $request)
    {
            
        $user = User::find($request->id);
     
        $user->type = '1';
             
        $user->save();

        return back()->with('success', 'usuario actualizado exitosamente');
    }

     public function administrators()
    {

       $alluser = User::get();
       $user = User::where('type', '1')->get();
       return view('wallet.administrators', compact('user','alluser'))->with('user', $user)->with('alluser',$alluser);
    }
    
}
