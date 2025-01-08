@extends('admin.admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('title', 'Modification des champs de colonnes supplémentaires pour le ' . $nameService)

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

<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mt-4 mb-12">Modification des paramètres pour le {{$nameService }}</h1>

    <!-- Section des champs de colonnes supplémentaires -->
    <h2 class="text-lg font-semibold mb-4">Liste des champs de colonnes supplémentaires</h2>
    <div class="flex mt-4">
        <div class="w-1/2 border p-4 mr-4">
            <h2 class="text-lg font-semibold mb-4">Liste de champs</h2>
            <ul>
                @foreach($additionalColumns as $column)
                <li>
                    <div class="flex justify-between items-center">
                        <span id="column_{{ $column->id }}" class="editable mb-4" contenteditable="false" data-required="{{ $column->required }}">
                            {{ $column->name }}
                        </span>
                        <div class="flex items-center">
                            <button id="editButton_{{ $column->id }}" onclick="editColumn({{ $column->id }})" class="text-blue-500 hover:text-blue-700 mr-2 mb-4">
                                @if($column->editable)
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="h-4 w-4 fill-current text-green-500"></svg>
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="h-4 w-4">
                                    <!-- icône du crayon -->
                                    <path d="M410.3 231l11.3-11.3-33.9-33.9-62.1-62.1L291.7 89.8l-11.3 11.3-22.6 22.6L58.6 322.9c-10.4 10.4-18 23.3-22.2 37.4L1 480.7c-2.5 8.4-.2 17.5 6.1 23.7s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L387.7 253.7 410.3 231zM160 399.4l-9.1 22.7c-4 3.1-8.5 5.4-13.3 6.9L59.4 452l23-78.1c1.4-4.9 3.8-9.4 6.9-13.3l22.7-9.1v32c0 8.8 7.2 16 16 16h32zM362.7 18.7L348.3 33.2 325.7 55.8 314.3 67.1l33.9 33.9 62.1 62.1 33.9 33.9 11.3-11.3 22.6-22.6 14.5-14.5c25-25 25-65.5 0-90.5L453.3 18.7c-25-25-65.5-25-90.5 0zm-47.4 168l-144 144c-6.2 6.2-16.4 6.2-22.6 0s-6.2-16.4 0-22.6l144-144c6.2-6.2 16.4-6.2 22.6 0s6.2 16.4 0 22.6z"/>
                                </svg>
                                @endif
                            </button>
                            <form action="{{ route('admin.courier.destroyColumn', $column->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirmDelete()" class="text-red-500 hover:text-red-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="h-4 w-4">
                                        <!-- icône de la poubelle -->
                                        <path d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
        <div class="w-1/2">
            <h2 class="text-lg font-semibold mb-2">Ajouter un champ</h2>
            <form action="{{ route('admin.courier.storeColumns') }}" method="POST">
                @csrf
                <input type="text" name="name" placeholder="Nom du nouveau champ" class="border rounded px-2 py-1 mb-2">
                <div class="flex items-center mb-4">
                    <input type="checkbox" id="required" name="required" class="mr-2">
                    <label for="required">Obligatoire</label>
                </div>
                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mr-2">Ajouter</button>
            </form>
        </div>
    </div>

    <!-- Section des natures de documents -->
    <h2 class="text-lg font-semibold mb-4 mt-8">Modification des natures de documents</h2>
    <div class="flex mt-4">
        <div class="w-1/2 border p-4 mr-4">
            <h2 class="text-lg font-semibold mb-4">Liste de natures</h2>
            <ul>
                @foreach($categories as $category)
                <li>
                    <div class="flex justify-between items-center">
                        <span id="nature_{{ $category->id }}" class="editable mb-4" contenteditable="false" data-required="{{ $category->required }}">
                            {{ $category->name }}
                        </span>
                        <div class="flex items-center">
                            <button id="editNatureButton_{{ $category->id }}" onclick="editNature({{ $category->id }})" class="text-blue-500 hover:text-blue-700 mr-2 mb-4">
                                @if($category->editable)
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="h-4 w-4 fill-current text-green-500"></svg>
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="h-4 w-4">
                                    <!-- icône du crayon -->
                                    <path d="M410.3 231l11.3-11.3-33.9-33.9-62.1-62.1L291.7 89.8l-11.3 11.3-22.6 22.6L58.6 322.9c-10.4 10.4-18 23.3-22.2 37.4L1 480.7c-2.5 8.4-.2 17.5 6.1 23.7s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L387.7 253.7 410.3 231zM160 399.4l-9.1 22.7c-4 3.1-8.5 5.4-13.3 6.9L59.4 452l23-78.1c1.4-4.9 3.8-9.4 6.9-13.3l22.7-9.1v32c0 8.8 7.2 16 16 16h32zM362.7 18.7L348.3 33.2 325.7 55.8 314.3 67.1l33.9 33.9 62.1 62.1 33.9 33.9 11.3-11.3 22.6-22.6 14.5-14.5c25-25 25-65.5 0-90.5L453.3 18.7c-25-25-65.5-25-90.5 0zm-47.4 168l-144 144c-6.2 6.2-16.4 6.2-22.6 0s-6.2-16.4 0-22.6l144-144c6.2-6.2 16.4-6.2 22.6 0s6.2 16.4 0 22.6z"/>
                                </svg>
                                @endif
                            </button>
                            <form action="{{ route('admin.courier.destroyNature', $category->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirmDelete()" class="text-red-500 hover:text-red-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="h-4 w-4">
                                        <!-- icône de la poubelle -->
                                        <path d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
        <div class="w-1/2">
            <h2 class="text-lg font-semibold mb-2">Ajouter une nature</h2>
            <form action="{{ route('admin.courier.storeNature') }}" method="POST">
                @csrf
                <input type="text" name="name" placeholder="Nom de la nouvelle nature du document" class="border rounded px-2 py-1 mb-2">
                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mr-2">Ajouter</button>
            </form>
        </div>
    </div>

    <!-- Section des agents traitants -->
    <h2 class="text-lg font-semibold mb-4 mt-8">Modification des agents traitants</h2>
    <div class="flex mt-4">
        <div class="w-1/2 border p-4 mr-4">
            <h2 class="text-lg font-semibold mb-4">Liste des agents traitants</h2>
            <ul>
                @foreach($agents as $agent)
                <li>
                    <div class="flex justify-between items-center">
                        <span id="agent_{{ $agent->id }}" class="editable mb-4" contenteditable="false" data-required="{{ $agent->required ?? '0' }}">
                            {{ $agent->last_name }} {{ $agent->first_name }}
                        </span>
                        <div class="flex items-center">
                            <button id="editAgentButton_{{ $agent->id }}" onclick="editAgent({{ $agent->id }})" class="text-blue-500 hover:text-blue-700 mr-2 mb-4">
                                @if($agent->editable)
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="h-4 w-4 fill-current text-green-500">
                                        <path d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z"/>
                                    </svg>
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="h-4 w-4">
                                    <!-- icône du crayon -->
                                    <path d="M410.3 231l11.3-11.3-33.9-33.9-62.1-62.1L291.7 89.8l-11.3 11.3-22.6 22.6L58.6 322.9c-10.4 10.4-18 23.3-22.2 37.4L1 480.7c-2.5 8.4-.2 17.5 6.1 23.7s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L387.7 253.7 410.3 231zM160 399.4l-9.1 22.7c-4 3.1-8.5 5.4-13.3 6.9L59.4 452l23-78.1c1.4-4.9 3.8-9.4 6.9-13.3l22.7-9.1v32c0 8.8 7.2 16 16 16h32zM362.7 18.7L348.3 33.2 325.7 55.8 314.3 67.1l33.9 33.9 62.1 62.1 33.9 33.9 11.3-11.3 22.6-22.6 14.5-14.5c25-25 25-65.5 0-90.5L453.3 18.7c-25-25-65.5-25-90.5 0zm-47.4 168l-144 144c-6.2 6.2-16.4 6.2-22.6 0s-6.2-16.4 0-22.6l144-144c6.2-6.2 16.4-6.2 22.6 0s6.2 16.4 0 22.6z"/>
                                </svg>
                                @endif
                            </button>
                            <form action="{{ route('admin.courier.destroyAgent', $agent->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirmDelete()" class="text-red-500 hover:text-red-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="h-4 w-4">
                                        <path d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>

        <!-- Formulaire pour ajouter un agent -->
        <div class="w-1/2">
            <h2 class="text-lg font-semibold mb-2">Ajouter un agent traitant</h2>
            <form action="{{ route('admin.courier.storeAgent') }}" method="POST">
                @csrf
                <div class="flex flex-wrap gap-4">
                    <input type="text" name="last_name" placeholder="Nom de famille" class="border rounded px-2 py-1 mb-2 w-48">
                    <input type="text" name="first_name" placeholder="Prénom" class="border rounded px-2 py-1 mb-2 w-48">
                    <input type="text" name="email" placeholder="Adresse e-mail" class="border rounded px-2 py-1 mb-2 w-full">
                </div>
                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mt-2">Ajouter</button>
            </form>
        </div>
    </div>



    <h2 class="text-lg font-semibold mb-4 mt-8">Services</h2>
    <div class="flex">
        <!-- Liste complète des services disponibles -->
        <div class="w-1/2 p-4 border mr-4">
            <h2 class="text-lg font-semibold mb-2">Tous les services disponibles</h2>
            <ul id="available-services" class="border rounded p-2 h-64 overflow-y-auto">
                @foreach($services as $service)
                    <li id="service-{{ $service->id }}" data-id="{{ $service->id }}" class="py-1 px-2 cursor-pointer hover:bg-gray-200">
                        {{ $service->name }}
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Liste des services sélectionnés pour l'index -->
        <div class="w-1/2 p-4 border">
            <h2 class="text-lg font-semibold mb-2">Services sélectionnés pour l'index</h2>
            <ul id="selected-services" class="border rounded p-2 h-64 overflow-y-auto">
                <!-- Les services sélectionnés apparaîtront ici -->
            </ul>
        </div>
    </div>

    <!-- Formulaire pour soumettre les services sélectionnés -->
    <form action="{{ route('admin.courier.updateSelectedServices') }}" method="POST" id="selected-services-form" class="mt-4">
        @csrf
        <input type="hidden" name="selected_services" id="selected-services-input">
        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Sauvegarder</button>
    </form>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const availableServices = document.getElementById('available-services');
        const selectedServices = document.getElementById('selected-services');
        const selectedServicesInput = document.getElementById('selected-services-input');
        

        // Fonction pour ajouter un service à la liste sélectionnée
        function addService(serviceElement) {
            const clone = serviceElement.cloneNode(true);
            clone.onclick = () => removeService(clone);
            selectedServices.appendChild(clone);
            updateSelectedServicesInput();
            serviceElement.remove();
        }

        // Fonction pour retirer un service de la liste sélectionnée
        function removeService(serviceElement) {
            const clone = serviceElement.cloneNode(true);
            clone.onclick = () => addService(clone);
            availableServices.appendChild(clone);
            updateSelectedServicesInput();
            serviceElement.remove();
        }

        // Mettre à jour l'input caché avec les IDs des services sélectionnés
        function updateSelectedServicesInput() {
            const selectedIds = Array.from(selectedServices.children).map(service => service.getAttribute('data-id'));
            selectedServicesInput.value = selectedIds.join(',');
        }

        // Initialiser les événements pour chaque service dans la liste complète
        Array.from(availableServices.children).forEach(service => {
            service.onclick = () => addService(service);
        });
    });
    

    function confirmDelete() {
        return confirm('Êtes-vous sûr de vouloir supprimer ce champ ?');
    }
    function editColumn(id) {
    var column = document.getElementById('column_' + id);
    var editable = column.contentEditable === 'true';
    column.contentEditable = !editable;
    
    // Récupérer l'état de l'obligation du champ en utilisant data-required
    var required = column.getAttribute('data-required') === '1'; // Convertir en booléen
    console.log(required);
    if (!editable) {
        column.focus();
        var editButton = document.getElementById('editButton_' + id);

        // Créer une case à cocher "Obligatoire"
        var requiredCheckbox = document.createElement('input');
        requiredCheckbox.setAttribute('type', 'checkbox');
        requiredCheckbox.setAttribute('id', 'required_' + id);
        requiredCheckbox.setAttribute('name', 'required');
        requiredCheckbox.setAttribute('class', 'mr-2 mb-4');
        
        // Cocher la case si le champ est déjà obligatoire
        requiredCheckbox.checked = required;

        // Créer un label pour la case à cocher
        var requiredLabel = document.createElement('label');
        requiredLabel.setAttribute('class', 'mr-2 mb-4');
        requiredLabel.setAttribute('for', 'required_' + id);
        requiredLabel.textContent = 'Oblig.';

        // Ajouter la case à cocher et le label à la div des boutons
        var buttonsDiv = editButton.parentElement;
        buttonsDiv.insertBefore(requiredLabel, editButton);
        buttonsDiv.insertBefore(requiredCheckbox, editButton);

        editButton.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="h-4 w-4 fill-current text-green-500"><path d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z"/></svg>';
    } else {
        submitEdit(id);
    }
}



