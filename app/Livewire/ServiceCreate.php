<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Poste;
use App\Models\Service;

class ServiceCreate extends Component
{
    public $jours;
    public $surveillants;

    public function mount()
    {
        // Définir les jours et les surveillants
        // Récupérer la date actuelle
        $today = \Carbon\Carbon::today();

        // Calculer la date du lundi de la semaine prochaine
        $lundi_semaine_suivante = $today->addWeek()->startOfWeek(\Carbon\Carbon::MONDAY);

        // Générer les jours de la semaine suivante
        $this->jours = [
            'Lundi' => $lundi_semaine_suivante->format('d-m-Y'),
            'Mardi' => $lundi_semaine_suivante->addDay()->format('d-m-Y'),
            'Mercredi' => $lundi_semaine_suivante->addDay()->format('d-m-Y'),
            'Jeudi' => $lundi_semaine_suivante->addDay()->format('d-m-Y'),
            'Vendredi' => $lundi_semaine_suivante->addDay()->format('Y-m-d'),
            'Samedi' => $lundi_semaine_suivante->addDay()->format('d-m-Y'),
            'Dimanche' => $lundi_semaine_suivante->addDay()->format('d-m-Y'),
        ];


        $posteSurveillanceId = Poste::where('nom', 'Technicien de surveillance')->value('id');
        $posteMaintenanceId = Poste::where('nom', 'Technicien de maintenance')->value('id');

        // Récupérer les Techniciens de surveillance
        $surveillants = User::where('poste_id', $posteSurveillanceId)->get();

        // Si le nombre de Techniciens de surveillance est inférieur à trois, ajouter les Techniciens de maintenance
        if ($surveillants->count() < 3) {
            $techniciens_maintenance = User::where('poste_id', $posteMaintenanceId)->get();
            $surveillants = $surveillants->merge($techniciens_maintenance); // Fusionner les deux collections
        }

        // Assigner la collection finale des surveillants
        $this->surveillants = $surveillants;
    }

    public function render()
    {
        return view('livewire.service-create')->layout('layouts.app'); // Utiliser la méthode correcte pour Livewire
    }

    // Dans ton composant Livewire
public function storeService($userId, $dateService, $heureDebut, $heureFin)
{

    try {
        // Ici, tu fais l'enregistrement dans la base de données
        Service::create([
            'user_id' => $userId,
            'date_service' => $dateService,
            'heure_debut' => $heureDebut,
            'heure_fin' => $heureFin,
        ]);

        // Optionnel: Tu peux envoyer une notification ou un message de succès
        session()->flash('message', 'Service ajouté avec succès!');
    } catch (\Exception $e) {
        // Gérer l'erreur (ex: message d'erreur)
        session()->flash('error', 'Erreur lors de l\'ajout du service!');
    }
}
public function test(string $a){
    dd($a);
}


}
