@extends('admin.admin')
@section('title', 'Paramètres')

@include('nav')

@section('content')
<div class="px-8 py-10 bg-gray-50">
    <div class="max-w-5xl mx-auto bg-white shadow-lg rounded-xl">
        <div class="px-8 py-6 border-b border-gray-200">
            <h1 class="text-2xl font-bold text-gray-800">Paramètres</h1>
        </div>

        <div class="px-8 py-6">
            <!-- Onglets -->
            <div class="mb-6 border-b border-gray-200">
                <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                    <button class="tab-button text-indigo-600 border-indigo-600" data-target="#agents">
                        Agents
                    </button>
                    <button class="tab-button" data-target="#recipients">
                        Destinataires
                    </button>
                    <button class="tab-button" data-target="#categories">
                        Catégories
                    </button>
                    <button class="tab-button" data-target="#users">
                        Utilisateurs
                    </button>
                </nav>
            </div>

            <!-- Contenu des onglets -->
            <div id="tabs-content">
                <!-- Onglet Agents -->
                <div id="agents" class="tab-content">
                    <h2 class="text-lg font-bold mb-4">Liste des agents</h2>
                    <div class="mb-4">
                        <button class="bg-green-500 text-white py-1 px-3 rounded hover:bg-green-700" onclick="toggleModal('add-agent-modal')">
                            + Ajouter un agent
                        </button>
                    </div>
                    <table class="w-full border-collapse">
                        <thead>
                            <tr>
                                <th class="border px-4 py-2">Nom</th>
                                <th class="border px-4 py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($agents as $agent)
                            <tr>
                                <td class="border px-4 py-2">{{ $agent->first_name }} {{ $agent->last_name }}</td>
                                <td class="border px-4 py-2">
                                    <button class="bg-blue-500 text-white py-1 px-3 rounded hover:bg-blue-700" onclick="editAgent({{ $agent->id }}, '{{ $agent->first_name }} {{ $agent->last_name }}')">
                                        Modifier
                                    </button>
                                    <form action="{{ route('admin.agents.destroy', $agent->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 text-white py-1 px-3 rounded hover:bg-red-700">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Onglet Destinataires -->
                <div id="recipients" class="tab-content hidden">
                    <h2 class="text-lg font-bold mb-4">Liste des destinataires</h2>
                    <div class="mb-4">
                        <button class="bg-green-500 text-white py-1 px-3 rounded hover:bg-green-700" onclick="toggleModal('add-recipient-modal')">
                            + Ajouter un destinataire
                        </button>
                    </div>
                    <table class="w-full border-collapse">
                        <thead>
                            <tr>
                                <th class="border px-4 py-2">Nom</th>
                                <th class="border px-4 py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recipients as $recipient)
                            <tr>
                                <td class="border px-4 py-2">{{ $recipient->label }}</td>
                                <td class="border px-4 py-2">
                                    <button class="bg-blue-500 text-white py-1 px-3 rounded hover:bg-blue-700" onclick="editRecipient({{ $recipient->id }}, '{{ $recipient->label }}')">
                                        Modifier
                                    </button>
                                    <form action="{{ route('admin.recipients.destroy', $recipient->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 text-white py-1 px-3 rounded hover:bg-red-700">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Onglet Catégories -->
                <div id="categories" class="tab-content hidden">
                    <h2 class="text-lg font-bold mb-4">Liste des catégories</h2>
                    <div class="mb-4">
                        <button class="bg-green-500 text-white py-1 px-3 rounded hover:bg-green-700" onclick="toggleModal('add-category-modal')">
                            + Ajouter une catégorie
                        </button>
                    </div>
                    <table class="w-full border-collapse">
                        <thead>
                            <tr>
                                <th class="border px-4 py-2">Nom</th>
                                <th class="border px-4 py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $category)
                            <tr>
                                <td class="border px-4 py-2">{{ $category->name }}</td>
                                <td class="border px-4 py-2">
                                    <button class="bg-blue-500 text-white py-1 px-3 rounded hover:bg-blue-700" onclick="editCategory({{ $category->id }}, '{{ $category->name }}')">
                                        Modifier
                                    </button>
                                    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 text-white py-1 px-3 rounded hover:bg-red-700">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Onglet Utilisateurs -->
                <div id="users" class="tab-content hidden">
                    <h2 class="text-lg font-bold mb-4">Liste des utilisateurs</h2>
                    <div class="mb-4">
                        <button class="bg-green-500 text-white py-1 px-3 rounded hover:bg-green-700" onclick="toggleModal('add-user-modal')">
                            + Ajouter un utilisateur
                        </button>
                    </div>
                    <table class="w-full border-collapse">
                        <thead>
                            <tr>
                                <th class="border px-4 py-2">Nom</th>
                                <th class="border px-4 py-2">Email</th>
                                <th class="border px-4 py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td class="border px-4 py-2">{{ $user->first_name }} {{ $user->last_name }}</td>
                                <td class="border px-4 py-2">{{ $user->email }}</td>
                                <td class="border px-4 py-2">
                                    <button class="bg-blue-500 text-white py-1 px-3 rounded hover:bg-blue-700" onclick="editUser({{ $user->id }}, '{{ $user->first_name }} {{ $user->last_name }}', '{{ $user->email }}')">
                                        Modifier
                                    </button>
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 text-white py-1 px-3 rounded hover:bg-red-700">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const tabButtons = document.querySelectorAll(".tab-button");
        const tabContents = document.querySelectorAll(".tab-content");

        tabButtons.forEach((button) => {
            button.addEventListener("click", function () {
                tabButtons.forEach((btn) => btn.classList.remove("text-indigo-600", "border-indigo-600"));
                tabContents.forEach((content) => content.classList.add("hidden"));

                this.classList.add("text-indigo-600", "border-indigo-600");
                const target = document.querySelector(this.getAttribute("data-target"));
                target.classList.remove("hidden");
            });
        });
    });

    function toggleModal(modalId) {
        const modal = document.getElementById(modalId);
        modal.classList.toggle('hidden');
    }
</script>
@endsection
