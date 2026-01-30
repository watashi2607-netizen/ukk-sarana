<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\Siswa;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login_simple');
    }

    public function login(Request $request)
    {
        try {
            $request->validate([
                'login_type' => 'required|in:admin,siswa',
            ]);

            if ($request->login_type === 'admin') {
                $request->validate([
                    'username' => 'required|string',
                    'password' => 'required|string',
                ]);

                // Login sebagai admin
                $admin = Admin::where('username', $request->username)->first();
                
                if (!$admin) {
                    return back()->withErrors(['login' => 'Username tidak ditemukan']);
                }
                
                if (!Hash::check($request->password, $admin->password)) {
                    return back()->withErrors(['login' => 'Password salah']);
                }

                // Clear old session
                session()->flush();
                // Set new session
                session(['user' => $admin, 'user_type' => 'admin']);
                // Force save
                session()->save();
                
                return redirect()->route('admin.dashboard');

            } elseif ($request->login_type === 'siswa') {
                $request->validate([
                    'nis' => 'required|string',
                    'kelas' => 'required|string',
                ]);

                // Login sebagai siswa
                $siswa = Siswa::where('nis', $request->nis)
                             ->where('kelas', $request->kelas)
                             ->first();

                if (!$siswa) {
                    \Log::info('Siswa login failed: data not found', ['nis' => $request->nis, 'kelas' => $request->kelas]);
                    return back()->withErrors(['login' => 'Data siswa tidak ditemukan']);
                }

                \Log::info('Siswa login successful', ['siswa_id' => $siswa->id, 'nis' => $siswa->nis]);

                // Clear old session
                session()->flush();
                // Set new session
                session()->put('user', $siswa);
                session()->put('user_type', 'siswa');
                // session()->save(); // Remove this, Laravel handles it automatically

                \Log::info('Session set for siswa', ['user_type' => session('user_type'), 'user_nis' => session('user')->nis ?? 'null']);

                return redirect()->route('siswa.dashboard');
            }

            return back()->withErrors(['login' => 'Tipe login tidak valid']);
        } catch (\Exception $e) {
            \Log::error('Login error', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return back()->withErrors(['login' => 'Terjadi kesalahan sistem']);
        }
    }

    public function logout(Request $request)
    {
        // Clear all session data
        session()->flush();
        session()->regenerate();
        
        // Redirect to login page with success message
        return redirect('/login')->with('success', '');
    }
}