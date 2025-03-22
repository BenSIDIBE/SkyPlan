<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\Service;
use App\Models\User;

class ServiceTable extends Component
{
    public $services;
    public $jours;
    public $users;

    public function mount()
    {
        $this->loadServices();
        $this->users = User::where('role', 'surveillant')->get();
        $this->jours = [
            'Lundi' => '2025-03-16',
            'Mardi' => '2025-03-17',
            'Mercredi' => '2025-03-18',
            'Jeudi' => '2025-03-19',
            'Vendredi' => '2025-03-20',
            'Samedi' => '2025-03-21',
            'Dimanche' => '2025-03-22',
        ];
    }

    public function loadServices()
    {
        $this->services = Service::all();
    }

    public function toggleService($user_id, $date_service, $heure_debut, $heure_fin)
    {
        $existingService = Service::where([
            'user_id' => $user_id,
            'date_service' => $date_service,
            'heure_debut' => $heure_debut,
            'heure_fin' => $heure_fin
        ])->first();

        if ($existingService) {
            $existingService->delete();
        } else {
            Service::create([
                'user_id' => $user_id,
                'date_service' => $date_service,
                'heure_debut' => $heure_debut,
                'heure_fin' => $heure_fin
            ]);
        }

        $this->loadServices(); // Rafraîchir la liste des services
    }

    public function render()
    {
        // Notez que vous n'avez pas besoin d'utiliser `layout()` ici, si vous avez déjà défini cela dans le layout de la vue
        return view('livewire.service-table')->layout('layouts.app');
    }
}
