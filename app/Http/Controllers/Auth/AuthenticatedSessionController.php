<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Affiche la page de connexion.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Gère l'authentification.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Déconnecter tout utilisateur déjà connecté avant une nouvelle connexion
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Récupérer les identifiants
        $credentials = $request->only('email', 'password');

        // Vérifier si l'utilisateur existe
        $user = \App\Models\User::where('email', $credentials['email'])->first();

        if (!$user) {
            return back()->withErrors([
                'email' => "L'adresse e-mail ne correspond à aucun compte."
            ])->withInput(); // Réafficher les anciennes valeurs du formulaire
        }

        // Vérifier si le mot de passe est incorrect
        if (!Auth::attempt($credentials)) {
            return back()->withErrors([
                'password' => "Le mot de passe est incorrect."
            ])->withInput();
        }

        // Authentifier l'utilisateur
        Auth::login($user);

        // Régénérer la session après connexion
        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'));
    }

    /**
     * Déconnecte l'utilisateur.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $userId = Auth::id(); // Récupérer l'ID de l'utilisateur

        Auth::guard('web')->logout();

        // Invalider la session et supprimer la session de la base de données
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        DB::table('sessions')->where('user_id', $userId)->delete();

        return redirect('/login');
    }
}
