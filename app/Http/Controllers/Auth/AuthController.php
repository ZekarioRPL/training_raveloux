<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function onLogin(Request $request)
    {
        # validate
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        # check email
        $user = DB::table('view_data_users')
            ->where('email', $request->email)
            ->select('*')
            ->whereNull('deleted_at')
            ->first();
        if(!$user) {
            return back()->withInput()->withErrors(['email' => "Don't can find your email."]);
        }

        # check password
        $checkPassword = Hash::check($request->password, $user->password);
        if(!$checkPassword) {
            return back()->withInput()->withErrors(['password' => 'Password is wrong']);
        }

        # auth
        Auth::loginUsingId($user->id);

        # return
        return redirect()->route('dashboard');
    }

    public function logout()
    {
        # logout
        Auth::logout();

        # return
        return redirect()->route('dashboard');
    }
    
}
