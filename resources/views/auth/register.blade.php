<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Inscription</title>
    <style>
        .overlay {
            background-image: url('https://images.unsplash.com/photo-1526554850534-7c78330d5f90?q=80&w=2069&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D');
            background-size: cover;
            background-position: center;
            opacity: 0.5;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1; /* Placez l'élément en arrière-plan */
        }
    </style>
</head>
<body class="relative bg-gray-100">
    <!-- Ajoutez la balise div pour l'overlay -->
    <div class="overlay"></div>
    <!-- Conteneur principal -->
    <div class="min-h-screen flex items-center justify-center">
        <!-- Formulaire avec contour stylisé -->
        <div class="max-w-md w-full px-8 py-6 bg-white rounded-lg shadow-lg">
        <h1 class="text-3xl text-center text-gray-800 font-bold mb-8">Inscription</h1>
        
        @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        <form method="post" action="{{ route('register') }}">
            @csrf
            <div class="mb-4">
                <label for="last_name" class="block text-gray-700 text-sm font-bold mb-2">Nom</label>
                <input type="text" id="last_name" name="last_name" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500" placeholder="Entrez votre nom" required>
            </div>
            <div class="mb-4">
                <label for="first_name" class="block text-gray-700 text-sm font-bold mb-2">Prénon</label>
                <input type="text" id="first_name" name="first_name" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500" placeholder="Entrez votre nom" required>
            </div>
            <div class="mb-4">
                <label for="login" class="block text-gray-700 text-sm font-bold mb-2">Login</label>
                <input type="text" id="login" name="login" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500" placeholder="Entrez votre login" required>
            </div>
            <div class="mb-4">
                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Adresse e-mail</label>
                <input type="email" id="email" name="email" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500" placeholder="Entrez votre adresse e-mail" required>
            </div>
            <div class="mb-4">
                <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Mot de passe</label>
                <input type="password" id="password" name="password" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500" placeholder="Entrez votre mot de passe" required>
            </div>
            <div class="mb-4">
                <label for="password_confirmation" class="block text-gray-700 text-sm font-bold mb-2">Confirmation du mot de passe</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500" placeholder="Confirmez votre mot de passe" required>
            </div>
            <div class="mb-4">
                <div class="relative">
                    <label for="id_service" class="block text-gray-700 text-sm font-bold mb-2">Service</label>
                    <input type="text" id="id_service" name="id_service" class="w-full px-3 py-2 mb-4 border rounded-lg focus:outline-none focus:border-blue-500" placeholder="Rechercher un service">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                        <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a4 4 0 1 1-8 0 4 4 0 0 1 8 0zm4 4l-4 4m0 0l-4-4m4 4V7"></path>
                        </svg>
                    </div>
            </div>
        
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">S'inscrire</button>
                <a href="{{ route('login') }}" class="text-blue-500 hover:text-blue-600 text-sm">Connexion</a>
            </div>
        </form>
    </div>
</div>
</body>
</html>
