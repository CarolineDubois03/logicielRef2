@extends('admin.admin')
@section('title', 'Paramètres')

@include('nav')

@section('content')
<style></style>
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
                                <th class="border px-4 py-2">Crée le</th>
                                <th class="border px-4 py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($agents as $agent)
                            <tr>
                                <td class="border px-4 py-2">{{ $agent->first_name }} {{ $agent->last_name }}</td>
                                <td class="border px-4 py-2">{{ $agent->created_at->format('d/m/Y') }}</td>
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

                



                <!-- Onglet Catégories -->
<div id="categories" class="tab-content hidden">
    <h2 class="text-lg font-bold mb-4">Liste des catégories</h2>

    <!-- Bouton pour ajouter une catégorie -->
    <div class="mb-4">
        <button class="bg-green-500 text-white py-0.5 px-1.5 text-xs rounded hover:bg-green-700" onclick="toggleModal('add-category-modal')">
            + Ajouter une catégorie
        </button>
    </div>

    <!-- Table des catégories -->
    <table class="w-full border-collapse">
        <thead>
            <tr>
                <th class="border px-4 py-2">Nom</th>
                <th class="border px-4 py-2">Créé le</th>
                <th class="border px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
            <tr>
                <td class="border px-4 py-2">{{ $category->name }}</td>
                <td class="border px-4 py-2">{{ $category->created_at->format('d/m/Y') }}</td>
                <td class="border px-4 py-2">
                    <!-- Bouton pour modifier une catégorie -->
                    <button class="bg-blue-500 text-white py-0.5 px-1.5 text-xs rounded hover:bg-blue-700" onclick="editCategory({{ $category->id }}, '{{ $category->name }}')">
                        Modifier
                    </button>

                    <!-- Formulaire pour supprimer une catégorie -->
                    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 text-white py-0.5 px-1.5 text-xs rounded hover:bg-red-700">Supprimer</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Modal pour ajouter une catégorie -->
    <div id="add-category-modal" class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center">
        <form action="{{ route('admin.categories.store') }}" method="POST" class="bg-white p-6 rounded shadow-md max-w-md w-full">
            @csrf
            <h2 class="text-lg font-bold mb-4 text-gray-800">Ajouter une catégorie</h2>
            <label for="category-name" class="block text-sm font-medium text-gray-700">Nom</label>
            <input type="text" id="category-name" name="name" class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
            <div class="mt-4 flex justify-end">
                <button type="button" class="mr-2 bg-gray-500 text-white py-1 px-3 rounded hover:bg-gray-700" onclick="toggleModal('add-category-modal')">Annuler</button>
                <button type="submit" class="bg-indigo-600 text-white py-1 px-3 rounded hover:bg-indigo-700">Ajouter</button>
            </div>
        </form>
    </div>

    <!-- Modal pour modifier une catégorie -->
    <div id="edit-category-modal" class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center">
        <form id="edit-category-form" method="POST" action="" class="bg-white p-6 rounded shadow-md max-w-md w-full">
            @csrf
            @method('PUT')
            <h2 class="text-lg font-bold mb-4 text-gray-800">Modifier une catégorie</h2>
            <label for="edit-category-name" class="block text-sm font-medium text-gray-700">Nom</label>
            <input type="text" id="edit-category-name" name="name" class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
            <div class="mt-4 flex justify-end">
                <button type="button" class="mr-2 bg-gray-500 text-white py-1 px-3 rounded hover:bg-gray-700" onclick="toggleModal('edit-category-modal')">Annuler</button>
                <button type="submit" class="bg-indigo-600 text-white py-1 px-3 rounded hover:bg-indigo-700">Enregistrer</button>
            </div>
        </form>
    </div>
</div>

<script>
    function editCategory(id, name) {
        const form = document.getElementById('edit-category-form');
        form.action = `/admin/categories/${id}`;
        document.getElementById('edit-category-name').value = name;
        toggleModal('edit-category-modal');
    }
