<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use App\Models\User;

class UserController extends Controller
{
    // Affiche le formulaire d'inscription
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // Gère l'inscription de l'utilisateur
 
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = new User();
        $user->name = Crypt::encryptString($request->input('name'));
        $user->email = $request->input('email'); // Pas de cryptage ici pour l'email
        $user->password = Hash::make($request->input('password'));
        $user->save(); // Enregistrement de l'utilisateur dans la base de données

        Auth::login($user);

        return redirect()->route('index');
    }

    // Affiche le formulaire de connexion
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Gère la connexion de l'utilisateur
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return view ('posts.index');
        }

        return back()->withErrors(['email' => 'These credentials do not match our records.']);
    }

    // Déconnecte l'utilisateur
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    // Affiche le profil de l'utilisateur
    public function showProfile()
    {
        $user = Auth::user();
        // Décryptage du nom
        $user->name = Crypt::decryptString($user->name);
        return view('profile', compact('user'));
    }

    // Met à jour le profil de l'utilisateur
    // public function updateProfile(Request $request)
    // {
    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|string|email|max:255',
    //     ]);

    //     $user = Auth::user();
    //     $user->name = Crypt::encryptString($request->input('name'));
    //     $user->email = $request->input('email');
    //     $user->save();

    //     return redirect()->route('profile.show')->with('status', 'Profile updated!');
    // }
}
