@extends('admin.admin')
@include('nav')

@section('title', 'Détails du courrier')

@section('content')
<div class="absolute top-12 left-0 mt-9 ml-2">
    <a href="{{ route('admin.courier.index')}}" class="text-blue-500 hover:underline flex items-center">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="fill-current h-5 w-5 mr-1">
            <path fill-rule="evenodd" d="M11.293 4.293a1 1 0 011.414 1.414l-4 4a1 1 0 010 1.414l4 4a1 1 0 01-1.414 1.414l-5-5a1 1 0 010-1.414l5-5a1 1 0 011.414 0z" clip-rule="evenodd"></path>
        </svg>
        Retour
    </a>
</div>

    <h1 class="text-2xl font-bold mt-4 mb-4">@yield('title')</h1>

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <div class="vstack gap-2">
        <div>
            <label class="block text-sm font-bold text-gray-700">N° de dossier :</label>
            <span class="text-gray-900">{{ $courier->annual_id}}</span>
        </div>
        <div>
            <label class="block text-sm font-bold text-gray-700">Objet :</label>
            <span class="text-gray-900">{{ $courier->object }}</span>
        </div>
        <div>
            <label class="block text-sm font-bold text-gray-700">Nature du document	 :</label>
            <span class="text-gray-900">{{ $courier->nature }}</span>
        </div>
        <div>
            <label class="block text-sm font-bold text-gray-700">Agent traitant :</label>
            <span class="text-gray-900">{{ $courier->id_handling_user }}</span>
        </div>
        <div>
            <label class="block text-sm font-bold text-gray-700">Année :</label>
            <span class="text-gray-900">{{ $courier->year }}</span>
        </div>
        <div>
            <label class="block text-sm font-bold text-gray-700">Créé le :</label>
            <span class="text-gray-900">{{ $courier->created_at }}</span>
        </div>
        <div>
            <label class="block text-sm font-bold text-gray-700">Mis à jour le :</label>
            <span class="text-gray-900">{{ $courier->updated_at }}</span>
        </div>
        <div>
            <label class="block text-sm font-bold text-gray-700">Lien :</label>
            <span class="text-gray-900">{{ $courier->document_path }}</span>
        </div>
        
        
        <!-- Affichage des colonnes supplémentaires -->
        @foreach($additionalColumns as $column)
       
            <div class="flex flex-col">
                <label class="block text-sm font-bold text-gray-700">{{ $column->name }} :</label>
                <span class="text-gray-900">{{ isset($additionalFields[$courier->id][$column->name]) ? $additionalFields[$courier->id][$column->name] : '' }}</span>
            </div>
    
        @endforeach

    </div>
   


@endsection
