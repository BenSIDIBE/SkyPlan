@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-4">Créer un Tableau de Service</h2>

        <!-- Formulaire de création -->
        <form method="POST" action="{{ route('tableau_service.store') }}">
            @csrf

            <!-- Sélection de la semaine -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <label for="semaine" class="form-label">Sélectionner une semaine :</label>
                    <select name="semaine" id="semaine" class="form-select" onchange="updateJoursFeries()">
                        @foreach ($semaines as $date => $libelle)
                            <option value="{{ $date }}" {{ $semaineSelectionnee == $date ? 'selected' : '' }}>
                                {{ $libelle }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Demande s'il y a des jours fériés ou des absences -->
            <div class="mb-4">
                <label class="form-label">Y a-t-il des jours fériés ou des absences à ajouter ?</label><br>
                <input type="radio" name="presence" id="presence_oui" value="oui" onclick="toggleModalBtn(true)"> Oui
                <input type="radio" name="presence" id="presence_non" value="non" onclick="toggleModalBtn(false)"
                    checked> Non
            </div>

            <!-- Boutons pour ouvrir les modaux -->
            <div class="mb-3">
                <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#joursFeriesModal"
                    id="openJoursFeriesModal" disabled>
                    Ajouter Jours Fériés
                </button>

                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#techniciensModal"
                    id="openTechniciensModal">
                    Ajouter Absences
                </button>

            </div>

            <!-- Modal pour les Jours Fériés -->
            <div class="modal fade" id="joursFeriesModal" tabindex="-1" aria-labelledby="joursFeriesModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="joursFeriesModalLabel">Sélectionner les Jours Fériés</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <label for="jour_ferie" class="form-label">Sélectionner les jours fériés :</label>
                            <select name="jour_ferie[]" id="jour_ferie" class="form-select" multiple>
                                @if (isset($joursFeries) && isset($joursFeries[$semaineSelectionnee]) && count($joursFeries[$semaineSelectionnee]) > 0)
                                    @foreach ($joursFeries[$semaineSelectionnee] as $jour)
                                        @php
                                            $debutSemaine = \Carbon\Carbon::parse($jour)->startOfWeek();
                                            $finSemaine = \Carbon\Carbon::parse($jour)->endOfWeek();
                                        @endphp
                                        <option value="{{ $jour }}">
                                            {{ $debutSemaine->translatedFormat('l d/m/Y') }} -
                                            {{ $finSemaine->translatedFormat('l d/m/Y') }}
                                        </option>
                                    @endforeach
                                @else
                                    <option disabled>Aucun jour férié disponible pour cette semaine</option>
                                @endif
                            </select>
                            <small class="text-muted">Maintenez Ctrl pour sélectionner plusieurs jours.</small>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal"
                                onclick="saveJoursFeries()">Enregistrer</button>
                        </div>
                    </div>
                </div>
            </div>



            <!-- Affichage des utilisateurs -->
            <div class="modal fade" id="techniciensModal" tabindex="-1" aria-labelledby="techniciensModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-yellow-500 text-white">
                            <h5 class="modal-title " id="techniciensModalLabel">Liste des Techniciens de Surveillance</h5>
                            <button type="button" class="btn-close bg-white" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <select class="form-select" name="technicien_absent[]" id="technicien_absent" multiple>
                                @foreach ($utilisateurs as $utilisateur)
                                    @if ($utilisateur->poste_id === $postes->firstWhere('nom', 'Technicien de surveillance')->id)
                                        <option value="{{ $utilisateur->id }}">{{ $utilisateur->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                            <small class="text-muted">Maintenez Ctrl pour sélectionner plusieurs techniciens.</small>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal"
                                onclick="saveAbsences()">Enregistrer</button>
                        </div>
                    </div>
                </div>
            </div>



            <!-- Champs cachés pour les données -->
            <input type="hidden" name="jour_ferie" id="jour_ferie_hidden">
            <input type="hidden" name="absences" id="absences_hidden">

            <!-- Boutons de soumission -->
            <button type="submit" class="btn btn-primary" onclick="submitAndRedirect(event)">Continuer</button>

            <script>
                function submitAndRedirect(event) {
                    event.preventDefault();

                    // Soumettre le formulaire pour enregistrer les informations du tableau de service
                    var form = event.target.closest('form');
                    var formData = new FormData(form);

                    fetch(form.action, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success && data.tableau_service_id) {
                                // Rediriger vers la vue Livewire avec l'ID du tableau de service
                                var semaineSelectionnee = document.getElementById('semaine').value;
                                var joursFeries = document.getElementById('jour_ferie_hidden').value;
                                var absences = document.getElementById('absences_hidden').value;

                                var url = "{{ route('services.create') }}" +
                                    "?semaine=" + encodeURIComponent(semaineSelectionnee) +
                                    "&jours_feries=" + encodeURIComponent(joursFeries) +
                                    "&absences=" + encodeURIComponent(absences) +
                                    "&tableau_service_id=" + encodeURIComponent(data.tableau_service_id);

                                window.location.href = url;
                            } else {
                                alert('Une erreur est survenue lors de la création du tableau de service.');
                            }
                        })
                        .catch(error => {
                            console.error('Erreur:', error);
                            alert('Une erreur est survenue.');
                        });
                }
            </script>
        </form>
    </div>
    <script>
        // Fonction pour activer/désactiver les boutons des modaux
        function toggleModalBtn(enable) {
            var joursFeriesBtn = document.getElementById('openJoursFeriesModal');
            var absencesBtn = document.getElementById('openAbsencesModal');
            joursFeriesBtn.disabled = !enable;
            absencesBtn.disabled = !enable;
        }

        // Fonction pour mettre à jour la liste des jours fériés en fonction de la semaine sélectionnée
        function updateJouies() {
            var semaineSelectionnee = document.getElementById('semaine').value;

            fetch("{{ route('tableau_service.create') }}?semaine=" + semaineSelectionnee)
                .then(response => response.json())
                .then(data => {
                    var jourFerieSelect = document.getElementById('jour_ferie');
                    jourFerieSelect.innerHTML = "";
                    data.jours.forEach(function(jour) {
                        var option = document.createElement("option");
                        option.value = jour;
                        option.textContent = jour;
                        jourFerieSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Erreur:', error));
        }

        // Fonction pour enregistrer les jours fériés sélectionnés
        function saveJoursFeries() {
            var joursFeries = Array.from(document.getElementById('jour_ferie').selectedOptions).map(option => option.value);
            document.getElementById('jour_ferie_hidden').value = joursFeries.join(',');
        }

        // Fonction pour enregistrer les absences
        function saveAbsences() {
            var absences = document.getElementById('absences').value;
            document.getElementById('absences_hidden').value = absences;
        }
    </script>

@endsection
