@extends('layouts.app') <!-- Spécifier le layout ici -->

@section('content')
    <style>
        th,
        td {
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


            <div class=" overflow-auto">
                <div><h2>Tableau de Service</h2> <br>
                </div>
                <table class="w-full border-collapse bg-white  shadow rounded-lg overflow-auto">
                    <thead>
                        <tr class="bg-gray-100 text-gray-700 uppercase text-sm">
                            <th rowspan="1" class="px-4 py-2">Jour et date</th>
                            @foreach ($jours as $jour => $date)
                                <th colspan="4" class="px-4 py-2">{{ $jour }}<br> {{ $date }}</th>
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
                                    <td class="clickable cell"
                                        data-user-id="{{ $user->id }}"
                                        data-date="{{ $date }}"
                                        data-heure-debut="00H"
                                        data-heure-fin="06H"
                                        data-id-tableau-service="{{ $id_tableauService }}"
                                        data-type="hnn"> {{-- nuit --}}

                                        @livewire('cellule', ['user_id' => $user->id, 'date_service' => $date, 'heure_debut' => '00H', 'heure_fin' => '06H', 'id_tableauService' =>  $tableauService->id], key($user->id . $date . '00H-06H'))
                                    </td>
                                    <td class="clickable cell"
                                        data-user-id="{{ $user->id }}"
                                        data-date="{{ $date }}"
                                        data-heure-debut="06H"
                                        data-heure-fin="13H"
                                        data-id-tableau-service="{{ $id_tableauService }}"
                                        
                                        >
                                     
                                        @livewire('cellule', ['user_id' => $user->id, 'date_service' => $date, 'heure_debut' => '06H', 'heure_fin' => '13H', 'id_tableauService' =>  $tableauService->id], key($user->id . $date . '06H-13H'))
                                    </td>
                                    <td class="clickable cell"
                                        data-user-id="{{ $user->id }}"
                                        data-date="{{ $date }}"
                                        data-heure-debut="13H"
                                        data-heure-fin="20H"
                                        data-id-tableau-service="{{ $id_tableauService }}">
                                        @livewire('cellule', ['user_id' => $user->id, 'date_service' => $date, 'heure_debut' => '13H', 'heure_fin' => '20H', 'id_tableauService' =>  $tableauService->id], key($user->id . $date . '13H-20H'))
                                    </td>
                                    <td class="clickable cell"
                                        data-user-id="{{ $user->id }}"
                                        data-date="{{ $date }}"
                                        data-heure-debut="20H"
                                        data-heure-fin="24H"
                                        data-id-tableau-service="{{ $id_tableauService }}"
                                        data-type="hnn"
                                        >
                                        @livewire('cellule', ['user_id' => $user->id, 'date_service' => $date, 'heure_debut' => '20H', 'heure_fin' => '24H', 'id_tableauService' =>  $tableauService->id], key($user->id . $date . '20H-24H'))
  
                                    </td>
                                        @endforeach

                                        <td id="hte-{{ $user->id }}">{{ $decomptes[$user->id]['hte'] ?? 0 }}</td>
                                        <td id="hnn-{{ $user->id }}">{{ $decomptes[$user->id]['hnn'] ?? 0 }}</td>
                                        <td id="hjf-{{ $user->id }}">{{ $decomptes[$user->id]['hjf'] ?? 0 }}</td>
                                        <td id="hnf-{{ $user->id }}">{{ $decomptes[$user->id]['hnf'] ?? 0 }}</td>

                                    </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="text-end"><a href="{{ route('mail', ['id_tableauService' => $tableauService->id]) }}" class="btn btn-primary"> Enregistre </a> </div>


        <!-- Script JavaScript pour la coloration et l'ajout de "X" -->
        <!-- <script>
            document.addEventListener("DOMContentLoaded", function() {
                const cells = document.querySelectorAll(".clickable");

                cells.forEach(cell => {
                    cell.addEventListener("click", function(e) {
                        // Toggle la couleur de fond et ajoute "X" dans la cellule
                        e.preventDefault();
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

            funtion increment(){

            }
        </script> -->
        
        <script>
                document.addEventListener("DOMContentLoaded", function () {
                    const cells = document.querySelectorAll(".clickable");

                    // const heureMap = {
                    //     "00H": 0,
                    //     "06H": 6,
                    //     "13H": 13,
                    //     "20H": 20,
                    //     "24H": 24
                    // };

                    // Transformer "YYYY-MM-DD" → "DD/MM/YYYY"
                    function formatDateFr(isoDate) {
                        const [year, month, day] = isoDate.split("-");
                        return `${year}/${month}/${day}`;
                    }

                    const joursFeries = @json($tableauService->data['jour_ferie'] ?? []);
                    

                    cells.forEach(cell => {
                        cell.addEventListener("click", function (e) {
                            e.preventDefault();

                            const userId = this.dataset.userId;
                            const rawDate = this.dataset.date;
                            const date = formatDateFr(rawDate); // maintenant "DD/MM/YYYY"
                            const isFerie = joursFeries.includes(date);
                            const debut = this.dataset.heureDebut;
                            const fin = this.dataset.heureFin;

                            
                            console.log(isFerie);
                            
                            

                            let hte = 0, hnn = 0, hjf = 0, hnf = 0;

                            if (debut === "00H" && fin === "06H") {
                                hte = 6;
                                if (isFerie) hnf = 6;
                                else hnn = 6;
                            } else if (debut === "06H" && fin === "13H") {
                                hte = 7;
                                if (isFerie) hjf = 7;
                            } else if (debut === "13H" && fin === "20H") {
                                hte = 7;
                                if (isFerie) hjf = 7;
                            } else if (debut === "20H" && fin === "24H") {
                                hte = 4;
                                if (isFerie) hnf = 3;
                                else hnn = 3;
                            }

                            // Définir signe : + si activation, - si désactivation
                            const factor = this.classList.contains("active") ? -1 : 1;

                            this.classList.toggle("active");
                            this.innerHTML = this.classList.contains("active") ? '<span class="text-black">X</span>' : '';

                            updateCount(userId, "hte", factor * hte);
                            updateCount(userId, "hnn", factor * hnn);
                            updateCount(userId, "hjf", factor * hjf);
                            updateCount(userId, "hnf", factor * hnf);
                        });
                    });


                    function updateCount(userId, type, delta) {
                        const countCell = document.getElementById(`${type}-${userId}`);
                        if (countCell) {
                            let currentValue = parseInt(countCell.textContent) || 0;
                            countCell.textContent = currentValue + delta;
                        }
                    }
                });
                </script>

²

        <style>
            .clickable {
                cursor: pointer;
                text-align: center;
            }

            .clickable.active {
                background-color: #ffeb3b;
                /* Jaune clair pour signaler l'activation */
                color: white;
            }

            .clickable:not(.active):hover {
                background-color: #f0f0f0;
                /* Gris clair au survol */
            }

            .text-black {
                color: black;
                /* Assure que le X est noir */
            }
        </style>
    @endsection
