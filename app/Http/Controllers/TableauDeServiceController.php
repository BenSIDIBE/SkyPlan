<?php

namespace App\Http\Controllers;

use App\Models\TableauDeService;
use Illuminate\Http\Request;
use App\Models\User;


class TableauDeServiceController extends Controller
{
    // Méthode pour afficher la liste des tableaux de service
    public function index()
    {
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



        return view('tableaux_de_service.index', compact('tableauxDeService', 'surveillants', 'maintenances'));
    }

    // Méthode pour afficher le formulaire de création d'un tableau de service
    public function create()
    {
        return view('tableaux_de_service.create');
    }

    // Méthode pour enregistrer un nouveau tableau de service
    public function store(Request $request)
    {
        // Validation des données envoyées
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'quart_id' => 'nullable|exists:quarts,id',
            'date_service' => 'required|date',
            'heure_debut' => 'array', // Validation pour le tableau
            'heure_fin' => 'array',   // Validation pour le tableau
            'week' => 'array',        // Validation pour le tableau
        ]);

        // Créer un nouveau tableau de service
        $tableauDeService = TableauDeService::create([
            'user_id' => $request->user_id,
            'quart_id' => $request->quart_id,
            'heure_debut' => $request->heure_debut ? json_encode($request->heure_debut) : null,
            'heure_fin' => $request->heure_fin ? json_encode($request->heure_fin) : null,
            'week' => $request->week ? json_encode($request->week) : null,
            'date_service' => $request->date_service,
        ]);

        return redirect()->route('tableau_de_services.index')
            ->with('success', 'Tableau de service ajouté avec succès.');
    }

    // Méthode pour afficher le formulaire d'édition d'un tableau de service
    public function edit($id)
    {
        $tableauDeService = TableauDeService::findOrFail($id);
        return view('tableaux_de_service.edit', compact('tableauDeService'));
    }

    // Méthode pour mettre à jour un tableau de service existant
    public function update(Request $request, $id)
    {
        // Validation des données envoyées
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'quart_id' => 'exists:quarts,id',
            'date_service' => 'required|date',
            'heure_debut' => 'required|array',
            'heure_fin' => 'required|array',
            'week' => 'array',
        ]);

        // Mettre à jour le tableau de service
        $tableauDeService = TableauDeService::findOrFail($id);
        $tableauDeService->update([
            'user_id' => $request->user_id,
            'quart_id' => $request->quart_id,
            'heure_debut' => $request->heure_debut ? json_encode($request->heure_debut) : null,
            'heure_fin' => $request->heure_fin ? json_encode($request->heure_fin) : null,
            'week' => $request->week ? json_encode($request->week) : null,
            'date_service' => $request->date_service,
        ]);

        return redirect()->route('tableau_de_services.index')
            ->with('success', 'Tableau de service mis à jour avec succès.');
    }

    // Méthode pour supprimer un tableau de service
    public function destroy($id)
    {
        $tableauDeService = TableauDeService::findOrFail($id);
        $tableauDeService->delete();

        return redirect()->route('tableau_de_services.index')
            ->with('success', 'Tableau de service supprimé avec succès.');
    }
}
