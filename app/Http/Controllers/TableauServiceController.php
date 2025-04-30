<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Poste;
use Illuminate\Http\Request;
use App\Models\TableauService;
use App\Models\Service;



use Illuminate\Support\Facades\DB;

class TableauServiceController extends Controller
{
    /**
     * Affiche la liste des tableaux de service.
     */

     public $Service;
     
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
            $tableaux = TableauService::all();
            $services = Service::all();
            
            $semaines = [];
          //  dd($services[0]->date_service);
            // Générer les 5 prochaines semaines à partir de la semaine suivante
            for ($i = 1; $i <= 5; $i++) {
                $dateDebut = Carbon::now()->addWeeks($i)->startOfWeek();
                $dateFin = $dateDebut->copy()->endOfWeek();

                // Filtrer les services de cette semaine
                $servicesSemaine = $services->filter(function ($service) use ($dateDebut, $dateFin) {
                    return Carbon::parse($service->date_service)->between($dateDebut, $dateFin);
                });

                // Vérifier si la semaine est complète (28 services)
                if ($servicesSemaine->count() === 28) {
                    continue; // Ne pas ajouter cette semaine
                }
                    
                // Supprimer les services et tableaux de service de la semaine
                DB::transaction(function () use ($dateDebut, $dateFin) {
                    Service::whereBetween('date_service', [
                        $dateDebut->format('d-m-Y'), 
                        $dateFin->format('d-m-Y')
                    ])->delete();

                    TableauService::whereBetween('date_debut', [
                        $dateDebut->format('Y-m-d'),
                        $dateFin->format('Y-m-d')
                    ])->orWhereBetween('date_fin', [
                        $dateDebut->format('Y-m-d'),
                        $dateFin->format('Y-m-d')
                    ])->delete();
                    
                });

                // Ajouter la semaine à générer
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
                /*$da = $request->validate([
                    'semaine' => 'required|date',
                    'jour_ferie' => 'nullable|array',
                    'jour_ferie.*' => 'date',
                ]);*/

                $da = $request->all();

                $data = [
                    $da['semaine'] => [
                        "est_ferier" =>  false,
                        "travailleur_disponible" => [1, 2, 3, 5, 7]
                    ],
                ];
                dd($da);

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
