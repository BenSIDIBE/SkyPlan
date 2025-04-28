<?php

namespace App\Livewire;

use App\Models\TableauService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Livewire\Component;
use App\Models\User;
use App\Models\Poste;
use App\Models\Service;

class ServiceCreate extends Component
{
    public $jours;
    public $surveillants;
    public $id_tableauService;
   /* protected $listeners = ['serviceAdded' => 'recalculerDecompte'];
    public $decomptes = [];*/
    public $hte = 5;



    public TableauService $tableauService;

    public function mount(Request $request): void
    {
        $this->tableauService = TableauService::findOrFail((int)$request->id_tableauService);
        // Définir les jours et les surveillants
        // Récupérer la date actuelle
        /*$today = \Carbon\Carbon::today();*/

        // Calculer la date du lundi de la semaine prochaine
        /*$lundi_semaine_suivante = $today->addWeek()->startOfWeek(\Carbon\Carbon::MONDAY);*/

        $lundi_semaine_suivante = $this->tableauService->date_debut;
        // Récupérer l'id du tableau de service qui a pour date de début le lundi de la semaine prochaine
        $this->id_tableauService= \App\Models\TableauService::where('date_debut', $lundi_semaine_suivante->format('Y-m-d'))
            ->value('id');
        // Générer les jours de la semaine suivante
        $this->jours = [
            'Lundi' => $lundi_semaine_suivante->format('d-m-Y'),
            'Mardi' => $lundi_semaine_suivante->addDay()->format('d-m-Y'),
            'Mercredi' => $lundi_semaine_suivante->addDay()->format('d-m-Y'),
            'Jeudi' => $lundi_semaine_suivante->addDay()->format('d-m-Y'),
            'Vendredi' => $lundi_semaine_suivante->addDay()->format('d-m-Y'),
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

        $this->surveillants = $surveillants->toQuery()->whereNotIn('id',$this->tableauService->data["technicien_absent"])->get();
        
       /* foreach ($this->surveillants as $surveillant) {
            $this->recalculerDecompte($surveillant->id);
        }*/
        

    }

    public function render()
    {
        return view('livewire.service-create')->layout('layouts.app'); // Utiliser la méthode correcte pour Livewire
    }

    // Dans ton composant Livewire
public function storeService($userId, $dateService, $heureDebut, $heureFin, $id_tableauService)
{

    try {
        // Ici, tu fais l'enregistrement dans la base de données
        Service::create([
            'id_tableauService' => $id_tableauService,
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




/*
public function test(string $a){
    dd($a);
}
*/
/*
public function recalculerDecompte($userId)
{
    // Recharger tous les services de ce surveillant
    $services = Service::where('user_id', $userId)->get();

    $hte = 0;
    $hnn = 0;
    $hjf = 0;
    $hnf = 0;

    foreach ($services as $service) {
        $debut = (int) str_replace('H', '', $service->heure_debut);
        $fin = (int) str_replace('H', '', $service->heure_fin);

        $duree = $fin - $debut;
        if ($duree < 0) {
            $duree += 24;
        }

        $hte += $duree;

        if ($debut >= 20 || $fin <= 6) {
            $hnn += $duree;
        }

        if (in_array(date('N', strtotime($service->date_service)), [6, 7])) {
            $hjf += $duree;
            if ($debut >= 20 || $fin <= 6) {
                $hnf += $duree;
            }
        }
    }

    // Stocke le résultat dans un tableau lié à l'utilisateur
    $this->decomptes[$userId] = [
        'hte' => $hte,
        'hnn' => $hnn,
        'hjf' => $hjf,
        'hnf' => $hnf,
    ];
}*/
        public function increment(){
            $this->hte++;
        }

}
