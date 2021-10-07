<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Country;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ContractsController;
use App\Notifications\TwoFactorCode;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {

    }
    public function listUser()
    {
        $user = User::orderBy('id', 'desc')->get();


        return view('users.list-users')
            ->with('user', $user);
    }

    public function listKyc()
    {
        $user = User::orderBy('id', 'desc')->where([['verify', '0'], ['admin', '0']])->get();

        return view('users.list-kyc')
            ->with('user', $user);
    }

    public function showUser($id)
    {

        $user = user::find($id);
        $country = Country::where('id', $user->country_id)->first();

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
        $rules = [
            'user' => 'required'
        ];
        $messages = [
            'user.required' => 'Debe consultar un usuario primero.'
        ];
        $this->validate($request, $rules, $messages);

        $user = User::where('email', $request->user)->first();
     
        $user->type = 1;
             
        $user->save();

        return back()->with('success', 'usuario actualizado exitosamente');
    }

     public function administrators()
    {
       $user = User::orderBy('id', 'desc')->where('type', 1)->get();
    
       return view('wallet.administrators', compact('user'));
    }
    
    public function find(Request $request)
    {
        $user = User::find($request->id);

        return response()->json($user);
    }

    public function UpdateProfileFoto(Request $request)
    {
        return response()->json("hola");
    }

   public function administratorsCartera(Request $request)
    {

        $this->contratos = new ContractsController;
        if(isset($request->id)){
            $contratos = $this->contratos->contratos($request->id);
            $user = User::find($request->id);
        }else{
            $contratos = $this->contratos->contratos();
            $user = Auth::user();
        }
    
        $contracts = collect();
        if($user->type == 1){
            $referidos = $user->referidos;
           
            foreach ($referidos as $key => $value) {
                foreach($value->contracts as $contrac){
                $contracts->push($contrac);

                }
            }
            
        return view('contract.administrador', compact('referidos','contracts', 'contratos'));
        }else{
         return redirect()->back()->with('danger', 'No tiene permiso para esta seccion');
        }
    }

    public function updateProfile()
    {
        $user = Auth::user();

        return view('profile.updateProfile', compact('user'));
    }

    public function update(Request $request)
    {
        //dd($request->all());
        $user = Auth::user();

        $validate = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'dni' => ['required', 'string', 'max:255'],
            'birth' => ['required', 'date'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id, 'id')],
            'phone' => ['required', 'string', 'max:255'],
            'mobile_phone' => ['required', 'string', 'max:255'],
            'city_dni' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'country_id' => ['required', 'string', 'max:255'],
            'document_type' => ['required', 'string', 'max:255'],
            'district' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'photo' => ['mimes:jpg,jpeg,png'],
            'photo_dni_front' => [],
            'photo_dni_back' => [],
            'photo_document' => [],
            'selfie_document' => [],
        ]);

        if($request->country_id == 42){
            $request->validate([
                'department' => ['required', 'string', 'max:255'],
            ]);
        }
        //validamos las imagenes
        if((isset($request['photo']) && isset($request['photo_dni_front']) && (isset($request['photo_dni_back']) || $request['document_type'] < 2) && isset($request['selfie_document']) && isset($request['photo_document'])) || (isset($user->profile_photo_path) && isset($user->photo_dni_front) && (isset($user->photo_dni_back) || $user->document_type < 2) && isset($user->selfie_document) && isset($user->photo_document))){
            
            if(isset($request['photo'])){
                if(!is_string($request['photo'])){
                    $file = $request['photo'];
                    $nombre = time() . $file->getClientOriginalName();
                    $ruta = 'photo/' . $user->id . '/' . $nombre;
                    $user->profile_photo_path = $ruta;
                    $file->move(public_path('storage') .'/photo/'.$user->id, $nombre);
                }
            }
    
            // dd($request['photo_dni']);        
            
            if (isset($request['photo_dni_front'])) {
                if(!is_string($request['photo_dni_front'])){
                    $file = $request['photo_dni_front'];
                    $nombre = time() . $file->getClientOriginalName();
                    $ruta = 'photo_dni_front/' . $user->id . '/' . $nombre;
                    $user->photo_dni_front = $ruta;
                    $file->move(public_path('storage') .'/photo_dni_front/'.$user->id, $nombre);
                }
            }
    
            if (isset($request['photo_dni_back'])) {
                if(!is_string($request['photo_dni_back'])){
                    $file = $request['photo_dni_back'];
                    $nombre = time() . $file->getClientOriginalName();
                    $ruta = 'photo_dni_back/' . $user->id . '/' . $nombre;
                    $user->photo_dni_back = $ruta;
                    $file->move(public_path('storage') .'/photo_dni_back/'.$user->id, $nombre);
                }
            }
    
            if (isset($request['selfie_document'])) {
                if(!is_string($request['selfie_document'])){
                    $file = $request['selfie_document'];
                    $nombre = time() . $file->getClientOriginalName();
                    $ruta = 'selfie_document/' . $user->id . '/' . $nombre;
                    $user->selfie_document = $ruta;
                    $file->move(public_path('storage') .'/selfie_document/'.$user->id, $nombre);
                }
            }
    
            if (isset($request['photo_document'])) {
                if(!is_string($request['photo_document'])){
                    $file = $request['photo_document'];
                    $nombre = time() . $file->getClientOriginalName();
                    $ruta = 'photo_document/' . $user->id . '/' . $nombre;
                    $user->photo_document = $ruta;
                    $file->move(public_path('storage') .'/photo_document/'.$user->id, $nombre);
                }
            }
            $user->save();
            $user->update([
                'name' => $request['name'],
                'lastname' => $request['lastname'],
                'email' => $request['email'],
                'dni' => $request['dni'],
                'birth' => $request['birth'],
                'dni_expedition' => $request['dni_expedition'],
                'phone' => $request['phone'],
                'mobile_phone' => $request['mobile_phone'],
                'country_id' => $request['country_id'],
                'document_type' => $request['document_type'],
                'city_dni' => $request['city_dni'],
                'address' => $request['address'],
                'district' => $request['district'],
                'city' => $request['city'],
                'department' => $request['department'],
            ]);
            
    
            return redirect()->route('dashboard')->with('success', 'Perfil actualizado exitosmente');
        }else{
            return back()->withInput()->with('danger', 'Debe cargar todas las imagenes');
        }
        
        
    }

    public function updatePassword(Request $request)
   {
      $rules = [
         'mypassword' => 'required',
         'password' => 'required|confirmed|string|min:8'
      ];

      $messages = [
            'mypassword.required' => 'El campo mypassword es requerido',
            'password.required' => 'El campo password es requerido',
            'password.confirmed' => 'Las contraseñas no coinciden',
            'password.min' => 'El mínimo permitido son 8 caracteres'
      ];

      $validator = Validator::make($request->all(), $rules, $messages);

      if ($validator->fails()) {

         return back()->withErrors($validator);
      }else{
         if (Hash::check($request->mypassword, Auth::user()->password)) {

            $password = bcrypt($request->password);

            if (Hash::check($request->mypassword, $password)){

               return back()->with('danger', 'La nueva contraseña no puede ser igual a la anterior');
            }else{
               // dd($request->session()->has('password_hash_web'));
               $user = User::find(Auth::user()->id)->update(['password' => $password]);

               $user = auth('web')->getUser();
        
               $request->session()->forget('password_hash_web');
               Auth::guard('web')->login($user);

               return redirect()->route('dashboard')->with('success', "Contraseña cambiada con éxito");
            }
            
         }else{

            return back()->with('danger', 'Credenciales incorrectas');
         }
      }
   }

   public function verificados()
   {
       $user = User::orderBy('id', 'desc')->where([['verify', '1'], ['admin', '0']])->get();

        return view('users.list-kyc')
            ->with('user', $user);

   }
}

