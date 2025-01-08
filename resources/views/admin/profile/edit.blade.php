@extends('admin.admin')
@section('title', 'Paramètres de profil')

@include('nav')

@section('content')
<div class="absolute top-12 left-0 mt-9 ml-2">
    <a href="{{ route('admin.courier.index') }}" class="text-blue-500 hover:underline flex items-center">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="fill-current h-5 w-5 mr-1">
            <path fill-rule="evenodd" d="M11.293 4.293a1 1 0 011.414 1.414l-4 4a1 1 0 010 1.414l4 4a1 1 0 01-1.414 1.414l-5-5a1 1 0 010-1.414l5-5a1 1 0 011.414 0z" clip-rule="evenodd"></path>
        </svg>
        Retour
    </a>
</div>
<!-- Content -->
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mt-4">Paramètres de profil</h1>

    <!-- Profile Settings Form -->
    <div class="mt-8">
        <form method="POST" action="{{ route('admin.profile.update', auth()->user()->id) }}" class="w-full max-w-lg" id="profileForm">
            @csrf
            @method('PUT')
            <!-- Champ caché pour stocker l'ID de l'utilisateur -->
            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
            <div class="mb-4">
                <label for="firstName" class="block text-gray-700 text-sm font-bold mb-2">Prénom</label>
                <input type="text" id="firstName" name="first_name" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500" placeholder="Entrez votre prénom" value="{{ old('first_name', $user->first_name) }}" required>
                @error('first_name')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="lastName" class="block text-gray-700 text-sm font-bold mb-2">Nom</label>
                <input type="text" id="lastName" name="last_name" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500" placeholder="Entrez votre nom" value="{{ old('last_name', $user->last_name) }}" required>
                @error('last_name')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="username" class="block text-gray-700 text-sm font-bold mb-2">Nom d'utilisateur</label>
                <input type="text" id="username" name="login" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500" placeholder="Entrez votre nom d'utilisateur" value="{{ old('login', $user->login) }}" required>
                @error('login')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Adresse e-mail</label>
                <input type="email" id="email" name="email" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500" placeholder="Entrez votre adresse e-mail" value="{{ old('email', $user->email) }}" required>
                @error('email')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mt-8">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Enregistrer</button>
            </div>
        </form>
    </div>

</div>
@endsection
