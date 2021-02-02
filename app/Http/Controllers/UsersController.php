<?php

namespace App\Http\Controllers;
use App\models\User;
use App\models\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;




class UsersController extends Controller
{
    public function __construct(){
    }

    function index(Request $request){
            $users = User::all();
            return $users;
    }

    function registrer(Request $request){
        $user = new User;
        $user->nombre = $request->nombre;
        $user->apellido_p = $request->apellido_p;
        $user->apellido_m = $request->apellido_m;
        $user->usuario = $request->usuario;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->empresa_id = $request->empresa_id;
        $user->cedula = $request->cedula;
        $user->cargo = $request->cargo;
        $user->telefono = $request->telefono;
        $user->celular = $request->celular;
        $user->deleted = 0;

        if ($user->save()) {
            return response()->json([
                'response' => 'usuario creado correctamente',
                'usuario' => $user
            ],201);
        }
        return response()->json([
                'response' => 'error al registrar al usuario'
            ],404);
    }

    function login(Request $request){
        $user = User::where('email',$request->email)->first();
        if ($user && Hash::check($request->password,$user->password)){
            $user->api_token = Str::random(32);
            if ($user->save()) {
                return response()->json([
                    'response' => 'Bienvenido',
                    'usuario' => $user->api_token
                ],201);
            }

            // return $user;
        }
        return response()->json([
                'response' => 'el usuario o la contraseña son incorrectos'
            ],404);
    }

    function logout(){
        $user=Auth()->user();
        $user->api_token=null;
        if ($user->save()) {
            return response()->json([
                'response' => 'Sesion cerrada'
            ],404);
        }
    }

    function empresa(Request $request){
        $empresa = Empresa::all();
        $user=Auth()->user();
        $user = User::where('empresa_id', $user->empresa_id)->get();

        return $user;

    }


}
