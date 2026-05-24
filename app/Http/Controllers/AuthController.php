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
            'username' => $request->name,
            'email'    => $request->email,
            'password' => $request->password,
            'role'     => 'pendaki',
        ]);

        Auth::login($user);

        return redirect('/dashboard')
            ->with('success', 'Akun berhasil dibuat! Selamat datang di Mahameru Digital.');
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
            $existingUser = User::where('email', $googleUser->email)->first();

            if ($existingUser) {
                Auth::login($existingUser);
                return redirect()->intended('/dashboard');
            }

           $baseName = $googleUser->name;
            $finalName = $baseName;
            $counter = 1;

            while (User::where('name', $finalName)->exists()) {
                $finalName = $baseName . ' ' . $counter;
                $counter++;
            }

            $newUser = User::create([
                'name'     => $finalName, // Diubah ke 'name'
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

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
