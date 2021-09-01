<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{

    public function listUser()
    {
        $user = User::all();


        return view('users.list-users')
            ->with('user', $user);
    }

    public function showUser($id)
    {

        $user = user::find($id);

        
        return view('users.show-user')
            ->with('user', $user);
    }

    public function verifyUser($id)
    {   
        $user = user::find($id);

        $user->verify = '1';
        $user->save();

        return redirect()->back()
            ->with('success', 'El usuario ha sido verificado de manera exitosa !!!');    
    }
    public function denyUser($id)
    {
        $user = user::find($id);

        $user->verify = '2';
        $user->save();

        return redirect()->back()
            ->with('warning', 'Se ha rechazado la solicitud del usuario de manera exitosa');    
    }


}
