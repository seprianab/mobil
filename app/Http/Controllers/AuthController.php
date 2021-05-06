<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class AuthController extends Controller
{
    public function showLogin(){
        if(auth()->check()) return redirect()->route('dashboard');
        return view('login');
    }

    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if ($validator->fails()) return errorInputResponse($validator);

        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return errorResponse('user-not-found', 'Email or password is wrong.');
        }

        Auth::login($user, (boolean) $request->remember);
        return successDataResponse([
            'redirect' => route('dashboard'),
        ]);
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('login');
    }
}
