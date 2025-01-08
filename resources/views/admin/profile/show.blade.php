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

    <!-- Profile Information -->
    <div class="mt-8">
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Prénom</label>
            <div class="flex items-center">
                <span id="firstNameText">{{ auth()->user()->first_name }}</span>
            </div>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Nom</label>
            <div class="flex items-center">
                <span id="firstNameText">{{ auth()->user()->last_name }}</span>

            </div>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Nom d'utilisateur</label>
            <div class="flex items-center">
                <span id="firstNameText">{{ auth()->user()->login }}</span>

            </div>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Adresse e-mail</label>
            <div class="flex items-center">
                <span id="firstNameText">{{ auth()->user()->email }}</span>

            </div>
        </div>
    </div>

    <!-- Buttons -->
<div class="mt-4 flex justify-between">
    <!-- Modifier Button -->
    <form action="{{ route('admin.profile.edit') }}">
        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Modifier</button>
    </form>
    <!-- Change Password Button -->
    <form action="{{ route('admin.profile.showChangePasswordForm') }}">
        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Changer le mot de passe</button>
    </form>
</div>
</div>
@endsection
