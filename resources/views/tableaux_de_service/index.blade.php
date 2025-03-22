@extends('layouts.app')

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
            /* Pleine largeur */
            text-align: center;
        }
    </style>
    <!-- Ajouter le script Bootstrap JS pour la modal -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <div class="container py-4">

        <div class="d-flex justify-between items-center mb-3">
            <h2>Tableau de Service</h2>
            <!-- Si tu veux ajouter un bouton ici, comme pour ajouter un poste -->


        </div>

        <div class="bg-white shadow rounded-lg overflow-auto">

            <table class="w-full border-collapse">
                <!-- En-tête principale -->
                <thead>
                    <tr class="bg-gray-200 text-gray-700 uppercase text-sm">
                        <th rowspan="1" class="px-4 py-2">Jour et date</th>
                        <th colspan="4" class="px-4 py-2">Lundi <br> 28/06/2021</th>
                        <th colspan="4" class="px-4 py-2">Mardi <br> 29/06/2021</th>
                        <th colspan="4" class="px-4 py-2">Mercredi <br> 30/06/2021</th>
                        <th colspan="4" class="px-4 py-2">Jeudi <br> 01/07/2021</th>
                        <th colspan="4" class="px-4 py-2">Vendredi <br> 02/07/2021</th>
                        <th colspan="4" class="px-4 py-2">Samedi <br> 03/07/2021</th>
                        <th colspan="4" class="px-4 py-2">Dimanche <br> 04/07/2021</th>
                        <!-- Ajoute les autres jours pareil... -->
                        <th colspan="4" rowspan="2" class="px-4 py-2">Décomptes <br> des Heures</th>



                    </tr>
                    <tr class="bg-gray-100 text-gray-700 text-sm">
                        <th class="px-4 py-2">Heure de Début</th>
                        @for ($i = 0; $i < 7; $i++)
                            <th classe="nuite1{{ $i }}">00H</th>
                            <th>06H</th>
                            <th>13H</th>
                            <th classe="nuite2{{ $i }}">20H</th>
                        @endfor
                        <!---
                            <th>00H</th>

                            <th>06H</th>
                             <th>13H</th>
                            <th>20H</th>
                            <th>00H</th>
                            <th>06H</th>
                            <th>13H</th>
                            <th>20H</th>
                            <th>00H</th>
                            <th>06H</th>
                            <th>13H</th>
                            <th>20H</th>
                            <th>00H</th>
                            <th>06H</th>
                            <th>13H</th>
                            <th>20H</th>
                            <th>00H</th>
                            <th>06H</th>
                            <th>13H</th>
                            <th>20H</th>
                            <th>00H</th>
                            <th>06H</th>
                            <th>13H</th>
                            <th>20H</th>
                        -->

                        <!-- Continue pour les autres jours... -->
                    </tr>
                    <tr class="bg-gray-100 text-gray-700 text-sm">
                        <th class="px-4 py-2">Heure de Fin</th>
                        @for ($i = 0; $i < 7; $i++)
                            <th>06H</th>
                            <th>13H</th>
                            <th>20H</th>
                            <th>24H</th>
                        @endfor
                        <!--<th>06H</th>
                            <th>13H</th>
                            <th>20H</th>
                            <th>24H</th>
                            <th>06H</th>
                            <th>13H</th>
                            <th>20H</th>
                            <th>24H</th>
                            <th>06H</th>
                            <th>13H</th>
                            <th>20H</th>
                            <th>24H</th>
                            <th>06H</th>
                            <th>13H</th>
                            <th>20H</th>
                            <th>24H</th>
                            <th>06H</th>
                            <th>13H</th>
                            <th>20H</th>
                            <th>24H</th>
                            <th>06H</th>
                            <th>13H</th>
                            <th>20H</th>
                            <th>24H</th>  -->
                        <!-- Continue pour les autres jours... -->

                        <th>HTE</th>
                        <th>HNN</th>
                        <th>HJF</th>
                        <th>HNF</th>


                    </tr>
                </thead>

                <tbody>
                    <!-- Affichage des techniciens de surveillance -->
                    @foreach ($surveillants as $user)
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="font-bold px-4 py-2">{{ $user->name }}</td>

                            @for ($i = 0; $i < 7; $i++)
                                <!-- 7 jours -->
                                <td id="nuit" class="clickable"></td>
                                <td id="matin" class="clickable"></td>
                                <td id="matin" class="clickable"></td>
                                <td id="nuit" class="clickable"></td>
                            @endfor

                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    @endforeach

                    <!-- Complément avec techniciens de maintenance si besoin -->
                    @foreach ($maintenances as $user)
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="font-bold px-4 py-2">{{ $user->name }}</td>

                            @for ($i = 0; $i < 7; $i++)
                                <td id="nuit" class="clickable"></td>
                                <td id="matin" class="clickable"></td>
                                <td id="matin" class="clickable"></td>
                                <td id="nuit" class="clickable"></td>
                            @endfor

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
    <script>
        document.querySelectorAll('.clickable').forEach(function(cell) {
            cell.addEventListener('click', function() {
                if (this.innerHTML.trim() === "") {
                    this.innerHTML = "X"; // Ajoute "X"
                    this.classList.add('bg-yellow-300'); // Ajoute la couleur jaune

                    // Récupérer les informations nécessaires
                    let user_id = this.closest('tr').querySelector('.user-id').textContent;
                    let date_service = this.closest('thead').querySelector('.date')
                    .textContent; // Récupérer la date du jour
                    let heure_debut = this.closest('tr').querySelector('.start-time')
                    .textContent; // Heure de début
                    let heure_fin = this.closest('tr').querySelector('.end-time')
                    .textContent; // Heure de fin

                    // Envoi de ces informations au contrôleur via AJAX
                    fetch('/tableau-de-service', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content')
                            },
                            body: JSON.stringify({
                                user_id: user_id,
                                date_service: date_service,
                                heure_debut: heure_debut,
                                heure_fin: heure_fin
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            console.log('Success:', data);
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                } else {
                    this.innerHTML = ""; // Enlève "X"
                    this.classList.remove('bg-yellow-300'); // Retire la couleur jaune
                }
            });
        });
        console.log({
    user_id: userId,
    date_service: dateService,
    heure_debut: heureDebut,
    heure_fin: heureFin
});

    </script>
@endsection
