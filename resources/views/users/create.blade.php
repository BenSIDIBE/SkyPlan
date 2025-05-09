@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Ajouter un utilisateur</h2>
        <a href="{{ route('users.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">
            Retour
        </a>
    </div>

    <div class="bg-white shadow rounded-lg p-6">
        <form action="{{ route('users.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-gray-700">Nom</label>
                <input type="text" name="name" class="w-full p-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300 outline-none" required>
            </div>
            <div>
                <label class="block text-gray-700">Email</label>
                <input type="email" name="email" class="w-full p-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300 outline-none" required>
            </div>
            <div>
                <label class="block text-gray-700">Mot de passe</label>
                <input type="password" name="password" class="w-full p-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300 outline-none" required>
            </div>
            <div>
                <label class="block text-gray-700">Confirmer le mot de passe</label>
                <input type="password" name="password_confirmation" class="w-full p-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300 outline-none" required>
            </div>

            <div>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>

@if(session('success'))
<script>
    window.location.href = "{{ route('users.index') }}";
</script>
@endif
@endsection
