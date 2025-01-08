@extends('admin.admin')
@section('title', 'Liste des courriers')

@include('nav')
@section('content')
<style>
    #deleteSelected {
        display: none;
    }
    .page-item {
        display: inline-block;
        margin-right: 5px;
        margin-top: 5px;
    }
    .page-link {
        color: #000;
        text-decoration: none;
        padding: 0.10rem 0.30rem;
        border-radius: 4px;
        transition: background-color 0.3s ease;
    }
    .page-link:hover {
        background-color: #f0f0f0;
    }
    .page-item.active .page-link {
        background-color: #9acbff;
        color: #fff;
    }
</style>

<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mt-4 mb-8">Liste de courriers de {{$nameUser}}</h1>

    <div class="flex items-center mb-4">
        <form action="{{ route('admin.courier.index') }}" method="GET" class="flex items-center">
            <label for="year" class="mr-2">Année :</label>
            <select name="year" id="year" class="border rounded px-2 py-1">
                @foreach($years as $year)
                    <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>{{ $year }}</option>
                @endforeach
            </select>
            <button type="submit" class="bg-blue-300 hover:bg-blue-500 text-white font-bold py-1 px-2 rounded ml-2">Filtrer</button>
        </form>
    </div>

    <div class="flex items-center">
        <h2 class="text-lg font-semibold mr-4">Rechercher:</h2>
        <input type="text" id="searchInput" class="border rounded px-2 py-1 w-60" placeholder="Recherche...">
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#searchInput').on('keyup', function() {
            var searchText = $(this).val().toLowerCase();
            $('.bg-white').each(function() {
                var text = $(this).find('td:not(:first-child)').text().toLowerCase();
                if (text.includes(searchText)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });
    });
    </script>

    <div class="flex justify-between items-center mt-4">
        <a href="{{ route('admin.courier.create')}}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
            + Ajouter
        </a>
        <a href="{{ route('admin.courier.showColumns') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Configurer
        </a>
    </div>

    <div class="overflow-x-auto mt-4">
        <div class="px-4 sm:px-6 lg:px-8">
            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h1 class="text-base font-semibold text-gray-900">Courriers</h1>
                    <p class="mt-2 text-sm text-gray-700">Liste de tous les courriers comprenant leur numéro, objet, nature, et agent traitant.</p>
                </div>
            </div>
            <div class="mt-8 flow-root">
                <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                        <div class="relative">
                            <table class="min-w-full table-fixed divide-y divide-gray-300">
                                <thead>
                                    <tr>
                                        <th scope="col" class="relative px-7 sm:w-12 sm:px-6">
                                            <input type="checkbox" id="selectAll" class="appearance-none rounded border-gray-300 bg-white checked:border-indigo-600 checked:bg-indigo-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                        </th>
                                        <th scope="col" class="min-w-[12rem] py-3.5 pr-3 text-left text-sm font-semibold text-gray-900">N° de dossier</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Objet</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Nature</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Agent</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Date</th>
                                        <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-3">
                                            <span class="sr-only">Actions</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                    @foreach($couriers as $courier)
                                    <tr>
                                        <td class="relative px-7 sm:w-12 sm:px-6">
                                            <input type="checkbox" class="courierCheckbox appearance-none rounded border-gray-300 bg-white checked:border-indigo-600 checked:bg-indigo-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" value="{{ $courier->id }}">
                                        </td>
                                        <td class="whitespace-nowrap py-4 pr-3 text-sm font-medium text-gray-900">{{ $courier->annual_id }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $courier->object }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $courier->nature }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $courier->handlingUser->name }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $courier->created_at->format('d/m/Y') }}</td>
                                        <td class="whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-3">
                                            <a href="{{ route('admin.courier.edit', $courier->id) }}" class="text-indigo-600 hover:text-indigo-900">Éditer</a>
                                            <form action="{{ route('admin.courier.destroy', $courier->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Supprimer</button>
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
    </div>
    {{ $couriers->links() }}
</div>

<script>
    // JavaScript for select all
    document.getElementById('selectAll').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.courierCheckbox');
        checkboxes.forEach(checkbox => checkbox.checked = this.checked);
    });
</script>

@endsection
