<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware(['guest']);
    }
    public function index()
    {
        return view('auth.login');
    }
    public function login(Request $request)
    {
        $input = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);
        
        if (Auth::attempt($input)) {
            $request->session()->regenerate();
            return redirect()->intended(route('home'));
        }
        return redirect()->back()->with('error', 'Wrong username or password');
    }
    public function showRegisterForm()
    {
        return view('auth.register');
    }
    public function register(Request $request) {
        $input = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'phone' => 'required|numeric|unique:users',
            'password' => 'required|min:8|confirmed'
        ]);

        $input['password'] = Hash::make($input['password']);
        $created = User::create($input);
        if ($created)
            return redirect()->route('login.show')->with('success', 'Account created successfully.');
        return redirect('register')->withInput($login)->with('error', 'Failed to create account');
    }
}
