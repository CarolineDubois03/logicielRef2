@extends('admin.admin')
@include('nav')

@section('title', 'Modifier un courrier')

@section('content')
<div class="px-8 py-10 bg-gray-50">
<a href="{{ route('admin.courier.index') }}" class="text-blue-500 hover:underline flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a1 1 0 01-.707-.293l-7-7a1 1 0 010-1.414l7-7a1 1 0 011.414 1.414L4.414 10H18a1 1 0 110 2H4.414l6.293 6.293A1 1 0 0110 18z" clip-rule="evenodd" />
                </svg>
                Retour
            </a>
    <div class="max-w-5xl mx-auto bg-white shadow-lg rounded-xl">
        <div class="px-8 py-6 border-b border-gray-200 flex items-center justify-between">
            
            <h1 class="text-2xl font-bold text-gray-800">Modifier un courrier</h1>
        </div>

        @if($errors->any())
        <div class="p-4 mt-4 bg-red-50 border border-red-200 rounded-md">
            <ul class="text-sm text-red-600">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form class="space-y-8 px-8 py-8" action="{{ route('admin.courier.update', $courier->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                <div>
                    <label for="object" class="block text-lg font-medium text-gray-700">Objet</label>
                    <input type="text" name="object" id="object" value="{{ old('object', $courier->object) }}" class="mt-1 block w-full rounded-lg px-4 py-2 border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
                </div>

               
                <div>
                    <label for="recipient" class="block text-lg font-medium text-gray-700">Destinataire</label>
                    <select id="recipient" name="recipient" class="mt-1 block w-full rounded-lg px-4 py-2 border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 select2-recipient">
                        @if($courier->couriersRecipient)
                            <option value="{{ $courier->couriersRecipient->id }}" selected>{{ $courier->couriersRecipient->label }}</option>
                        @endif
                    </select>
                    <p class="text-sm text-gray-500 mt-1">Recherchez ou ajoutez un destinataire.</p>
                </div>

                <div>
                    <label for="id_handling_user" class="block text-lg font-medium text-gray-700">Agent traitant</label>
                    <input type="text" id="id_handling_user" value="{{ $courier->handlingUser->first_name }} {{ $courier->handlingUser->last_name }}" class="mt-1 block w-full rounded-lg px-4 py-2 border-gray-300 bg-gray-100 shadow-sm focus:ring-0 focus:border-gray-300" readonly>
                    <input type="hidden" name="id_handling_user" value="{{ $courier->handlingUser->id }}">
                </div>

                <div>
                    <label for="category" class="block text-lg font-medium text-gray-700">Catégorie</label>
                    <select id="category" name="category" class="mt-1 block w-full rounded-lg px-4 py-2 border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ $courier->category == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="document_path" class="block text-lg font-medium text-gray-700">Classement</label>
                    <input type="text" name="document_path" id="document_path" value="{{old('document_path', $courier->document_path) }}" class="mt-1 block w-full rounded-lg px-4 py-2 border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
                </div>     

               
                <div>
                    <label for="copy_to" class="block text-lg font-medium text-gray-700">Copie à</label>
                    <select id="copy_to" name="copy_to[]" class="mt-1 block w-full rounded-lg px-4 py-2 border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 select2-copy-to" multiple>
                        @foreach($courier->copiedUsers as $user)
                            <option value="{{ $user->id }}" selected>{{ $user->first_name }} {{ $user->last_name }}</option>
                        @endforeach
                    </select>
                    <p class="text-sm text-gray-500 mt-1">Recherchez et ajoutez des utilisateurs.</p>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="inline-flex items-center px-6 py-3 text-lg font-medium text-white bg-indigo-600 rounded-lg shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Modifier
                </button>
            </div>
        </form>
    </div>
</div>

<script>
$(document).ready(function () {
    $('.select2-recipient').select2({
        placeholder: 'Rechercher ou ajouter un destinataire',
        ajax: {
            url: '{{ route("admin.recipients.search") }}',
            dataType: 'json',
            delay: 250,
            data: params => ({ q: params.term }),
            processResults: data => ({
                results: data.map(recipient => ({ id: recipient.id, text: recipient.label }))
            })
        },
        tags: true,
        createTag: params => ({
            id: params.term,
            text: params.term,
            newOption: true
        })
    });

    $('.select2-copy-to').select2({
    placeholder: 'Rechercher et ajouter des utilisateurs',
    ajax: {
        url: '{{ route("admin.users.search") }}',
        dataType: 'json',
        delay: 250,
        data: params => ({ q: params.term }), // Envoie le terme de recherche
        processResults: data => ({
            results: data // Les résultats sont renvoyés directement
        })
    },
    multiple: true,
    allowClear: true
});

});
</script>
@endsection
