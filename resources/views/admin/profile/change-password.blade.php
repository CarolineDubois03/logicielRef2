<!-- auth/change_password.blade.php -->
@extends('admin.admin')

@section('title', 'Changer le mot de passe')

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
    <h1 class="text-2xl font-bold mt-4">Changer le mot de passe</h1>

    <!-- Change Password Form -->
    <div class="mt-8">
        <form method="POST" action="{{ route('admin.profile.change-password') }}" class="w-full max-w-lg">
            @csrf
            <div class="mb-4">
                <label for="old_password" class="block text-gray-700 text-sm font-bold mb-2">Ancien mot de passe</label>
                <input type="password" id="old_password" name="old_password" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500" placeholder="Entrez votre ancien mot de passe" required>
            </div>
            <div class="mb-4">
                <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Nouveau mot de passe</label>
                <input type="password" id="password" name="password" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500" placeholder="Entrez votre nouveau mot de passe" required>
            </div>
            <div class="mb-4">
                <label for="password_confirmation" class="block text-gray-700 text-sm font-bold mb-2">Confirmez le nouveau mot de passe</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500" placeholder="Confirmez votre nouveau mot de passe" required>
            </div>
            <div class="mt-8">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Changer le mot de passe</button>
            </div>
        </form>
    </div>
</div>
@endsection
