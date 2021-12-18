<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use Hash;
use Session;
use App\Models\AppUser;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index(){
        if(Auth::check())
        {
            if(Auth::user()->is_admin)
                return redirect()->intended('adminpage');
            else
                return redirect()->intended('userpage');
        }
        return view('auth.login');
    }

    public function doLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        $credentials = $request->only('email', 'password');
        if(Auth::attempt($credentials)){
            if(Auth::user()->is_admin)
                return redirect()->intended('adminpage')->withSuccess('Signed in');
            else
                return redirect()->intended('userpage')->withSuccess('Signed in');
        }
        return redirect('login')->withErrors([
            'login_fail' => 'login failed'
        ]);
    }

    public function registration()
    {
        return view('auth.registration');
    }


    public function customRegistration(Request $request)
    {
        

        $request->validate([
            'email' => 'required|email|unique:appusers',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6|same:password'
        ]);

        $data = $request->all();
        $check = $this->create($data);

        return redirect('login')->withSuccess('You have signed-in');
    }

    public function create(array $data)
    {
        return AppUser::create([
            'name' => $data['email'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'is_admin' => '0',
            'is_allowed' => '1'
        ]);
    }

    

    public function signOut(){
        Session::flush();
        Auth::logout();
        return Redirect('login');
    }
}