function submitEdit(id) {
    var column = document.getElementById('column_' + id);
    var newValue = column.innerText.trim();
    // Récupérer l'état de l'obligation du champ en utilisant data-required
    var required = column.getAttribute('data-required') === '1'; // Convertir en booléen

    // Mettre à jour la valeur du champ dans la base de données en soumettant un formulaire
    var form = document.createElement('form');
    form.setAttribute('method', 'POST');
    form.setAttribute('action', '/admin/courier/additionalColumns/' + id);

    var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    // Ajouter le champ CSRF
    var csrfField = document.createElement('input');
    csrfField.setAttribute('type', 'hidden');
    csrfField.setAttribute('name', '_token');
    csrfField.setAttribute('value', csrfToken);
    form.appendChild(csrfField);

    // Ajouter le champ 'name' avec la nouvelle valeur
    var nameField = document.createElement('input');
    nameField.setAttribute('type', 'hidden');
    nameField.setAttribute('name', 'name');
    nameField.setAttribute('value', newValue);
    form.appendChild(nameField);

    // Ajouter le champ 'required' avec la valeur de l'attribut 'required'
    var requiredField = document.createElement('input');
    requiredField.setAttribute('type', 'hidden');
    requiredField.setAttribute('name', 'required');
    requiredField.setAttribute('value', required ? '1' : '0'); // Convertir en chaîne de caractères '0' ou '1'
    form.appendChild(requiredField);

    // Soumettre le formulaire
    document.body.appendChild(form);
    form.submit();

}
function editNature(id) {
    var nature = document.getElementById('nature_' + id);
    var editable = nature.contentEditable === 'true';
    nature.contentEditable = !editable;

    if (!editable) {
        nature.focus();
        var editButton = document.getElementById('editNatureButton_' + id);

        // Modifier le contenu du bouton pour afficher la coche
        editButton.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="h-4 w-4 fill-current text-green-500"><path d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z"/></svg>';
    } else {
        submitNatureEdit(id);
    }
}



function submitNatureEdit(id) {
    var nature = document.getElementById('nature_' + id);
    var newValue = nature.innerText.trim();

    // Mettre à jour la valeur du champ dans la base de données en soumettant un formulaire
    var form = document.createElement('form');
    form.setAttribute('method', 'POST');
    form.setAttribute('action', '/admin/courier/categories/' + id); // Utiliser l'URL appropriée pour votre route

    var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    // Ajouter le champ CSRF
    var csrfField = document.createElement('input');
    csrfField.setAttribute('type', 'hidden');
    csrfField.setAttribute('name', '_token');
    csrfField.setAttribute('value', csrfToken);
    form.appendChild(csrfField);

    // Ajouter le champ 'name' avec la nouvelle valeur
    var nameField = document.createElement('input');
    nameField.setAttribute('type', 'hidden');
    nameField.setAttribute('name', 'name');
    nameField.setAttribute('value', newValue);
    form.appendChild(nameField);

    // Soumettre le formulaire
    document.body.appendChild(form);
    form.submit();

}




</script>

@endsection