<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Tableau de Service</h2>
        <a href="{{ route('services.create') }}" class="btn btn-primary">Créer un service</a>
    </div>

    <div class="bg-white shadow rounded-lg overflow-auto">
        @if ($surveillants->isEmpty())
            <p class="text-center">Il n'y a pas de Tableau de service cette semaine.</p>
        @else
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
                        <tr class="border-b hover:bg-gray-50 transition" data-user-id="{{ $user->id }}">
                            <td class="font-bold px-4 py-2" data-user-id="{{ $user->id }}">{{ $user->name }}</td>
                            @foreach ($jours as $jour => $date)
                                @foreach (['00H' => '06H', '06H' => '13H', '13H' => '20H', '20H' => '24H'] as $heure_debut => $heure_fin)
                                    <td wire:click="storeService({{ $user->id }}, '{{ $jour }} {{ $date }}', '{{ $heure_debut }}', '{{ $heure_fin }}')" class="clickable">
                                        {{-- Vérifier si un service existe pour cet utilisateur, date et plage horaire --}}
                                        @php
                                            $service = $services->where('user_id', $user->id)
                                                                ->where('date_service', "$jour $date")
                                                                ->where('heure_debut', $heure_debut)
                                                                ->where('heure_fin', $heure_fin)
                                                                ->first();
                                        @endphp
                                        {{ $service ? 'X' : 'Aucun service' }}
                                    </td>
                                @endforeach
                            @endforeach
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
