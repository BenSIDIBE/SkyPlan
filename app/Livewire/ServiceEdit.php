<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Service;
use App\Models\User;

class ServiceEdit extends Component
{
    public $service, $selectedUser, $date_service, $heure_debut, $heure_fin;

    protected $rules = [
        'selectedUser' => 'required|exists:users,id',
        'date_service' => 'required|date',
        'heure_debut' => 'required',
        'heure_fin' => 'required',
    ];

    public function mount($serviceId)
    {
        $this->service = Service::findOrFail($serviceId);
        $this->selectedUser = $this->service->user_id;
        $this->date_service = $this->service->date_service;
        $this->heure_debut = $this->service->heure_debut;
        $this->heure_fin = $this->service->heure_fin;
    }

    public function save()
    {
        $this->validate();

        $this->service->update([
            'user_id' => $this->selectedUser,
            'date_service' => $this->date_service,
            'heure_debut' => $this->heure_debut,
            'heure_fin' => $this->heure_fin,
        ]);

        session()->flash('message', 'Service modifié avec succès !');
        return redirect()->route('services.index');
    }

    public function render()
    {
        $users = User::all();
        return view('livewire.service-edit', compact('users'))->layout('layouts.app');
    }
}
