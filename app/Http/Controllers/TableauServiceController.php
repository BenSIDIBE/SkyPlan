<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Poste;
use Illuminate\Http\Request;
use App\Models\TableauService;

class TableauServiceController extends Controller
{
    /**
     * Affiche la liste des tableaux de service.
     */
    public function index(Request $request)
    {
        // Récupérer tous les tableaux de service
        $tableaux = TableauService::all();

        return view('tableau_service.index', compact('tableaux'));
    }

    /**
     * Affiche le formulaire de création du tableau de service.
     */
    public function create(Request $request)
    {
        // Générer les 5 prochaines semaines à partir de la semaine suivante
        $semaines = [];
        for ($i = 1; $i <= 5; $i++) { // On commence à partir de la semaine suivante
            $dateDebut = Carbon::now()->addWeeks($i)->startOfWeek();
            $dateFin = $dateDebut->copy()->endOfWeek();
            $semaines[$dateDebut->format('d/m/Y')] = "Du " . $dateDebut->format('d/m/Y') . " au " . $dateFin->format('d/m/Y');
        }

        // Récupérer la semaine sélectionnée par défaut, ou celle envoyée via la requête GET
        $semaineSelectionnee = $request->get('semaine', Carbon::now()->addWeek()->startOfWeek()->format('Y-m-d'));

        // Récupérer les jours de la semaine sélectionnée
        $debutSemaine = Carbon::parse($semaineSelectionnee)->startOfWeek();
        $week = [];
        for ($i = 0; $i < 7; $i++) {
            $week[] = $debutSemaine->copy()->addDays($i)->format('Y-m-d');
        }

        // Si la requête est une requête AJAX, retourner les jours en JSON
        if ($request->ajax()) {
            return response()->json(['jours' => $week]);
        }
        $utilisateurs = User::all();
        $postes = Poste::all();

        // Retourner la vue avec les variables nécessaires
        return view('tableau_service.create', compact('semaines', 'semaineSelectionnee', 'week', 'utilisateurs', 'postes'));
    }

    /**
     * Enregistre un nouveau tableau de service.
     */
    public function store(Request $request)
    {
        // Validation des données
        $request->validate([
            'semaine' => 'required|date',
            'jour_ferie' => 'nullable|array',
            'jour_ferie.*' => 'date',
        ]);

        $data = [
            "" => [
                "est_ferier" =>  false,
                "travailleur_disponible" => [1, 2, 3, 5, 7]
            ],
        ];

        // Créer un tableau de service basé sur la semaine sélectionnée
        TableauService::create([
            'date_debut' => Carbon::parse($request->input('semaine'))->startOfWeek(),
            'date_fin' => Carbon::parse($request->input('semaine'))->endOfWeek(),
            'jour_ferie' => $request->input('jour_ferie', []),
        ]);

        return redirect()->route('services.create')->with('success', 'Tableau de service créé avec succès.');
    }

    /**
     * Affiche un tableau de service spécifique.
     */
    public function show($id)
    {
        $tableau = TableauService::findOrFail($id);
        return view('tableau_service.show', compact('tableau'));
    }

    /**
     * Affiche le formulaire d'édition d'un tableau de service.
     */
    public function edit($id)
    {
        $tableau = TableauService::findOrFail($id);
        return view('tableau_service.edit', compact('tableau'));
    }

    /**
     * Met à jour un tableau de service existant.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'jour_ferie' => 'nullable|array',
            'jour_ferie.*' => 'date',
        ]);

        $tableau = TableauService::findOrFail($id);
        $tableau->update([
            'jour_ferie' => $request->input('jour_ferie', []),
        ]);

        return redirect()->route('tableau_service.index')->with('success', 'Tableau de service mis à jour avec succès.');
    }

    /**
     * Supprime un tableau de service.
     */
    public function destroy($id)
    {
        TableauService::findOrFail($id)->delete();
        return redirect()->route('tableau_service.index')->with('success', 'Tableau de service supprimé.');
    }
}
