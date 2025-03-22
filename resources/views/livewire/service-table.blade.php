@extends('layouts.app')

@section('content')
    <!-- Ton contenu de service-table ici -->

    <div class="container py-4">
        <h2>Tableau des services</h2>
        <br><br>

          <!-- Bouton pour rediriger vers la page de création d'un service -->
        <!--  <a href="{{ route('services.create') }}" class="btn btn-primary">  -->
        <a href="{{ route('tableau_service.create') }}" class="btn btn-primary">
            Créer un service
        </a>
        <br><br>
        <!-- Vérifier si la liste des services est vide -->
        @if ($services->isEmpty())
            <div class="alert alert-warning">
                <i class="bx bx-error-circle icon" ></i>
                Aucun service trouvé.
            </div>



        @else
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Surveillant</th>
                        @foreach ($jours as $jour => $date)
                            <th>{{ $jour }} <br> {{ $date }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            @foreach ($jours as $jour => $date)
                                @foreach (['00H' => '06H', '06H' => '13H', '13H' => '20H', '20H' => '24H'] as $heure_debut => $heure_fin)
                                    <td wire:click="toggleService({{ $user->id }}, '{{ $date }}', '{{ $heure_debut }}', '{{ $heure_fin }}')" class="clickable-cell">
                                        @php
                                            $service = $services->where('user_id', $user->id)
                                                                ->where('date_service', $date)
                                                                ->where('heure_debut', $heure_debut)
                                                                ->where('heure_fin', $heure_fin)
                                                                ->first();
                                        @endphp
                                        @if ($service)
                                            <span class="text-success">✔</span>
                                        @else
                                            <span class="text-danger">✖</span>
                                        @endif
                                    </td>
                                @endforeach
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <style>
        .clickable-cell {
            cursor: pointer;
            text-align: center;
            padding: 10px;
        }
        .clickable-cell:hover {
            background-color: #f0f0f0;
        }
    </style>
@endsection
