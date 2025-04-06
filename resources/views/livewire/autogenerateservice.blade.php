<div>
<!-- resources/views/livewire/auto-generate-service.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Gestion des Services</h1>

        <!-- Formulaire de sélection des dates -->
        <div class="form-group">
            <label for="date_debut">Date de début :</label>
            <input type="date" id="date_debut" wire:model="date_debut" class="form-control">
        </div>

        <div class="form-group">
            <label for="date_fin">Date de fin :</label>
            <input type="date" id="date_fin" wire:model="date_fin" class="form-control">
        </div>

        <!-- Bouton pour générer les services -->
        <button wire:click="generate" class="btn btn-primary mt-3">Générer les services</button>

        <!-- Aperçu des services générés -->
        @if (!empty($services_preview))
            <h3 class="mt-4">Aperçu des services générés :</h3>
            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Heure de début</th>
                        <th>Heure de fin</th>
                        <th>Nom de l'agent</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($services_preview as $service)
                        <tr>
                            <td>{{ $service['date_service'] }}</td>
                            <td>{{ $service['heure_debut'] }}h</td>
                            <td>{{ $service['heure_fin'] }}h</td>
                            <td>{{ $service['nom_agent'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Bouton pour enregistrer les services -->
            <button wire:click="save" class="btn btn-success mt-3">Enregistrer les services</button>
        @endif

        <!-- Message de succès -->
        @if (session()->has('message'))
            <div class="alert alert-success mt-3">
                {{ session('message') }}
            </div>
        @endif
    </div>
@endsection
</div>
