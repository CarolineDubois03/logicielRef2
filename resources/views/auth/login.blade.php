<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Connexion</title>
    <style>
        /* Ajoutez le style pour l'overlay */
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
            z-index: -1;
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
            <h1 class="text-3xl text-center text-gray-800 font-bold mb-8">MonSite</h1>

            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="mb-4">
            <form method="post" action="{{ route('login') }}">
                @csrf
                @include('shared.input', ['label' => 'Adresse e-mail', 'name' => 'email', 'type' => 'email'])
                @include('shared.input', ['label' => 'Mot de passe', 'name' => 'password', 'type' => 'password'])

                <div class="flex items-center justify-between">
                    <button class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline mt-2">Connexion</button>
                    <!--<a href="{{ route('register') }}" class="text-blue-500 hover:text-blue-600 text-sm">S'inscrire</a> -->
                </div>
            </form>
        </div>
    </div>
</body>
</html>
