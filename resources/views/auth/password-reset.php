@extends('admin.admin')

@section('title', 'Réinitialisation du mot de passe')

@section('content')
<div class="px-8 py-10 bg-gray-50 min-h-screen flex items-center justify-center">
    <div class="max-w-lg w-full bg-white shadow-lg rounded-xl p-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-6 text-center">Réinitialisation du mot de passe</h1>

        @if (session('status'))
            <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div>
                <label for="email" class="block text-lg font-medium text-gray-700">Adresse e-mail</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                    class="mt-1 block w-full rounded-lg px-4 py-2 border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
            </div>

            <div>
                <label for="password" class="block text-lg font-medium text-gray-700">Nouveau mot de passe</label>
                <input type="password" name="password" id="password" required
                    class="mt-1 block w-full rounded-lg px-4 py-2 border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
            </div>

            <div>
                <label for="password_confirmation" class="block text-lg font-medium text-gray-700">Confirmer le mot de passe</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required
                    class="mt-1 block w-full rounded-lg px-4 py-2 border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
            </div>

            <div class="flex justify-center">
                <button type="submit" class="px-6 py-3 text-lg font-medium text-white bg-indigo-600 rounded-lg shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Réinitialiser le mot de passe
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
