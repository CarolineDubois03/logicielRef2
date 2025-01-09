@extends('admin.admin')
@section('title', 'Liste des courriers')

@include('nav')
@section('content')
<style>
    #deleteSelected {
        display: none;
    }
    .page-link {
        color: #fff;
        background-color: #c1c7c8;
        border-radius: 4px;
        padding: 5px 10px;
        text-decoration: none;
        transition: background-color 0.3s ease;
    }
    .page-link:hover {
        background-color: #2d3748;
    }
    .page-item.active .page-link {
        background-color: #2b6cb0;
    }
    table {
        table-layout: fixed;
        width: 100%;
        border-collapse: collapse;
    }
    th, td {
    padding: 4px 6px; /* Remplissage plus petit : 4px verticalement et 6px horizontalement */
    text-align: left;
    word-wrap: break-word;
    }

    tr {
        line-height: 1; /* Réduire la hauteur des lignes */
    }
    th {
        background-color: #4a5568;
        color: #fff;
        font-weight: bold;
    }
    tr:nth-child(even) {
        background-color: #f7fafc;
    }
    tr:nth-child(odd) {
        background-color: #edf2f7;
    }
    .action-buttons {
    display: flex;
    flex-direction: column; /* Aligner verticalement les boutons */
    align-items: center; /* Centrer les boutons horizontalement */
    gap: 0.3rem; /* Espacement entre les boutons */
}

.action-buttons a, .action-buttons button {
    padding: 3px 5px; /* Réduire les boutons pour qu'ils s'ajustent */
    font-size: 11px; /* Police réduite */
    text-align: center; /* Centrer le texte */
    border-radius: 3px;
    width: 70px; /* Largeur fixe pour uniformiser */
}

.action-buttons a {
    background-color: #4299e1;
    color: #fff;
    text-decoration: none;
}

.action-buttons button {
    background-color: #e53e3e;
    color: #fff;
    border: none;
}

.action-buttons a:hover {
    background-color: #2b6cb0;
}

.action-buttons button:hover {
    background-color: #c53030;
}

  
    .pagination {
        display: flex;
        justify-content: left; /* Centrer horizontalement */
        gap: 0.5rem; /* Espacement entre les numéros */
    }
    .page-item {
        display: inline-block; /* Assurer l'alignement horizontal */
    }
    .page-link {
        color: #000;
        text-decoration: none;
        padding: 0.4rem 0.8rem;
        border-radius: 4px;
        border: 1px solid #ddd;
        transition: background-color 0.3s ease;
    }
    .page-link:hover {
        background-color: #f0f0f0;
    }
    .page-item.active .page-link {
        background-color: #007bff;
        color: #fff;
        border-color: #007bff;
    }


</style>

<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Liste des courriers</h1>

    <div class="flex justify-between items-center mb-4">
        <form action="{{ route('admin.courier.index') }}" method="GET" class="flex items-center">
            <label for="year" class="mr-2 text-gray-600">Année :</label>
            <select name="year" id="year" class="border rounded px-2 py-1">
                @foreach($years as $year)
                    <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>{{ $year }}</option>
                @endforeach
            </select>
            <button type="submit" class="ml-2 bg-blue-500 text-white py-1 px-3 rounded hover:bg-blue-700">Filtrer</button>
        </form>

        <!-- Barre de recherche -->
        <form action="{{ route('admin.courier.index') }}" method="GET" class="flex items-center">
            <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Rechercher par objet ou destinataire" 
                class="border rounded px-4 py-2 w-64">
            <button type="submit" class="ml-2 bg-gray-500 text-white py-1 px-3 rounded hover:bg-gray-700">Rechercher</button>
        </form>

        <div>
            <a href="{{ route('admin.courier.create') }}" class="bg-green-500 text-white py-1 px-3 rounded hover:bg-green-700">+ Ajouter</a>
            <a href="{{ route('admin.courier.settings') }}" class="bg-blue-500 text-white py-1 px-3 rounded hover:bg-blue-700">Configurer</a>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="border border-gray-300">
            <thead>
                <tr>
                    <th class="w-10">
                        <input type="checkbox" id="selectAll" class="rounded border-gray-300">
                    </th>
                    <th class="w-16">N°</th>
                    <th class="w-32">Destinataire</th>
                    <th class="w-24">Date</th>
                    <th class="w-48">Objet</th>
                    <th class="w-32">Agent</th>
                    <th class="w-48">Copie à</th>
                    <th class="w-24">Nature</th>
                    <th class="w-32">Classement</th>
                    <th class="w-24">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($couriers as $courier)
                <tr>
                    <td>
                        <input type="checkbox" class="courierCheckbox border-gray-300" value="{{ $courier->id }}">
                    </td>
                    <td>{{ $courier->annual_id }}</td>
                    <td>{{ $courier->couriersRecipient->label ?? 'Non défini' }}</td>
                    <td>{{ $courier->created_at->format('d/m/Y') }}</td>
                    <td>{{ $courier->object }}</td>
                    <td>{{ $courier->handlingUser->last_name }} {{ $courier->handlingUser->first_name }}</td>
                    <td>
                        @if($courier->copiedUsers->isNotEmpty())
                            @foreach($courier->copiedUsers as $user)
                                <span class="inline-block bg-gray-200 rounded px-2 py-1 text-xs text-gray-700">
                                    {{ $user->last_name }} {{ $user->first_name }}
                                </span>
                            @endforeach
                        @else
                            Aucun
                        @endif
                    </td>
                    <td>{{ $courier->couriersType->name ?? 'Non défini' }}</td>
                    <td>{{ $courier->document_path }}</td>
                    <td class="action-buttons">
                        <a href="{{ route('admin.courier.edit', $courier->id) }}">Editer</a>
                        <form action="{{ route('admin.courier.destroy', $courier->id) }}" method="POST" class="inline">
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

    <div class="mt-4">
        {{ $couriers->appends(request()->except('page'))->links() }}
    </div>
</div>

<script>
    // Gérer la sélection "Tout sélectionner"
    document.getElementById('selectAll').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.courierCheckbox');
        checkboxes.forEach(checkbox => checkbox.checked = this.checked);
    });
</script>
@endsection
