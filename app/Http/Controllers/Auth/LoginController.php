<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Quotation;
use Response;
use Illuminate\Support\Facades\Auth;
use App\User; 

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $login = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);
        if( !Auth::attempt($login)){
            return response(['message' => 'Invalid login creditials.']);
        }
        $accessToken = Auth::user()->createToken('authToken')->accessToken;
        
        return response(['user' => Auth::user(), 'access_token' => $accessToken]);
    }
}
