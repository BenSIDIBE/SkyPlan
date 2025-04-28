<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Service;
use Carbon\Carbon;

class AutoGenerateService extends Component
{
    public $date_debut;
    public $date_fin;
    public $jours;
    public $surveillants;
    public $id_tableauService;
    public $services_preview = [];
    public $agents_rest = []; // Liste des agents en repos

    public function mount(Request $request): void
    {
        $this->id_tableauService = (int)$request->id_tableauService;
        $this->tableauService = TableauService::findOrFail($this->id_tableauService);
    
    }

    public function generate()
    {
        $this->validate([
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
        ]);

        $this->services_preview = [];
        $this->agents_rest = [];

        $debut = Carbon::parse($this->date_debut);
        $fin = Carbon::parse($this->date_fin);
        $agents = User::where('actif', true)->get();

        $index = 0;

        // Générer des services pour chaque jour de la semaine
        for ($date = $debut->copy(); $date->lte($fin); $date->addDay()) {
            $this->generateServiceForDay($date, $agents, $index);
            $index = ($index + 4) % $agents->count(); // Faire tourner les agents après chaque jour
        }
    }

    private function generateServiceForDay($date, $agents, $index)
    {
        // Définir les 4 créneaux horaires en fonction de l'heure de début à 13h
        $hours = [
            ['start' => '13', 'end' => '20'], // Premier créneau à partir de 13h
            ['start' => '20', 'end' => '24'],
            ['start' => '00', 'end' => '06'],
            ['start' => '06', 'end' => '13'],
        ];

        $available_agents = $agents->filter(function ($agent) {
            // Exclure les agents en repos
            return !in_array($agent->id, $this->agents_rest);
        });

        // Pour chaque créneau, attribuer un agent en rotation
        foreach ($hours as $i => $time) {
            $start_time = $date->copy()->setHour($time['start']);
            $end_time = $date->copy()->setHour($time['end']);

            // Sélectionner l'agent selon l'index (on fait tourner les agents en fonction des créneaux)
            $agent = $available_agents[$index % $available_agents->count()];

            // Ajouter le service généré à l'aperçu
            $this->services_preview[] = [
                'date_service' => $date->toDateString(),
                'heure_debut' => $start_time->format('H'), // Afficher seulement l'heure
                'heure_fin' => $end_time->format('H'),    // Afficher seulement l'heure
                'user_id' => $agent->id,
                'nom_agent' => $agent->name,
            ];

            // Ajouter l'agent en repos s'il descend à 06h
            if ($time['end'] == '06') {
                $this->agents_rest[] = $agent->id;
            }
        }

        // Assurer que le premier agent à 13h est celui qui n'a pas encore monté
        if (empty($this->agents_rest)) {
            // Si tous les agents sont en repos, on redémarre la rotation
            $this->agents_rest = [];
        }
    }

    public function save()
    {
        // Enregistrer tous les services en base
        foreach ($this->services_preview as $service) {
            Service::create([
                'id_tableauService' => $this->id_tableauService,
                'date_service' => $service['date_service'],
                'heure_debut' => $service['heure_debut'],
                'heure_fin' => $service['heure_fin'],
                'user_id' => $service['user_id'],
            ]);
        }

        $this->services_preview = [];
        session()->flash('message', 'Les services ont été enregistrés avec succès.');
    }

    public function render()
    {
        return view('livewire.auto-generate-service')
            ->extends('layouts.app')
            ->section('content')
            ->layoutData([
                'title' => 'Génération automatique de service',
                'description' => 'Générez automatiquement des services pour une période donnée.',
            ]);
    }

}
