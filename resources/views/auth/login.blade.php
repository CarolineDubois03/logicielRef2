<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Connexion</title>
    <style>
        /* Overlay style */
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
    <!-- Background Overlay -->
    <div class="overlay"></div>

    <!-- Main Container -->
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white w-full max-w-md rounded-xl shadow-md overflow-hidden">
            <div class="px-6 py-8">
                <h1 class="text-2xl font-bold text-center text-gray-800 mb-6">Connexion Archivéo</h1>

                <!-- Display Errors -->
                @if($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4" role="alert">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Login Form -->
                <form method="post" action="{{ route('login') }}">
                    @csrf
                    
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700">Adresse e-mail</label>
                        <input type="email" id="email" name="email" 
                               class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
                    </div>

                    <div class="mb-6">
                        <label for="password" class="block text-sm font-medium text-gray-700">Mot de passe</label>
                        <input type="password" id="password" name="password" 
                               class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
                    </div>

                    <div class="flex items-center justify-between">
                        <button type="submit" class="bg-indigo-600 text-white py-2 px-4 rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
                            Connexion
                        </button>

                        <!-- Optional Register Link -->
                        <!--<a href="{{ route('register') }}" class="text-indigo-600 hover:text-indigo-700 text-sm">S'inscrire</a>-->
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
