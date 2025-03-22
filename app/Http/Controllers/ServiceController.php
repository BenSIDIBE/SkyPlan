<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\User;
use Carbon\Carbon;


class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */


/*  
    public function index()
    {
        // Récupérer la date actuelle et définir la plage de la semaine (du lundi au dimanche)
        $startOfWeek = now()->startOfWeek(); // Premier jour de la semaine (lundi)
        $endOfWeek = now()->endOfWeek(); // Dernier jour de la semaine (dimanche)

        // Récupérer tous les services de la semaine actuelle
        $services = Service::whereBetween('date_service', [$startOfWeek, $endOfWeek])
            ->get();

        // Récupérer tous les user_id uniques qui ont des services dans la semaine actuelle
        $userIds = $services->pluck('user_id')->unique();

        // Récupérer les utilisateurs (surveillants) en fonction des user_ids obtenus
        $surveillants = User::whereIn('id', $userIds)->get();

        // Calculer les jours de la semaine et leurs dates
        $jours = [];
        for ($i = 0; $i < 7; $i++) {
            $jour = $startOfWeek->copy()->addDays($i);
            $jours[$jour->locale('fr')->dayName] = $jour->format('Y-m-d'); // Jour et date
        }


        // Retourner la vue avec les données nécessaires
        return view('services.index', compact('surveillants', 'services', 'jours'));
    }





/*
    public function create()
    {
        // Calculer la date du lundi de la semaine suivante
        $dateActuelle = Carbon::now();
        $lundiProchain = $dateActuelle->addWeek()->startOfWeek();

        // Créer un tableau des jours avec leurs dates pour la semaine suivante
        $jours = [
            'Lundi' => $lundiProchain->format('d/m/Y'),
            'Mardi' => $lundiProchain->addDay()->format('d/m/Y'),
            'Mercredi' => $lundiProchain->addDay()->format('d/m/Y'),
            'Jeudi' => $lundiProchain->addDay()->format('d/m/Y'),
            'Vendredi' => $lundiProchain->addDay()->format('d/m/Y'),
            'Samedi' => $lundiProchain->addDay()->format('d/m/Y'),
            'Dimanche' => $lundiProchain->addDay()->format('d/m/Y'),
        ];

        // Récupérer les surveillants
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
        // Si une requête AJAX est envoyée, renvoyer les données en JSON
        if (request()->ajax()) {
            return response()->json([
                'maintenances' => $maintenances,
                'surveillants' => $surveillants,
                'jours' => $jours,
            ]);
        }

        // Transmettre les variables à la vue
        return view('services.create', compact('maintenances', 'surveillants', 'jours'));
    }




    /**
     * Show the form for creating a new resource.
     */


    /**
     * Store a newly created resource in storage.
     */
   /* public function store(Request $request)
    {
        try {
            // Validation des données
            $request->validate([
                'user_id' => 'required|exists:users,id',
                'date_service' => 'required|string',
                'heure_debut' => 'required|string',
                'heure_fin' => 'required|string',
            ]);

            // Convertir la date en format valide
            $dateService = Carbon::createFromFormat('l d/m/Y', $request->date_service)->format('Y-m-d');

            // Créer un service
            $service = Service::create([
                'user_id' => $request->user_id,
                'date_service' => $dateService,
                'heure_debut' => $request->heure_debut,
                'heure_fin' => $request->heure_fin,
            ]);

            return response()->json([
                'success' => true,
                'service_id' => $service->id
            ]);
        } catch (\Exception $e) {
            // Gestion des erreurs et renvoi d'une réponse JSON
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400); // Erreur 400 en cas d'exception
        }
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy($id)
    {
        $service = Service::find($id);

        if ($service) {
            $service->delete();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 404);
    }
}
