@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Détails du Tableau de Service</h1>

        <p><strong>Date début :</strong> {{ $tableau->date_debut }}</p>
        <p><strong>Date fin :</strong> {{ $tableau->date_fin }}</p>
        <p><strong>Jours fériés :</strong></p>
        <ul>
            @foreach ($tableau->jour_ferie as $jour)
                <li>{{ \Carbon\Carbon::parse($jour)->format('l, j F Y') }}</li>
            @endforeach
        </ul>

        <a href="{{ route('tableau_service.index') }}" class="btn btn-secondary">Retour à la liste</a>
    </div>
@endsection
