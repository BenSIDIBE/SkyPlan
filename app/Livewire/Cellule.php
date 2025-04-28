<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Cellule extends Component
{
    public $id_user;
    public $date_service;
    public $heure_debut;
    public $heure_fin;
    public $id_tableauService;

    public $hte = 0;

    public function mount($user_id, $date_service, $heure_debut, $heure_fin, $id_tableauService):void
    {
        $this->id_tableauService = $id_tableauService;
        $this->id_user = $user_id;
        $this->date_service = $date_service;
        $this->heure_debut = $heure_debut;
        $this->heure_fin = $heure_fin;
    }

    public function render()
    {
        return <<<'HTML'
    <div class="w-full h-full">
            <button wire:click="create" class="w-full h-full">&nbsp;</button>
    </div>
HTML;
    }

    public function create()
    {

       //dd($this->id_user, $this->date_service, $this->heure_debut, $this->heure_fin, $this->id_tableauService);
        $existingRecord = DB::table('services')
            ->where('id_user', $this->id_user)
            ->where('date_service', $this->date_service)
            ->where( 'heure_debut', $this->heure_debut)
            ->where('heure_fin', $this->heure_fin)
            ->first();

        if ($existingRecord) {
            DB::table('services')
                ->where('id', $existingRecord->id)
                ->update([
                    'heure_debut' => $this->heure_debut,
                    'heure_fin' => $this->heure_fin,
                    'updated_at' => now(),
                ]);
        } else {
            DB::table('services')->insert([
                'id_tableauService' => $this->id_tableauService,
                'id_user' => $this->id_user,
                'date_service' => $this->date_service,
                'heure_debut' => $this->heure_debut,
                'heure_fin' => $this->heure_fin,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
           /* $hte = $hte + ($heure_fin - $heure_debut);
            return $hte;*/
        }
    }
}
