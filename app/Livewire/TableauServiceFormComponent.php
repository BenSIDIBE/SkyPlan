<?php

namespace App\Livewire;

use App\Models\TableauService;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Component;
use App\Models\Service;

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

    public bool $isAutomatic = false;

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



        try {
            \DB::beginTransaction();
            $this->validate([
                'semaine' => 'required',
                'jour_ferie' => 'array',
                'technicien_absent' => 'array',
                'permanence_tech' => 'string',
                'commandant_permanence' => 'string',
            ]);

            $data = [
                'semaine' => $this->semaine,
                'jour_ferie' => $this->jour_ferie,
                'technicien_absent' => $this->technicien_absent,
                'permanence_tech' => $this->permanence_tech,
                'commandant_permanence' => $this->commandant_permanence,
            ];

          //  dd($data);
            $res = TableauService::create([
                'date_debut' => Carbon::createFromFormat('d/m/Y', $this->semaine),
                'date_fin' => Carbon::createFromFormat('d/m/Y', $this->semaine)->addDays(6),
                'week' => $this->week,
                'jour_ferie' => $this->jour_ferie,
                'data' => $data,
            ]);
            \DB::commit();
            if ($res) {
                \Log::info('TableauService created successfully: ' . $res->id);
                if ($this->isAutomatic){
                    return to_route('auto-generate-service')
                        ->with('success', 'Données enregistrées avec succès !');
                }
                return to_route('services.create', ['id_tableauService' => $res->id])
                    ->with('success', 'Données enregistrées avec succès !');
            } else {
                return back()->with('error', 'Erreur lors de l\'enregistrement des données.');
            }

        } catch (\Exception $e) {
            \Log::error('Error saving data: ' . $e->getMessage());
            \DB::rollBack();
            // Handle the exception
        }

    }


    public function render(): View|Application|Factory|\Illuminate\View\View
    {
        return view('livewire.tableau-service-form-component',[
            'listeDate' => $this->listeDate,
        ]);
    }


}
