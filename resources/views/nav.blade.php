<form method="POST" action="{{ route('logout') }}">
<nav class="bg-blue-500 p-6 flex justify-between items-center">
<div class="text-white font-bold text-2xl"> 
    <a href="{{ route('admin.courier.index') }}"> Archivéo </a>
</div>
    <div class="flex items-center space-x-4">
    <a href="{{ route('admin.profile.show', auth()->user()->id) }}" class="text-white">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="h-6 w-6" fill="currentColor">
                <path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z"/>
            </svg>
        </a>

        <a href="{{ route('admin.courier.index') }}" class="text-white">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="h-6 w-6" fill="currentColor">
                <path d="M48 64C21.5 64 0 85.5 0 112c0 15.1 7.1 29.3 19.2 38.4L236.8 313.6c11.4 8.5 27 8.5 38.4 0L492.8 150.4c12.1-9.1 19.2-23.3 19.2-38.4c0-26.5-21.5-48-48-48H48zM0 176V384c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V176L294.4 339.2c-22.8 17.1-54 17.1-76.8 0L0 176z"/>
            </svg>
        </a>

        
            @csrf <!-- Pour des raisons de sécurité, incluez toujours le jeton CSRF -->
            @method('delete')
            <!-- Bouton de soumission stylisé avec une icône -->
            <button type="submit" class="text-white">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="h-6 w-6" fill="currentColor">
                    <path d="M502.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-128-128c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L402.7 224 192 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l210.7 0-73.4 73.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l128-128zM160 96c17.7 0 32-14.3 32-32s-14.3-32-32-32L96 32C43 32 0 75 0 128L0 384c0 53 43 96 96 96l64 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-64 0c-17.7 0-32-14.3-32-32l0-256c0-17.7 14.3-32 32-32l64 0z"/>
                </svg>
            </button>
        </form>

    </div>
</nav>
