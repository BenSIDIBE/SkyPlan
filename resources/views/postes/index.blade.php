@extends('layouts.app')

@section('content')
    <div class="container py-4">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Liste des Postes</h2>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPosteModal">Ajouter un Poste</button>
        </div>


        <div class="bg-white shadow rounded-lg overflow-hidden">

            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-200 text-gray-700 uppercase text-sm">

                        <th class="px-4 py-3 text-left">#</th>
                        <th class="px-4 py-3 text-left">Nom du Poste</th>
                        <th class="px-4 py-3 text-left">Description</th>
                        <th class="px-4 py-3 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($postes as $index => $poste)
                        <tr class="border-b hover:bg-gray-100 transition">
                            <td class="px-4 py-3">{{ $index + 1 }}</td>
                            <td class="px-4 py-3">{{ $poste->nom }}</td>
                            <td class="px-4 py-3">{{ $poste->description }}</td>


                            <td class="px-4 py-3 flex justify-center space-x-2">
                                <!-- Modifier -->
                                <button class="px-3 py-1 text-white bg-yellow-500 rounded hover:bg-yellow-600"
                                    data-bs-toggle="modal" data-bs-target="#editPosteModal{{ $poste->id }}">
                                    <i class='bx bx-edit'></i>
                                </button>

                                <!-- Supprimer -->
                                <button class="px-3 py-1 text-white bg-red-600 rounded hover:bg-red-700"
                                    data-bs-toggle="modal" data-bs-target="#deletePosteModal{{ $poste->id }}">
                                    <i class='bx bx-trash'></i>
                                </button>
                            </td>


                        </tr>

                        <!-- Modal Modification -->
                        <div class="modal fade" id="editPosteModal{{ $poste->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <form action="{{ route('postes.update', $poste->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Modifier le Poste</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label>Nom</label>
                                                <input type="text" class="form-control" name="nom"
                                                    value="{{ $poste->nom }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label>Description</label>
                                                <textarea class="form-control" name="description">{{ $poste->description }}</textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success">Enregistrer</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Modal Suppression -->
                        <div class="modal fade" id="deletePosteModal{{ $poste->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <form action="{{ route('postes.destroy', $poste->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Confirmer la suppression</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            Êtes-vous sûr de vouloir supprimer le poste
                                            <strong>{{ $poste->nom }}</strong> ?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-danger">Supprimer</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>

        </div>

    </div>

    <!-- Modal Ajout -->
    <div class="modal fade" id="addPosteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('postes.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Ajouter un Poste</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Nom</label>
                            <input type="text" class="form-control" name="nom" required>
                        </div>
                        <div class="mb-3">
                            <label>Description</label>
                            <textarea class="form-control" name="description"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Ajouter</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
