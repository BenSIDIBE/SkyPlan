@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Gestion du Tableau de Service</h2>


    <!-- Liste des tableaux de service -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Date</th>
                <th>Heure Début</th>
                <th>Heure Fin</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($tableaux as $tableau)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($tableau->date_service)->format('d/m/Y') }}</td>
                    <td>{{ $tableau->heure_debut }}</td>
                    <td>{{ $tableau->heure_fin }}</td>
                    <td>
                        <a href="{{ route('tableau_service.edit', $tableau->id) }}" class="btn btn-warning btn-sm">Modifier</a>
                        <form action="{{ route('tableau_service.destroy', $tableau->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Confirmer la suppression ?')">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">Aucun tableau de service trouvé pour cette semaine.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <a href="{{ route('tableau_service.create') }}" class="btn btn-success">Créer un tableau de service</a>
</div>
@endsection
