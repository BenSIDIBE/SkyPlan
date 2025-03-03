<?php


namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Poste;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Afficher tous les utilisateurs
    public function index()
    {
        $users = User::paginate(10);
        $postes = Poste::all();
        $roles = Role::all();
        return view('users.index', compact('users', 'postes', 'roles'));
    }

    // Afficher le formulaire de création
    public function create()
    {

        return view('users.create', compact('postes', 'roles'));
    }

    // Sauvegarder un nouvel utilisateur
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8',
            'numero' => 'nullable|string|max:15',
            'matricule' => 'nullable|string|max:50|unique:users',
            'poste_id' => 'nullable|exists:postes,id',
            'role_id' => 'nullable|exists:roles,id',
        ]);

        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->numero = $request->input('numero');
        $user->matricule = $request->input('matricule');
        $user->poste_id = $request->input('poste_id');
        $user->role_id = $request->input('role_id');
        $user->save();


        session()->flash('success', 'Utilisateur ajouté avec succès');
        return redirect()->route('users.index')->with('success', 'Utilisateur ajouté avec succès');
    }

    // Afficher le formulaire d'édition
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    // Mettre à jour un utilisateur
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'numero' => 'nullable|string|max:15',
            'matricule' => 'nullable|string|max:50|unique:users,matricule,' . $id,
            'poste_id' => 'nullable|exists:postes,id',
            'role_id' => 'nullable|exists:roles,id',
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->numero = $request->input('numero');
        $user->matricule = $request->input('matricule');
        $user->poste_id = $request->input('poste_id');
        $user->role_id = $request->input('role_id');

        if ($request->filled('password')) {
            $user->password = bcrypt($request->input('password'));
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'Utilisateur mis à jour avec succès');
    }


    // Supprimer un utilisateur
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        session()->flash('success', 'Utilisateur supprimé avec succès');
        return redirect()->route('users.index')->with('success', 'Utilisateur supprimé avec succès');
    }
}