</script>

                <!-- Onglet Utilisateurs -->
<div id="users" class="tab-content hidden">
    <h2 class="text-lg font-bold mb-4">Liste des utilisateurs</h2>

    <!-- Bouton pour ajouter un utilisateur -->
    <div class="mb-4">
        <button class="bg-green-500 text-white py-0.5 px-1.5 text-xs rounded hover:bg-green-700" onclick="toggleModal('add-user-modal')">
            + Ajouter un utilisateur
        </button>
    </div>

    <!-- Table des utilisateurs -->
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
                    <!-- Bouton pour modifier un utilisateur -->
                    <button class="bg-blue-500 text-white py-0.5 px-1.5 text-xs rounded hover:bg-blue-700" onclick="editUser({{ $user->id }}, '{{ $user->first_name }} {{ $user->last_name }}', '{{ $user->email }}')">
                        Modifier
                    </button>

                    <!-- Formulaire pour supprimer un utilisateur -->
                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 text-white py-0.5 px-1.5 text-xs rounded hover:bg-red-700">Supprimer</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Modal pour ajouter un utilisateur -->
    <div id="add-user-modal" class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center">
        <form action="{{ route('admin.users.store') }}" method="POST" class="bg-white p-6 rounded shadow-md max-w-md w-full">
            @csrf
            <h2 class="text-lg font-bold mb-4 text-gray-800">Ajouter un utilisateur</h2>
            <label for="user-first-name" class="block text-sm font-medium text-gray-700">Prénom</label>
            <input type="text" id="user-first-name" name="first_name" class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
            
            <label for="user-last-name" class="block text-sm font-medium text-gray-700 mt-4">Nom</label>
            <input type="text" id="user-last-name" name="last_name" class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
            
            <label for="user-email" class="block text-sm font-medium text-gray-700 mt-4">Email</label>
            <input type="email" id="user-email" name="email" class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
            
            <label for="user-password" class="block text-sm font-medium text-gray-700 mt-4">Mot de passe</label>
            <input type="password" id="user-password" name="password" class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">

            <div class="mt-4 flex justify-end">
                <button type="button" class="mr-2 bg-gray-500 text-white py-0.5 px-1.5 rounded hover:bg-gray-700" onclick="toggleModal('add-user-modal')">Annuler</button>
                <button type="submit" class="bg-indigo-600 text-white py-0.5 px-1.5 rounded hover:bg-indigo-700">Ajouter</button>
            </div>
        </form>
    </div>

    <!-- Modal pour modifier un utilisateur -->
    <div id="edit-user-modal" class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center">
        <form id="edit-user-form" method="POST" action="" class="bg-white p-6 rounded shadow-md max-w-md w-full">
            @csrf
            @method('PUT')
            <h2 class="text-lg font-bold mb-4 text-gray-800">Modifier un utilisateur</h2>
            <label for="edit-user-first-name" class="block text-sm font-medium text-gray-700">Prénom</label>
            <input type="text" id="edit-user-first-name" name="first_name" class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
            
            <label for="edit-user-last-name" class="block text-sm font-medium text-gray-700 mt-4">Nom</label>
            <input type="text" id="edit-user-last-name" name="last_name" class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
            
            <label for="edit-user-email" class="block text-sm font-medium text-gray-700 mt-4">Email</label>
            <input type="email" id="edit-user-email" name="email" class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">

            <div class="mt-4 flex justify-end">
                <button type="button" class="mr-2 bg-gray-500 text-white py-0.5 px-1.5 rounded hover:bg-gray-700" onclick="toggleModal('edit-user-modal')">Annuler</button>
                <button type="submit" class="bg-indigo-600 text-white py-0.5 px-1.5 rounded hover:bg-indigo-700">Enregistrer</button>
            </div>
        </form>
    </div>
