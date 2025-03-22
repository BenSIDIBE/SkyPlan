@extends('layouts.app')

@section('content')


<div class="container py-4">
    <h3>Modifier un service</h3>

    <form wire:submit.prevent="save">
        <div class="form-group">
            <label for="user">Surveillant</label>
            <select wire:model="selectedUser" id="user" class="form-control">
                <option value="">Sélectionner un surveillant</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
            @error('selectedUser') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="date_service">Date</label>
            <input type="date" wire:model="date_service" id="date_service" class="form-control">
            @error('date_service') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="heure_debut">Heure début</label>
            <input type="time" wire:model="heure_debut" id="heure_debut" class="form-control">
            @error('heure_debut') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="heure_fin">Heure fin</label>
            <input type="time" wire:model="heure_fin" id="heure_fin" class="form-control">
            @error('heure_fin') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="btn btn-primary mt-3">Modifier le service</button>
        <a href="{{ route('services.index') }}" class="btn btn-secondary mt-3">Annuler</a>
    </form>

    @if (session()->has('message'))
        <div class="alert alert-success mt-3">
            {{ session('message') }}
        </div>
    @endif
</div>
@endsection
