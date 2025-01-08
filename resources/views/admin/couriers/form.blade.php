@extends('admin.admin')
@include('nav')

@section('title', $courier->exists ? 'Modifier un courrier' : 'Ajouter un courrier')

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
    <form class="vstack gap-2" action="{{ route($courier->exists ? 'admin.courier.update' : 'admin.courier.store', $courier) }}" method="POST">
        @csrf
        @method($courier->exists ? 'put' : 'post')

            
            @include('shared.input', ['label' => 'Nom', 'name' => 'object', 'type' => 'text', 'value' => $courier->object])
            <!-- Champ pour la catégorie avec une liste déroulante -->
            <div>
                <label for="nature" class="block text-sm font-medium text-gray-700">Nature</label>
                <select id="nature" name="nature" class="mt-1 block w-2/3 rounded-md px-4 py-2 border-gray-900 shadow focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 mb-2">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>


            <div>
                <label for="document_path" class="block text-sm font-medium text-gray-700">Lien</label>
                <div class="flex items-center">
                    <input type="text" name="document_path" id="document_path" class="mt-1 block w-2/3 rounded-md px-4 py-2 border-gray-900 shadow focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 mb-2">
                    <button type="button" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-2" onclick="openFilePicker()">Sélectionner</button>
                </div>
        </div>          
        
            
            
            
        <div>
            <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mt-2">
                @if($courier->exists)
                    Modifier
                @else
                    Ajouter
                @endif
                
            </button>
            
        </div>
    </form>
    
@endsection