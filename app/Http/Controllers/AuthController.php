<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // ==========================================
    // 1. HALAMAN LANDING
    // ==========================================
    public function showLanding()
    {
        return view('landing');
    }


    // ==========================================
    // 2. HALAMAN LOGIN
    // ==========================================
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect('/katalog');
        }

        return view('login');
    }


    // ==========================================
    // 3. PROSES LOGIN
    // ==========================================
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            return back()
                ->with('error', 'Email atau password salah!')
                ->withInput($request->only('email'));
        }

        // Cek password hash
        $passwordValid = Hash::check(
            $credentials['password'],
            $user->password
        );

        // Mendukung password akun lama yang belum di-hash
        if (
            !$passwordValid &&
            $credentials['password'] === $user->password
        ) {
            $passwordValid = true;

            // Ubah password menjadi hash
            $user->password = Hash::make($credentials['password']);
            $user->save();
        }

        if (!$passwordValid) {
            return back()
                ->with('error', 'Email atau password salah!')
                ->withInput($request->only('email'));
        }

        // Pastikan role akun valid
        if (!in_array($user->role, ['admin', 'staff'])) {
            return back()
                ->with('error', 'Role akun tidak valid. Hubungi administrator!');
        }

        // Login
        Auth::login($user);

        // Regenerasi session untuk keamanan
        $request->session()->regenerate();

        // Simpan informasi user
        session([
            'user_id' => $user->id,
            'user_name' => $user->name,
            'user_email' => $user->email,
            'user_role' => $user->role,
        ]);

        // Arahkan ke katalog
        if ($user->role === 'admin') {
            return redirect('/katalog')
                ->with('success', 'Selamat datang, Admin COURT 80!');
        }

        return redirect('/katalog')
            ->with('success', 'Selamat datang, Staff COURT 80!');
    }


    // ==========================================
    // 4. HALAMAN REGISTER
    // ==========================================
    public function showRegister()
    {
        if (Auth::check()) {
            return redirect('/katalog');
        }

        return view('register');
    }


    // ==========================================
    // 5. PROSES REGISTER
    // ==========================================
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        // Semua pendaftaran baru otomatis menjadi STAFF
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'staff',
        ]);

        // Login otomatis setelah register
        Auth::login($user);

        $request->session()->regenerate();

        session([
            'user_id' => $user->id,
            'user_name' => $user->name,
            'user_email' => $user->email,
            'user_role' => $user->role,
        ]);

        return redirect('/katalog')
            ->with('success', 'Akun Staff berhasil dibuat!');
    }


    // ==========================================
    // 6. LOGOUT
    // ==========================================
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')
            ->with('success', 'Berhasil keluar dari COURT 80!');
    }
}
