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

    // public function customLogin(Request $request, $status)
    // {
    //     $request->validate([
    //         'email' => 'required',
    //         'password' => 'required',
    //     ]);
    
    //     $credentials = $request->only('email', 'password');
    
    //     if (Auth::attempt($credentials) || Auth::guard('employee')->attempt($credentials)) {
    //         $user = Auth::user();
    //         $useradmin = Auth::guard('employee')->user();

    //         if ($status == 1 && $useradmin->status == 1) {
    //             // return redirect()->route('admin')->withSuccess('Signed in');
    //             return redirect()->route('admin')->with([
    //                 'success' => 'Signed in',
    //                 'username' => Auth::guard('employee')->user()->username,
    //             ]);
    //         } elseif ($status == 2 && $user->status == 2) {
    //             return redirect()->intended('/')->withSuccess('Signed in');
    //         } else {
    //             Auth::logout(); // เพิ่มการออกจากระบบเมื่อสถานะไม่ตรงกัน
    //             return redirect()->back()->withInput($request->only('email'))->withErrors([
    //                 'email' => 'User is not active or not found.',
    //             ]);
    //         }
    //     } else {
    //         Auth::logout(); // เพิ่มการออกจากระบบเมื่อข้อมูลล็อกอินผิด
    //         return redirect()->back()->withInput($request->only('email'))->withErrors([
    //             'email' => 'Email or password is incorrect.',
    //         ]);
    //     }
    // }
    
    public function customLogin(Request $request, $status)
{
    $request->validate([
        'email' => 'required',
        'password' => 'required',
    ]);
    
    $credentials = $request->only('email', 'password');

    
    // พยายามเข้าสู่ระบบทั้งในฐานะ user และ employee
    if (Auth::attempt($credentials) && $status==2) {
        $user = Auth::user();
        // หากผู้ใช้เป็น user และ status ไม่ใช่ 2
        if ($user->status != 2) {
            Auth::logout(); // ออกจากระบบ
            return redirect()->back()->withInput($request->only('email'))->withErrors([
                'email' => 'ไม่มีบัญชีผู้ใช้งาน หรือบัญชีของคุณไม่สามารถใช้งานได้.',
            ]);
        }

        // หาก status == 2
        // return redirect()->intended('/')->withSuccess('Signed in');
        return redirect()->intended('/')->withSuccess('Signed in')->with('id', $user->id);
    }

    if (Auth::guard('employee')->attempt($credentials)) {
        $useradmin = Auth::guard('employee')->user();

        // ตรวจสอบว่า employee admin มีสถานะเป็น 1
        if ($status == 1 && $useradmin->status == 1) {
            return redirect()->route('admin')->with([
                'success' => 'Signed in',
                'username' => $useradmin->username,
                'department' => $useradmin->department_id,
            ]);
        }

        Auth::logout(); // ออกจากระบบเมื่อสถานะไม่ตรงกัน
        return redirect()->back()->withInput($request->only('email'))->withErrors([
            'email' => 'User is not active or not found.',
        ]);
    } else {
        Auth::logout(); // หากข้อมูลล็อกอินไม่ถูกต้อง
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

        return redirect()->route('login')->with('clearSessionStorage', true);
    }
}
