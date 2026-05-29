<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use Exception;

class AuthController extends Controller
{
    public function index()
    {
        return view('Login');
    }

    public function showRegister()
    {
        return view('Register');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            if (Auth::user()->role === 'admin') {
                return redirect()->intended('/admin/dashboard')
                    ->with('success', 'Selamat datang kembali, Pengelola Sistem!');
            }

            return redirect()->intended('/dashboard');
        }

        return back()
            ->withInput($request->only('email'))
            ->with('loginError', 'Email atau password salah, Yang Mulia!');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'username' => Str::slug($request->name), // Disarankan slug agar rapi
            'email'    => $request->email,
            'password' => Hash::make($request->password), // Pastikan di-hash!
            'role'     => 'pendaki',
        ]);

        Auth::login($user);

        return redirect('/dashboard')
            ->with('success', 'Akun berhasil dibuat! Selamat datang di Mahameru Digital.');
    }

    // --- GOOGLE LOGIN ---
    public function redirectToGoogle()
    {
        // Parameter 'prompt' => 'select_account' memaksa Google memunculkan pilihan akun
        return Socialite::driver('google')
            ->with(['prompt' => 'select_account'])
            ->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            $existingUser = User::where('email', $googleUser->email)->first();

            if ($existingUser) {
                Auth::login($existingUser);
                return redirect()->intended('/dashboard');
            }

            // Logika Nama
            $baseName = $googleUser->name;
            $finalName = $baseName;
            $counterName = 1;
            while (User::where('name', $finalName)->exists()) {
                $finalName = $baseName . ' ' . $counterName;
                $counterName++;
            }

            // Logika Username Unik
            $baseUsername = Str::slug($googleUser->name);
            $finalUsername = $baseUsername;
            $counterUser = 1;
            while (User::where('username', $finalUsername)->exists()) {
                $finalUsername = $baseUsername . $counterUser;
                $counterUser++;
            }

            $newUser = User::create([
                'name'     => $finalName,
                'username' => $finalUsername,
                'email'    => $googleUser->email,
                'password' => Hash::make(Str::random(16)),
                'role'     => 'pendaki',
            ]);

            Auth::login($newUser);
            return redirect()->intended('/dashboard');

        } catch (Exception $e) {
            return redirect('/login')
                ->with('loginError', 'Login Google gagal: ' . $e->getMessage());
        }
    }

    // --- LOGOUT ---
    public function logout(Request $request)
    {
        Auth::logout(); // Log out user

        $request->session()->invalidate(); // Hapus session
        $request->session()->regenerateToken(); // Buat token baru demi keamanan

        return redirect('/login')->with('success', 'Anda telah keluar dari singgasana. Sampai jumpa!');
    }
}
