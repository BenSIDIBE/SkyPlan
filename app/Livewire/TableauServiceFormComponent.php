<?php

namespace App\Livewire;

use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Component;

class TableauServiceFormComponent extends Component
{

    public  $semaines;
    public  $semaineSelectionnee;
    public  $week;
    public  $utilisateurs;
    public  $postes;

    public $semaine;
    public $jour_ferie = [];
    public $technicien_absent = [];
    public $permanence_tech = "";
    public $commandant_permanence = "";
    public $listeDate = [];

    public $rerender = false;

    public function mount($semaines ,$semaineSelectionnee ,$week ,$utilisateurs ,$postes): void
    {
          $this->semaines = $semaines;
          $this->semaineSelectionnee = $semaineSelectionnee;
          $this->week = $week;
          $this->utilisateurs = $utilisateurs;
          $this->postes = $postes;
          $this->semaine = $semaines[array_key_first($this->semaines)] ?? null;

    }
    function updateJoursFeries(): void
    {
        $debut  = Carbon::createFromFormat('d/m/Y', $this->semaine);
        $fin =  Carbon::createFromFormat('d/m/Y', $this->semaine)->addDays(6);
        $this->listeDate = [];
        while ($debut <= $fin) {
            $this->listeDate[] = $debut->format('d/m/Y');
            $debut->addDay();
        }
    }

    public function onSubmit(){
        dd(
            $this->semaine,
            $this->jour_ferie,
            $this->technicien_absent,
            $this->permanence_tech,
            $this->commandant_permanence,

        );
    }


    public function render(): View|Application|Factory|\Illuminate\View\View
    {
        return view('livewire.tableau-service-form-component',[
            'listeDate' => $this->listeDate,
        ]);
    }


}
