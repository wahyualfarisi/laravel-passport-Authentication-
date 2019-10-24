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
            'password' => 'required|min:6'
        ]);

        $user = User::create([
            'name' => $req->name,
            'email' => $req->email,
            'password' => bcrypt($req->password)
        ]);

        $token = $user->createToken('TutsForWeb')->accessToken;
        return response()->json(['token' => $token], 200);
    }


    public function show()
    {
        return 'great';
    }

}
