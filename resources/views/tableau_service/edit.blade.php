@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Modifier le Tableau de Service</h1>

        <form action="{{ route('tableau_service.update', $tableau->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="date_debut" class="form-label">Date début</label>
                <input type="date" class="form-control" id="date_debut" name="date_debut" value="{{ $tableau->date_debut }}" readonly>
            </div>

            <div class="mb-3">
                <label for="date_fin" class="form-label">Date fin</label>
                <input type="date" class="form-control" id="date_fin" name="date_fin" value="{{ $tableau->date_fin }}" readonly>
            </div>

            <div class="mb-3">
                <label for="jour_ferie" class="form-label">Sélectionner les jours fériés</label>
                <select multiple class="form-control" id="jour_ferie" name="jour_ferie[]">
                    @foreach ($week as $jour)
                        <option value="{{ $jour }}" {{ in_array($jour, $tableau->jour_ferie) ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::parse($jour)->format('l, j F Y') }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-warning">Modifier</button>
        </form>
    </div>
@endsection
