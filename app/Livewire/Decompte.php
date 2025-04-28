<?php

namespace App\Livewire;

use Livewire\Component;

class Decompte extends Component
{
    public $id_user;
    public $date_service;
    public $heure_debut;
    public $heure_fin;
    public $id_tableauService;
    public $hte = 0;



    public function render()
    {
        return <<<'HTML'
    <div class="w-full h-full">
            <button wire:click="increment" class="w-full h-full">&nbsp;</button>
    </div>
HTML;
    }

    public function mount($id_user, $date_service, $heure_debut, $heure_fin, $id_tableauService, $hte):void
    {
        $this->id_tableauService = $id_tableauService;
        $this->id_user = $id_user;
        $this->date_service = $date_service;
        $this->heure_debut = $heure_debut;
        $this->heure_fin = $heure_fin;
    }   

    public function increment()
    {
        $this->hte++;
    }

}
