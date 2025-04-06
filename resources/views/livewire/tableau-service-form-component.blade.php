<div class="container">
    <h2 class="mb-4">Créer un Tableau de Service</h2>

    <!-- Formulaire de création -->
    <form method="POST" wire:submit="onSubmit" {{--action="{{ route('tableau_service.store') }}"--}}>
        @csrf

        <!-- Sélection de la semaine -->
        <div class="row mb-4">
            <div class="col-md-4">
                <label for="semaine" class="form-label">Sélectionner une semaine :</label>
                <select name="semaine" wire:model="semaine" wire:change="updateJoursFeries" id="semaine" class="form-select" onchange="updateJoursFeries()">
                    @foreach ($semaines as $date => $libelle)
                        <option value="{{ $date }}" {{ $semaineSelectionnee == $date ? 'selected' : '' }}>
                            {{ $libelle }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-6">
                <label for="commandant_permanence" class="form-label">Commandant de Permanence :</label>
                <select name="commandant_permanence" id="commandant_permanence"  wire:model="commandant_permanence" class="form-select">
                    <option value="" selected disabled>Choisir un commandant de permanence</option>
                    @foreach ($utilisateurs as $utilisateur)
                        <option value="{{ $utilisateur->id }}">{{ $utilisateur->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label for="permanence_tech" class="form-label">Permanence Technique :</label>
                <select name="permanence_tech" id="permanence_tech" wire:model="permanence_tech" class="form-select">
                    <option value="" selected disabled>Choisir une permanence technique</option>
                    @foreach ($utilisateurs as $utilisateur)
                        <option value="{{ $utilisateur->id }}">{{ $utilisateur->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Removed unnecessary section -->

        <!-- Boutons pour ouvrir les modaux -->
        <div class="mb-3">
            <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#joursFeriesModal"
                        id="openJoursFeriesModal"  wire:loading.attr="disabled">
                <span wire:loading>
                    <svg class="w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 330 330" xml:space="preserve"><path d="M97.5 165c0-8.284-6.716-15-15-15h-60c-8.284 0-15 6.716-15 15s6.716 15 15 15h60c8.284 0 15-6.716 15-15zM307.5 150h-30c-8.284 0-15 6.716-15 15s6.716 15 15 15h30c8.284 0 15-6.716 15-15s-6.716-15-15-15zM172.5 90c8.284 0 15-6.716 15-15V15c0-8.284-6.716-15-15-15s-15 6.716-15 15v60c0 8.284 6.716 15 15 15zM172.501 240c-8.284 0-15 6.716-15 15v60c0 8.284 6.716 15 15 15 8.284 0 15-6.716 15-15v-60c0-8.284-6.716-15-15-15zM77.04 48.327c-5.856-5.858-15.354-5.857-21.213 0-5.858 5.858-5.858 15.355 0 21.213l42.427 42.428a14.954 14.954 0 0 0 10.606 4.394c3.838 0 7.678-1.465 10.606-4.393 5.858-5.858 5.858-15.355 0-21.213L77.04 48.327zM246.746 218.034c-5.857-5.857-15.355-5.857-21.213 0-5.858 5.858-5.857 15.355 0 21.213l42.428 42.426a14.953 14.953 0 0 0 10.607 4.393c3.839 0 7.678-1.465 10.606-4.393 5.858-5.858 5.858-15.355 0-21.213l-42.428-42.426zM98.254 218.034 55.828 260.46c-5.858 5.858-5.858 15.355 0 21.213a14.953 14.953 0 0 0 10.607 4.393 14.95 14.95 0 0 0 10.606-4.393l42.426-42.426c5.858-5.858 5.858-15.355 0-21.213-5.858-5.858-15.356-5.858-21.213 0z"/></svg>
                </span>
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
                    <div class="modal-header bg-blue-400 ">
                        <h5 class="modal-title" id="joursFeriesModalLabel">Sélectionner les Jours Fériés</h5>
                        <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <label for="jour_ferie" class="form-label">Sélectionner les jours :</label>
                        <select name="jour_ferie[]" wire:model="jour_ferie" id="jour_ferie" class="form-select" multiple>
                            @php
                                $jours = ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi'];
                            @endphp

                            @foreach ($listeDate as $day)
                                {{--@php
                                    $date = \Carbon\Carbon::parse($semaineSelectionnee)->startOfWeek()->addDays(array_search($jour, $jours))->format('d-m-Y');
                                @endphp--}}
                                <option value="{{ $day }}" >{{ $day }}</option>
                            @endforeach
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
                        <select class="form-select" wire:model="technicien_absent" name="technicien_absent[]" id="technicien_absent" multiple>
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
        <button type="submit" class="btn btn-primary">Continuer</button>

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
        var absencesBtn = document.getElementById('openTechniciensModal');
        joursFeriesBtn.disabled = !enable;
        absencesBtn.disabled = !enable;
    }

    // Fonction pour mettre à jour la liste des jours fériés en fonction de la semaine sélectionnée
    function updateJoursFeries() {
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
