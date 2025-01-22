@extends('admin.admin')
@section('title', 'Paramètres de profil')

@include('nav')

@section('content')
<style>
    #flash-message {
        opacity: 1;
        transition: opacity 0.5s ease-in-out;
    }
</style>

<div class="px-8 py-10 bg-gray-50">
<div class="flex justify-start mb-6">
            <a href="{{ route('admin.courier.index') }}" class="text-blue-500 hover:underline flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a1 1 0 01-.707-.293l-7-7a1 1 0 010-1.414l7-7a1 1 0 011.414 1.414L4.414 10H18a1 1 0 110 2H4.414l6.293 6.293A1 1 0 0110 18z" clip-rule="evenodd" />
                </svg>
                Retour
            </a>
            </div>
    <div class="max-w-5xl mx-auto bg-white shadow-lg rounded-xl">
        <div class="px-8 py-6 border-b border-gray-200">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Paramètres de profil</h1>
        </div>
        <div class="bg-white shadow rounded-lg p-6">
            <form id="profile-form" action="{{ route('admin.profile.updateProfile', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Prénom</label>
                        <span class="block bg-gray-100 border border-gray-300 rounded p-2" id="first_name_display">
                            {{ auth()->user()->first_name }}
                        </span>
                        <input type="text" name="first_name" id="first_name_input" class="w-full border border-gray-300 rounded p-2 hidden" value="{{ auth()->user()->first_name }}">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nom</label>
                        <span class="block bg-gray-100 border border-gray-300 rounded p-2" id="last_name_display">
                            {{ auth()->user()->last_name }}
                        </span>
                        <input type="text" name="last_name" id="last_name_input" class="w-full border border-gray-300 rounded p-2 hidden" value="{{ auth()->user()->last_name }}">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nom d'utilisateur</label>
                        <span class="block bg-gray-100 border border-gray-300 rounded p-2" id="login_display">
                            {{ auth()->user()->login }}
                        </span>
                        <input type="text" name="login" id="login_input" class="w-full border border-gray-300 rounded p-2 hidden" value="{{ auth()->user()->login }}">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Adresse e-mail</label>
                        <span class="block bg-gray-100 border border-gray-300 rounded p-2" id="email_display">
                            {{ auth()->user()->email }}
                        </span>
                        <input type="email" name="email" id="email_input" class="w-full border border-gray-300 rounded p-2 hidden" value="{{ auth()->user()->email }}">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Rôle</label>
                        <span class="block bg-gray-100 border border-gray-300 rounded p-2" id="role_display">
                            {{ auth()->user()->role }}
                        </span>
                        <select name="role" id="role_input" class="w-full border border-gray-300 rounded p-2 hidden" {{ auth()->user()->role !== 'admin' ? 'disabled' : '' }}>
                            <option value="admin" {{ auth()->user()->role === 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="responsable" {{ auth()->user()->role === 'responsable' ? 'selected' : '' }}>Responsable</option>
                            <option value="user" {{ auth()->user()->role === 'user' ? 'selected' : '' }}>Utilisateur</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Service</label>
                        <span class="block bg-gray-100 border border-gray-300 rounded p-2" id="service_display">
                            {{ $user->service->name ?? 'Non défini' }}
                        </span>
                        <select name="service" id="service_input" class="w-full border border-gray-300 rounded p-2 hidden" {{ auth()->user()->role !== 'admin' ? 'disabled' : '' }}>
                            @foreach($services as $service)
                            <option value="{{ $service->id }}" {{ auth()->user()->id_service == $service->id ? 'selected' : '' }}>
                                {{ $service->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Boutons -->
                <div class="mt-6 flex justify-end gap-4">
                    <button type="button" id="edit-button" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">
                        Modifier
                    </button>
                    <button type="submit" id="save-button" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded hidden">
                        Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const editButton = document.getElementById('edit-button');
        const saveButton = document.getElementById('save-button');
        const displayElements = document.querySelectorAll('span[id$="_display"]');
        const inputElements = document.querySelectorAll('input[id$="_input"], select[id$="_input"]');

        editButton.addEventListener('click', () => {
            displayElements.forEach(element => element.classList.add('hidden'));
            inputElements.forEach(element => element.classList.remove('hidden'));
            editButton.classList.add('hidden');
            saveButton.classList.remove('hidden');
        });
    });
</script>
@endsection
