@extends('admin.admin')
@section('title', 'Paramètres')

@include('nav')

@section('content')
<style>
#flash-message {
    opacity: 1;
    transition: opacity 0.5s ease-in-out;
}
/* Style commun pour les boutons Ajouter */
.btn-add {
    background-color: #38a169; /* Vert */
    color: white;
    font-size: 0.875rem; /* Texte légèrement plus grand */
    padding: 0.4rem 1rem; /* Un peu plus large */
    border-radius: 0.375rem; /* Bord arrondi */
    transition: background-color 0.2s ease-in-out;
}

.btn-add:hover {
    background-color: #2f855a; /* Vert plus foncé */
}

/* Style commun pour les boutons Modifier */
.btn-edit {
    background-color: #3182ce; /* Bleu */
    color: white;
    font-size: 0.75rem;
    padding: 0.2rem 0.5rem;
    border-radius: 0.375rem;
    transition: background-color 0.2s ease-in-out;
}

.btn-edit:hover {
    background-color: #2b6cb0; /* Bleu plus foncé */
}

/* Style commun pour les boutons Supprimer */
.btn-delete {
    background-color: #e53e3e; /* Rouge */
    color: white;
    font-size: 0.75rem;
    padding: 0.2rem 0.5rem;
    border-radius: 0.375rem;
    transition: background-color 0.2s ease-in-out;
}

.btn-delete:hover {
    background-color: #c53030; /* Rouge plus foncé */
}


</style>

<div class="px-8 py-10 bg-gray-50">
    <!-- Bouton de retour -->
    <div class="flex justify-start mb-6">
        <a href="{{ route('admin.courier.index') }}" class="text-blue-500 hover:underline flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="fill-current h-5 w-5 mr-1">
                <path fill-rule="evenodd" d="M11.293 4.293a1 1 0 011.414 1.414l-4 4a1 1 0 010 1.414l4 4a1 1 0 01-1.414 1.414l-5-5a1 1 0 010-1.414l5-5a1 1 0 011.414 0z" clip-rule="evenodd"></path>
            </svg>
            Retour
        </a>
    </div>

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
    <button class="btn-add" onclick="toggleModal('add-agent-modal')">
    + Ajouter un agent
    </button>

</div>

    <table class="w-full border-collapse">
        <thead>
            <tr>
                <th class="border px-4 py-2">Nom</th>
                <th class="border px-4 py-2">Prénom</th>
                <th class="border px-4 py-2">Email</th>
                <th class="border px-4 py-2">Rôle</th>
                <th class="border px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
        @if($agents->isEmpty())
    <p>Aucun agent trouvé.</p>
@endif

            @foreach($agents as $agent)
            

            <tr>
                <td class="border px-4 py-2">{{ $agent->last_name }}</td>
                <td class="border px-4 py-2">{{ $agent->first_name }}</td>
                <td class="border px-4 py-2">{{ $agent->email }}</td>
                <td class="border px-4 py-2">{{ $agent->role }}</td>
                <td class="border px-4 py-2">
                    <!-- Retirer l'utilisateur des agents -->
                <form action="{{ route('admin.agents.remove', $agent->id) }}" method="POST" class="inline">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn-delete">
                        Retirer des agents
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
            
        </tbody>
    </table>
</div>

<div id="add-agent-modal" class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center">
    <form action="{{ route('admin.agents.add') }}" method="POST" class="bg-white p-6 rounded shadow-md max-w-md w-full">
        @csrf
        <h2 class="text-lg font-bold mb-4 text-gray-800">Ajouter un agent</h2>
        
        <label for="user_id" class="block text-sm font-medium text-gray-700">Sélectionner un utilisateur</label>
        <select id="user_id" name="user_id" class="form-select">
    <option value="" disabled selected>-- Sélectionnez un utilisateur --</option>
    @foreach($nonAgents as $user)
        <option value="{{ $user->id }}">{{ $user->last_name }} {{ $user->first_name }}</option>
    @endforeach
    
</select>


        <div class="mt-4 flex justify-end">
            <button type="button" class="mr-2 bg-gray-500 text-white py-1 px-3 rounded hover:bg-gray-700" onclick="toggleModal('add-agent-modal')">Annuler</button>
            <button type="submit" class="bg-indigo-600 text-white py-1 px-3 rounded hover:bg-indigo-700">Ajouter</button>
        </div>
    </form>
</div>



                



                <!-- Onglet Catégories -->
