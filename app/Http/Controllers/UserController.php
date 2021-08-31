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
    ->with('user',$user);
  }

 public function showUser($id){
  
  $user = user::find($id);
 

 return view('users.show-user')
 ->with('user', $user);

   }
}
