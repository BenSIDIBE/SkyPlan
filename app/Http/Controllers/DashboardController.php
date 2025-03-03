<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Poste;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Récupérer le nombre total d'utilisateurs et de postes
        $Users = User::all();  // Récupère tous les utilisateurs
        $Postes = Poste::all();  // Récupère tous les postes

        // Passer les données à la vue
        return view('dashboard', compact('Users', 'Postes'));
    }
}
