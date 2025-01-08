<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>@yield('title') | Administration</title>
    
</head>
<body>
    
<div class="container mx-auto p-4">

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
@if(session('error'))

    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

    @yield('content')
</div>

    
</body>
</html>