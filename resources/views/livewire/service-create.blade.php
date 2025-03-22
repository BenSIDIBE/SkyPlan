@extends('layouts.app') <!-- Spécifier le layout ici -->

@section('content')
    <style>
        th, td {
            border: 1px solid black;
            padding: 0px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            text-align: center;
        }
        .clickable {
            cursor: pointer;
        }
    </style>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <div class="container py-4">
        <div class="d-flex justify-between items-center mb-3">
            <h2>Tableau de Service</h2>
        </div>

        <div class="container py-4">
            <div class="d-flex justify-between items-center mb-3">
                <h2>Tableau de Service</h2>
            </div>

            <div class="bg-white shadow rounded-lg overflow-auto">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-200 text-gray-700 uppercase text-sm">
                            <th rowspan="1" class="px-4 py-2">Jour et date</th>
                            @foreach ($jours as $jour => $date)
                                <th colspan="4" class="px-4 py-2">{{ $jour }} <br> {{ $date }}</th>
                            @endforeach
                            <th colspan="4" rowspan="2" class="px-4 py-2">Décomptes <br> des Heures</th>
                        </tr>
                        <tr class="bg-gray-100 text-gray-700 text-sm">
                            <th class="px-4 py-2">Heure de Début</th>
                            @for ($i = 0; $i < 7; $i++)
                                <th>00H</th>
                                <th>06H</th>
                                <th>13H</th>
                                <th>20H</th>
                            @endfor
                        </tr>
                        <tr class="bg-gray-100 text-gray-700 text-sm">
                            <th class="px-4 py-2">Heure de Fin</th>
                            @for ($i = 0; $i < 7; $i++)
                                <th>06H</th>
                                <th>13H</th>
                                <th>20H</th>
                                <th>24H</th>
                            @endfor
                            <th>HTE</th>
                            <th>HNN</th>
                            <th>HJF</th>
                            <th>HNF</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($surveillants as $user)
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="font-bold px-4 py-2">{{ $user->name }}</td>

                            @foreach ($jours as $jour => $date)
                                <td
                                    class="clickable cell"
                                    data-user-id="{{ $user->id }}"
                                    data-date="{{ $date }}"
                                    data-heure-debut="00H"
                                    data-heure-fin="06H"
                                    >@livewire('cellule', ['user_id' =>$user->id, 'date_service' => $date, 'heure_debut'=>'00h',
                                    'heure_fin'=>"06H"], key($user->id))

                                </td>
                                <td
                                class="clickable cell"
                                data-user-id="{{ $user->id }}"
                                data-date="{{ $date }}"
                                data-heure-debut="06H"
                                data-heure-fin="13H"
                                >@livewire('cellule', ['user_id' => $user->id, 'date_service' => $date, 'heure_debut' => '06H', 'heure_fin' => '13H'], key($user->id))
                            </td>
                            <td
                                class="clickable cell"
                                data-user-id="{{ $user->id }}"
                                data-date="{{ $date }}"
                                data-heure-debut="13H"
                                data-heure-fin="20H"
                                >@livewire('cellule', ['user_id' => $user->id, 'date_service' => $date, 'heure_debut' => '13H', 'heure_fin' => '20H'], key($user->id))
                            </td>
                            <td
                                class="clickable cell"
                                data-user-id="{{ $user->id }}"
                                data-date="{{ $date }}"
                                data-heure-debut="20H"
                                data-heure-fin="24H"
                                >@livewire('cellule', ['user_id' => $user->id, 'date_service' => $date, 'heure_debut' => '20H', 'heure_fin' => '24H'], key($user->id))
                            </td>
                            @endforeach

                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Script JavaScript pour la coloration et l'ajout de "X" -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const cells = document.querySelectorAll(".clickable");

        cells.forEach(cell => {
            cell.addEventListener("click", function() {
                // Toggle la couleur de fond et ajoute "X" dans la cellule
                if (this.classList.contains("active")) {
                    this.classList.remove("active");
                    this.innerHTML = ''; // Enlève le "X"
                } else {
                    this.classList.add("active");
                    this.innerHTML = '<span class="text-black">X</span>'; // Ajoute le "X" noir
                }
            });
        });
    });
</script>

<style>
    .clickable {
        cursor: pointer;
        text-align: center;
    }

    .clickable.active {
        background-color: #ffeb3b; /* Jaune clair pour signaler l'activation */
        color: white;
    }

    .clickable:not(.active):hover {
        background-color: #f0f0f0; /* Gris clair au survol */
    }

    .text-black {
        color: black; /* Assure que le X est noir */
    }
</style>


@endsection
