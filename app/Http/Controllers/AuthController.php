<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Redirect;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }
    public function register_view()
    {
        return view('auth.register');
    }
    public function login(Request $request)
    {
        // validate data
        $request->validate([
            'email' => 'required ',
            'password' => 'required ',
        ]);
        if (\Auth::attempt($request->only('email', 'password'))) {
            return redirect('home');
        }
        return Redirect('login')->withError('Invalid Login details. Try anagin...');

    }
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required|confirmed',
            
        ]);
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => \Hash::make($request->password)
        ]);

        if (\Auth::attempt($request->only('email', 'password'))) {
            return redirect('home');
        }
        return Redirect('register')->withError('Error');
    }
    public function home(){
        return view('home');
    }
    public function logout(){
        \Session::flush();
        \Auth::logout();
        return redirect('');
    }
}
