<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Admin $admin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Admin $admin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admin $admin)
    {
        //
    }

    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');
        Log::info('Login attempt with credentials: ', $credentials); // Add logging

        if (Auth::guard('admin')->attempt($credentials)) {
            $admin = Auth::guard('admin')->user();
            Log::info('Login successful for user: ', ['id' => $admin->id_admin]);
            Session::put('admin_id', $admin->id_admin); // Ensure session is set
            return redirect()->route('dashboard')->with('success', '✅ Login berhasil!');
        }

        Log::info('Login failed');
        return redirect()->back()->with('error', '⚠️ Username atau password salah!');
    }

    /**
     * Handle register request
     */
    public function register(Request $request)
    {
        $request->validate([
            'nama_admin' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:tb_admin',
            'password' => 'required|string|min:6',
        ]);

        $admin = Admin::create([
            'nama_admin' => $request->nama_admin,
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ]);

        Log::info('Registration successful for user: ', ['id' => $admin->id_admin]);
        return redirect()->route('login')->with('success', '✅ Registrasi berhasil! Silakan login.');
    }
    
    /**
     * Handle logout request
     */
    public function logout()
    {
        Auth::guard('admin')->logout();
        Session::flush();
        return redirect()->route('login')->with('success', '✅ Logout berhasil!');
    }
}
