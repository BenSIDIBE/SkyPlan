@extends('layouts.app')

@section('content')
    <style>
        * {
            box-sizing: border-box;
            padding: 0;
            margin: 0;
        }

        body {
            font-family: "Raleway", sans-serif;
        }

        :root {
            --bleue: #00bbfe;
            --gris: #ecf0f1;
            --withe: #fff;
            --grey: #f1f0f6;
            --dark-grey: #8D8D8D;
            --dark: #000;
            --green: #04af51;
            --light-bleue: #1775F1;
            --dark-bleu: #0C5FCD;
            --red:#f55742;
        }

        .principal section {
            margin-top: 40pimage   display: flex;
            justify-content: center;
            max-width: 1550px;
            /*pour mettre au centre les deux card la */
            padding-left: 250px;
        }

        .principal .info-data {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            grid-gap: 20px;
        }

        .principal .info-data .card {
            padding: 20px;
            height: 100px;
            width: 280px;
            border-radius: 10px;
            background: var(--withe);
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            cursor: pointer;
            border-left: 5px solid var(--light-bleue);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .principal .card .head {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }


        /***/

        .principal .info-data .card.i h2 {
            font-size: 30px;
            font-weight: 600;
            color: var(--bleue);

        }


        .principal .info-data .card.o h2 {
            font-size: 30px;
            font-weight: 600;
            color: var(--dark-grey);
        }
        .principal .info-data .card.u h2 {
            font-size: 30px;
            font-weight: 600;
            color: var(--red);
        }

        .principal .info-data .card p {
            font-size: 18px;
        }


    </style>

    <div class="principal">
        <section>
            <div class="info-data">

                <div class="card u" onclick="window.location='{{ route('services.index') }}'">
                    <div class="head">
                        <div>
                            <h2>{{ \App\Models\TableauService::count() }}</h2>
                            <p>Tableau de service</p>
                        </div>
                        <i class="fa-solid fa-building-columns icon"></i>
                    </div>
                </div>

                <div class="card i" onclick="window.location='{{ route('users.index') }}'">
                    <div class="head">
                        <div>
                            <h2>{{ \App\Models\User::count() }}</h2>
                            <p>Users</p>
                        </div>
                        <i class='fa fa-school icon'></i>
                    </div>
                </div>


                <!--
                <div class="card o" onclick="window.location='{{ route('postes.index') }}'">
                    <div class="head">
                        <div>
                            <h2>{{ \App\Models\Poste::count() }}</h2>
                            <p>Postes</p>
                        </div>
                        <i class="fa-solid fa-users-between-lines icon"></i>
                    </div>
                </div>  --->
            </div>
        </section>
    </div>






















    <!--- juste pour la capture d'ecran -->





















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


    </style>
    <!-- Ajouter le script Bootstrap JS pour la modal -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <div class="container py-4" id="zone-impression">
        <div class="d-flex justify-between items-center mb-3">
            <h2>Tableau de Service de la semaine </h2>
            <!-- Si tu veux ajouter un bouton ici, comme pour ajouter un poste -->
        </div>

        <div class="bg-white shadow rounded-lg overflow-auto">

            <table class="w-full border-collapse">
                <!-- En-tête principale -->
                <thead>
                    <tr class="bg-gray-200 text-gray-700 uppercase text-sm">
                        <th rowspan="1" class="px-4 py-2">Jour et date</th>
                        <th colspan="4" class="px-4 py-2">Lundi <br> 24/03/2025</th>
                        <th colspan="4" class="px-4 py-2">Mardi <br> 25/03/2025</th>
                        <th colspan="4" class="px-4 py-2">Mercredi <br> 26/03/2025</th>
                        <th colspan="4" class="px-4 py-2">Jeudi <br> 27/03/2025</th>
                        <th colspan="4" class="px-4 py-2">Vendredi <br> 28/03/2025</th>
                        <th colspan="4" class="px-4 py-2">Samedi <br> 29/03/2025</th>
                        <th colspan="4" class="px-4 py-2">Dimanche <br> 30/03/2025</th>
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



                        <th>HTE</th>
                        <th>HNN</th>
                        <th>HJF</th>
                        <th>HNF</th>


                    </tr>
                </thead>

                <tbody>




                   <tr class="border-b hover:bg-gray-50 transition">
                    <td class="font-bold px-1 py-1">BAYALA S. Noel</td>
                    @for ($i = 0; $i < 7; $i++)
                                <!-- 7 jours -->
                                <td id="nuit" class="clickable"></td>
                                <td id="matin" class="clickable"></td>
                                <td id="matin" class="clickable"></td>
                                <td id="nuit" class="clickable"></td>
                    @endfor
                    <td>56</td>
                    <td>21</td>
                    <td>0</td>
                    <td>0</td>

                   </tr>



   <!--
                   <tr class="border-b hover:bg-gray-50 transition">
                    <td class="font-bold px-1 py-1">COULIBALY H. Lucien</td>
                    @for ($i = 0; $i < 7; $i++)
                                <td id="nuit" class="clickable"></td>
                                <td id="matin" class="clickable"></td>
                                <td id="matin" class="clickable"></td>
                                <td id="nuit" class="clickable"></td>
                    @endfor
                    <td>41</td>
                    <td>18</td>
                    <td>7</td>
                    <td>03</td>

                   </tr>   -->



                   <tr class="border-b hover:bg-gray-50 transition">
                    <td class="font-bold px-1 py-1">ILBOUDO Parfait</td>
                    @for ($i = 0; $i < 7; $i++)
                                <!-- 7 jours -->
                                <td id="nuit" class="clickable"></td>
                                <td id="matin" class="clickable"></td>
                                <td id="matin" class="clickable"></td>
                                <td id="nuit" class="clickable"></td>
                    @endfor
                    <td>53</td>
                    <td>18</td>
                    <td>0</td>
                    <td>0</td>

                   </tr>



                   <tr class="border-b hover:bg-gray-50 transition">
                    <td class="font-bold px-1 py-1">SOME Jean De Dieu.</td>
                    @for ($i = 0; $i < 7; $i++)
                                <!-- 7 jours -->
                                <td id="nuit" class="clickable"></td>
                                <td id="matin" class="clickable"></td>
                                <td id="matin" class="clickable"></td>
                                <td id="nuit" class="clickable"></td>
                    @endfor
                    <td>49</td>
                    <td>21</td>
                    <td>0</td>
                    <td>0</td>

                   </tr>











                </tbody>
            </table>

        </div>

    </div>

    <div class="text-end no-print">
        <button class="btn btn-primary">Ajouter</button>
        <button class="btn btn-success" >Télécharger</button>
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
