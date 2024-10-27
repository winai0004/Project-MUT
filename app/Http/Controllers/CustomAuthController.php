<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CustomAuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function customLogin(Request $request, $status)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($status == 1 && $user->status == 1) {
                return redirect()->route('admin')->withSuccess('Signed in');
            } elseif ($status == 2 && $user->status == 2) {
                return redirect()->intended('/')->withSuccess('Signed in');
            } else {
                return redirect()->back()->withInput($request->only('email'))->withErrors([
                    'email' => 'User is not active or not found.',
                ]);
            }
        } else {
            return redirect()->back()->withInput($request->only('email'))->withErrors([
                'email' => 'Email or password is incorrect.',
            ]);
        }
    }

    public function registration()
    {
        return view('auth.register');
    }

    public function customRegistration(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $data = $request->all();
        $this->create($data);

        return redirect()->route('dashboard')->withSuccess('You have signed in');
    }

    public function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'status' => 2
        ]);
    }

    public function dashboard()
    {
        if (Auth::check()) {
            return view('dashboard');
        }
        return redirect()->route('login')->withSuccess('You are not allowed to access');
    }

    public function signOut()
    {
        Session::flush();
        Auth::logout();

        return redirect()->route('login');
    }
}
