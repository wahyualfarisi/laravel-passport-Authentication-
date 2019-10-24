<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class PassportController extends Controller
{
    public function register(Request $req)
    {
        $this->validate($req, [
            'name'  => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required'
        ]);

        $user = User::create([
            'name' => $req->name,
            'email' => $req->email,
            'password' => bcrypt($req->password),
            'role' => $req->role
        ]);

        $token = $user->createToken('APP')->accessToken;
        return response()->json(['token' => $token], 200);
    }

    public function login(Request $req)
    {
       $creadentials = [
           'email' => $req->email,
           'password' => $req->password
       ];
       
       if(auth()->attempt($creadentials) ){
           $token = auth()->user()->createToken('APP')->accessToken;
           return response()->json(['token' => $token], 200);
       }else{
           return response()->json(['error' => 'UnAuthorized Denied'], 401);
       }
    }

    public function details()
    {
        return response()->json(['user' => auth()->user()], 200);
        
    }
    




    

}