<div id="categories" class="tab-content hidden">
    <h2 class="text-lg font-bold mb-4">Liste des catégories</h2>

    <!-- Bouton pour ajouter une catégorie -->
    <div class="mb-4">
        <button class="btn-add" onclick="toggleModal('add-category-modal')">
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
                    <button class="btn-edit" onclick="editCategory({{ $category->id }}, '{{ $category->name }}')">
                        Modifier
                    </button>


                    <!-- Formulaire pour supprimer une catégorie -->
                    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-delete">
                            Supprimer
                        </button>
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
        <button  class="btn-add" onclick="toggleModal('add-user-modal')">
            + Ajouter un utilisateur
        </button>
    </div>

    <!-- Table des utilisateurs -->
    <table class="w-full border-collapse">
        <thead>
            <tr>
                <th class="border px-4 py-2">Nom</th>
                <th class="border px-4 py-2">Prénom</th>
                <th class="border px-4 py-2">Email</th>
                <th class="border px-4 py-2">Rôle</th>
                <th class="border px-4 py-2">Services</th>
                <th class="border px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td class="border px-4 py-2">{{ $user->last_name }}</td>
                <td class="border px-4 py-2">{{ $user->first_name }}</td>
                <td class="border px-4 py-2">{{ $user->email }}</td>
                <td class="border px-4 py-2">{{ $user->role }}</td>
                <td class="border px-4 py-2">{{ $user->id_service }}</td>

                <td class="border px-4 py-2">
                    <!-- Bouton pour modifier un utilisateur -->
                    <button class="btn-edit" onclick="editUser({{ $user->id }}, '{{ $user->first_name }}', '{{ $user->last_name }}', '{{ $user->email }}', '{{$user->role}}', '{{$user->id_service}}')">
                        Modifier
                    </button>

                    <!-- Formulaire pour supprimer un utilisateur -->
                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-delete">Supprimer</button>
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

            <label for="edit-user-role" class="block text-sm font-medium text-gray-700 mt-4">Rôle</label>
                <select 
                    id="edit-user-role" 
                    name="role" 
                    class="form-select"
                    @if(auth()->user()->role !== 'admin') disabled @endif>
                    <option value="admin">Admin</option>
                    <option value="responsable">Responsable</option>
                    <option value="user">Utilisateur</option>
                </select>

                <label for="edit-user-id_service" class="block text-sm font-medium text-gray-700 mt-4">Service</label>
                <select 
                    id="edit-user-id_service" 
                    name="id_service" 
                    class="form-select"
                    @if(auth()->user()->role !== 'admin') disabled @endif>
                    @foreach($services as $service)
                        <option value="{{ $service->id }}">{{ $service->name }}</option>
                    @endforeach
                </select>

            
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
        <button  class="btn-add" onclick="toggleModal('add-recipient-modal')">
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
                    <button class="btn-edit" onclick="editRecipient({{ $recipient->id }}, '{{ $recipient->label }}')">
                        Modifier
                    </button>


                    <!-- Formulaire pour supprimer un destinataire -->
                    <form action="{{ route('admin.recipients.destroy', $recipient->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-delete">Supprimer</button>
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
    }


function editUser(id, firstName, lastName, email, role, id_service) {
    console.log(id, firstName, lastName, email, role, id_service);
    const form = document.getElementById('edit-user-form');
    form.action = `/admin/users/${id}`;
    document.getElementById('edit-user-first-name').value = firstName;
    document.getElementById('edit-user-last-name').value = lastName;
    document.getElementById('edit-user-email').value = email;
    document.getElementById('edit-user-role').value = role;
    document.getElementById('edit-user-id_service').value = id_service;
    toggleModal('edit-user-modal');
    }

    function editAgent(id, lastName, firstName, email, role) {
    const form = document.getElementById('edit-agent-form');
    form.action = `/admin/agents/${id}`;
    document.getElementById('edit-agent-last-name').value = lastName;
    document.getElementById('edit-agent-first-name').value = firstName;
    document.getElementById('edit-agent-email').value = email;
    document.getElementById('edit-agent-role').value = role;
    toggleModal('edit-agent-modal');
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

    // Fonction pour afficher l'onglet actif
    function activateTab(tabName) {
        tabButtons.forEach((btn) => btn.classList.remove("text-indigo-600", "border-indigo-600"));
        tabContents.forEach((content) => content.classList.add("hidden"));

        const targetButton = [...tabButtons].find(
            (btn) => btn.getAttribute("data-target") === `#${tabName}`
        );
        const targetContent = document.querySelector(`#${tabName}`);

        if (targetButton && targetContent) {
            targetButton.classList.add("text-indigo-600", "border-indigo-600");
            targetContent.classList.remove("hidden");

            // Mettre à jour l'URL sans recharger la page
            history.pushState(null, null, `?tab=${tabName}`);
        }
    }

    const isAdmin = "{{ auth()->user()->role }}" === "admin";
    if (!isAdmin) {
        document.getElementById("edit-user-role").setAttribute("disabled", "true");
        document.getElementById("edit-user-id_service").setAttribute("disabled", "true");
    }

    // Détection de l'onglet actif via l'URL
    const urlParams = new URLSearchParams(window.location.search);
    const activeTab = urlParams.get("tab") || "agents"; // "agents" est l'onglet par défaut
    activateTab(activeTab);

    // Ajout des événements aux boutons
    tabButtons.forEach((button) => {
        button.addEventListener("click", function () {
            const tabName = this.getAttribute("data-target").replace("#", "");
            activateTab(tabName);
        });
    });

    // Gestion de la navigation "précédent/suivant" du navigateur
    window.addEventListener("popstate", () => {
        const urlParams = new URLSearchParams(window.location.search);
        const activeTab = urlParams.get("tab") || "agents";
        activateTab(activeTab);
    });

    // Gestion des messages flash
    const flashMessage = document.getElementById('flash-message');
    if (flashMessage) {
        // Cacher automatiquement le message après 3 secondes
        setTimeout(() => {
            flashMessage.style.transition = 'opacity 0.5s';
            flashMessage.style.opacity = '0';

            setTimeout(() => {
                flashMessage.remove();
            }, 500); // Temps pour le fade-out
        }, 3000); // Temps avant le fade-out
    }

    // Écouter les changements d'onglet pour cacher les messages
    tabButtons.forEach(button => {
        button.addEventListener('click', () => {
            if (flashMessage) {
                flashMessage.remove();
            }
        });
    });
});



</script>
@endsection
