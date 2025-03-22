@extends('layouts.app')

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
    <!--
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
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
                <tr class="border-b hover:bg-gray-50 transition" data-user-id="{{ $user->id }}">                        <td class="font-bold px-4 py-2" data-user-id="{{ $user->id }}">{{ $user->name }}</td>

                        @foreach ($jours as $jour => $date)
                            <td class="clickable" data-heure-debut="00H" data-heure-fin="06H" data-date-service="{{ $jour }} {{ $date }}" data-user-id="{{ $user->id }}"></td>
                            <td class="clickable" data-heure-debut="06H" data-heure-fin="13H" data-date-service="{{ $jour }} {{ $date }}" data-user-id="{{ $user->id }}"></td>
                            <td class="clickable" data-heure-debut="13H" data-heure-fin="20H" data-date-service="{{ $jour }} {{ $date }}" data-user-id="{{ $user->id }}"></td>
                            <td class="clickable" data-heure-debut="20H" data-heure-fin="24H" data-date-service="{{ $jour }} {{ $date }}" data-user-id="{{ $user->id }}"></td>
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

<script>let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    document.querySelectorAll('.clickable').forEach(function(cell) {
        cell.addEventListener('click', function() {
            let user_id = this.dataset.userId;
            let date_service = this.dataset.dateService;
            let heure_debut = this.dataset.heureDebut;
            let heure_fin = this.dataset.heureFin;
            let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            if (this.innerHTML.trim() === "") {
                // Ajout d'un service
                this.innerHTML = "X";
                this.classList.add('bg-yellow-300');

                fetch('/services', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({
                        user_id: user_id,
                        date_service: date_service,
                        heure_debut: heure_debut,
                        heure_fin: heure_fin
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error("Erreur serveur");
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        this.dataset.serviceId = data.service_id; // Stocker l'ID du service
                    } else {
                        alert("Erreur lors de l'enregistrement !");
                        this.innerHTML = "";
                        this.classList.remove('bg-yellow-300');
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    alert("Problème de connexion au serveur !");
                    this.innerHTML = "";
                    this.classList.remove('bg-yellow-300');
                });

            } else {
                // Suppression d'un service
                let service_id = this.dataset.serviceId;
                if (!service_id) return;

                fetch(`/services/${service_id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': token
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error("Erreur serveur");
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        this.innerHTML = "";
                        this.classList.remove('bg-yellow-300');
                    } else {
                        alert("Erreur lors de la suppression !");
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    alert("Problème de connexion au serveur !");
                });
            }
        });
    });




</script>
@endsection
