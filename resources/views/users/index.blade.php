@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <!-- Messages de succès ou d'erreur -->
        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-4 mb-4 rounded-lg">
                {{ session('success') }}
            </div>
        @elseif(session('error'))
            <div class="bg-red-100 text-red-700 p-4 mb-4 rounded-lg">
                {{ session('error') }}
            </div>
        @endif

        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Gestion des Employés</h2>
            <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700" data-bs-toggle="modal"
                data-bs-target="#createModal">
                + Ajouter un Employé
            </button>
        </div>

        <!-- Tableau des utilisateurs -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-200 text-gray-700 uppercase text-sm">
                        <th class="px-4 py-3 text-left">Nom</th>
                        <th class="px-4 py-3 text-left">Email</th>
                        <th class="px-4 py-3 text-left">Poste</th>
                        <th class="px-4 py-3 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr class="border-b hover:bg-gray-100 transition">
                            <td class="px-4 py-3">{{ $user->name }}</td>
                            <td class="px-4 py-3">{{ $user->email }}</td>

                            <td class="px-4 py-3"> {{ $user->poste ? $user->poste->nom : 'Aucun poste attribué' }} </td>

                            <td class="px-4 py-3 flex justify-center space-x-2">
                                <!-- Modifier -->
                                <button class="px-3 py-1 text-white bg-yellow-500 rounded hover:bg-yellow-600"
                                    data-bs-toggle="modal" data-bs-target="#editModal-{{ $user->id }}">
                                    <i class='bx bx-edit'></i>
                                </button>

                                <!-- Supprimer -->
                                <button class="px-3 py-1 text-white bg-red-600 rounded hover:bg-red-700"
                                    data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $user->id }}">
                                    <i class='bx bx-trash'></i>
                                </button>
                            </td>
                        </tr>

                        <!-- MODAL DE MODIFICATION -->
                        <div class="modal fade" id="editModal-{{ $user->id }}" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-yellow-500">
                                        <h5 class="modal-title text-white">Modifier l'Employé</h5>
                                        <button type="button" class="btn-close bg-white" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('users.update', $user) }}" method="POST">
                                            @csrf
                                            @method('PUT')

                                            <label>Nom</label>
                                            <input type="text" name="name" value="{{ $user->name }}"
                                                class="w-full p-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300 outline-none"
                                                required>

                                            <label>Email</label>
                                            <input type="email" name="email" value="{{ $user->email }}"
                                                class="w-full p-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300 outline-none"
                                                required>

                                            <!-- Ajout des champs matricule et poste -->
                                            <label>Matricule</label>
                                            <input type="text" name="matricule" value="{{ $user->matricule }}"
                                                class="w-full p-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300 outline-none"
                                                required>

                                            <!-- Sélection du poste -->
                                            <label>Poste</label>
                                            <select name="poste_id"
                                                class="w-full p-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300 outline-none"
                                                required>
                                                @foreach ($postes as $poste)
                                                    <option value="{{ $poste->id }}"
                                                        {{ ($user->poste_id ?? '') == $poste->id ? 'selected' : '' }}>
                                                        {{ $poste->nom }}
                                                    </option>
                                                @endforeach
                                            </select>

                                            <!-- Sélection du Role -->

                                            <label>Role</label>
                                            <select name="role_id"
                                                class="w-full p-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300 outline-none"
                                                required>
                                                <option value="" disabled {{ empty($user->role_id) ? 'selected' : '' }}>
                                                    Non défini
                                                </option>
                                                @foreach ($roles as $role)
                                                    <option value="{{ $role->id }}"
                                                        {{ ($user->role_id ?? '') == $role->id ? 'selected' : '' }}>
                                                        {{ $role->nom }}
                                                    </option>
                                                @endforeach
                                            </select>


                                            <label>Mot de passe</label>
                                            <input type="password" name="password"
                                                class="w-full p-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300 outline-none">

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Fermer</button>
                                                <button type="submit" class="btn btn-primary">Enregistrer</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- MODAL DE SUPPRESSION -->
                        <div class="modal fade" id="deleteModal-{{ $user->id }}" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-red-500">
                                        <h5 class="modal-title text-white">Confirmation de suppression</h5>
                                        <button type="button" class="btn-close bg-white" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Voulez-vous vraiment supprimer l'employé <strong>{{ $user->name }}</strong> ?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <form action="{{ route('users.destroy', $user) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Supprimer</button>
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Annuler</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- MODAL DE CRÉATION -->
    <div class="modal fade" id="createModal" tabindex="-1" aria-labellebdy="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content ">
                <div class="modal-header bg-blue-500">
                    <h5 class="modal-title text-white">Ajouter un Employé</h5>
                    <button type="button" class="btn-close bg-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf
                        <div>
                            <label>Nom</label>
                            <input type="text" name="name"
                                class="w-full p-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300 outline-none"
                                required>
                        </div>
                        <div>
                            <label>Email</label>
                            <input type="email" name="email"
                                class="w-full p-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300 outline-none"
                                required>
                        </div>

                        <!-- Sélection du rôle -->
                        <div>
                            <label class="block text-gray-700">Role</label>
                            <select name="role_id"
                                class="w-full p-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300 outline-none"
                                required>
                                <option value="" disabled selected>--Sélectionner un rôle--</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                        {{ $role->nom }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-gray-700">Poste</label>
                            <select name="poste_id"
                                class="w-full p-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300 outline-none"
                                required>
                                <option value="" disabled selected>--Sélectionner un Poste--</option>
                                @foreach ($postes as $poste)
                                    <option value="{{ $poste->id }}" {{ old('poste_id') == $poste->id ? 'selected' : '' }}>
                                        {{ $poste->nom }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <!-- Champ Mot de passe -->
                        <div>
                            <label class="block text-gray-700">Mot de passe</label>
                            <input type="password" name="password"
                                class="w-full p-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300 outline-none"
                                required>
                        </div>
                        <div>
                            <label class="block text-gray-700">Confirmer le mot de passe</label>
                            <input type="password" name="password_confirmation"
                                class="w-full p-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300 outline-none"
                                required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                            <button type="submit" class="btn btn-primary">Créer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