</div>

                <!-- Onglet Destinataires -->
                <div id="recipients" class="tab-content hidden">
    <h2 class="text-lg font-bold mb-4">Liste des destinataires</h2>

    <!-- Bouton pour ajouter un destinataire -->
    <div class="mb-4">
        <button class="bg-green-500 text-white py-1 px-3 rounded hover:bg-green-700" onclick="toggleModal('add-recipient-modal')">
            + Ajouter un destinataire
        </button>
    </div>

    <!-- Table des destinataires -->
    <table class="w-full border-collapse">
        <thead>
            <tr>
                <th class="border px-4 py-2">Nom</th>
                <th class="border px-4 py-2">Crée le</th>
                <th class="border px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($recipients as $recipient)
            <tr>
                <td class="border px-4 py-2">{{ $recipient->label }}</td>
                <td class="border px-4 py-2">{{ $recipient->created_at->format('d/m/Y') }}</td>
                <td class="border px-4 py-2">
                    <!-- Bouton pour modifier un destinataire -->
                    <button class="bg-blue-500 text-white py-1 px-3 text-xs rounded hover:bg-blue-700" onclick="editRecipient({{ $recipient->id }}, '{{ $recipient->label }}')">
                        Modifier
                    </button>


                    <!-- Formulaire pour supprimer un destinataire -->
                    <form action="{{ route('admin.recipients.destroy', $recipient->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 text-white py-1 px-3 text-xs rounded hover:bg-red-700">Supprimer</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

   <!-- Modal pour ajouter un destinataire -->
<div id="add-recipient-modal" class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center">
    <form action="{{ route('admin.recipients.store') }}" method="POST" class="bg-white p-6 rounded shadow-md max-w-md w-full">
        @csrf
        <h2 class="text-lg font-bold mb-4 text-gray-800">Ajouter un destinataire</h2>
        <label for="recipient-name" class="block text-sm font-medium text-gray-700">Nom</label>
        <input type="text" id="recipient-name" name="label" class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
        <div class="mt-4 flex justify-end">
            <button type="button" class="mr-2 bg-gray-500 text-white py-1 px-3 rounded hover:bg-gray-700" onclick="toggleModal('add-recipient-modal')">Annuler</button>
            <button type="submit" class="bg-indigo-600 text-white py-1 px-3 rounded hover:bg-indigo-700">Ajouter</button>
        </div>
    </form>
</div>

<!-- Modal pour modifier un destinataire -->
<div id="edit-recipient-modal" class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center">
    <form id="edit-recipient-form" method="POST" action="" class="bg-white p-6 rounded shadow-md max-w-md w-full">
        @csrf
        @method('PUT')
        <h2 class="text-lg font-bold mb-4 text-gray-800">Modifier un destinataire</h2>
        <label for="edit-recipient-name" class="block text-sm font-medium text-gray-700">Nom</label>
        <input type="text" id="edit-recipient-name" name="label" class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
        <div class="mt-4 flex justify-end">
            <button type="button" class="mr-2 bg-gray-500 text-white py-1 px-3 rounded hover:bg-gray-700" onclick="toggleModal('edit-recipient-modal')">Annuler</button>
            <button type="submit" class="bg-indigo-600 text-white py-1 px-3 rounded hover:bg-indigo-700">Enregistrer</button>
        </div>
    </form>
</div>


<script>
    function toggleModal(modalId) {
        const modal = document.getElementById(modalId);
        modal.classList.toggle('hidden');
    }

    function editRecipient(id, label) {
    const form = document.getElementById('edit-recipient-form');
    form.action = `/admin/recipients/${id}`;
    document.getElementById('edit-recipient-name').value = label;
    toggleModal('edit-recipient-modal');

    function editUser(id, firstName, lastName, email) {
    const form = document.getElementById('edit-user-form');
    form.action = `/admin/users/${id}`;
    document.getElementById('edit-user-first-name').value = firstName;
    document.getElementById('edit-user-last-name').value = lastName;
    document.getElementById('edit-user-email').value = email;
    toggleModal('edit-user-modal');
}

}

</script>
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
