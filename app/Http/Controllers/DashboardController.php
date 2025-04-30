<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Poste;
/*juste pour la capture */
use App\Models\TableauDeService;
/*juste pour la capture */
use Illuminate\Http\Request;
use App\Models\Service;

class DashboardController extends Controller
{
    public function index()
    {
        // Récupérer le nombre total d'utilisateurs et de postes
        $Users = User::all();  // Récupère tous les utilisateurs
        $Postes = Poste::all();  // Récupère tous les postes
        $Services = Service::all();  // Récupère tous les services

/* juste pour la capture */
        $tableauxDeService = TableauDeService::all();
        // Récupération des techniciens de surveillance
        $surveillants = User::whereHas('poste', function ($query) {
            $query->where('nom', 'Technicien de surveillance');
        })->get()->sortBy('name');

        // Si moins de 3 surveillants, on ajoute des techniciens de maintenance
        if ($surveillants->count() < 3) {
            // Calcul du nombre de techniciens manquants
            $manque = 3 - $surveillants->count();

            // Récupérer les techniciens de maintenance pour compléter
            $maintenances = User::whereHas('poste', function ($query) {
                $query->where('nom', 'Technicien de maintenance');
            })->take($manque)->get()->sortBy('name');
        } else {
            $maintenances = collect();  // Pas besoin d'ajouter de maintenances si on a déjà 3 surveillants
        }
/*juste pour la capture */







        // Passer les données à la vue
        return view('dashboard', compact('Users', 'Postes', 'tableauxDeService', 'surveillants', 'maintenances','Services'));
    }
}
