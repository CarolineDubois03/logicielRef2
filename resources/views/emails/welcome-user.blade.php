<!DOCTYPE html>
<html>
<head>
    <title>Bienvenue sur la plateforme</title>
</head>
<body>
    <h2>Bonjour {{ $user->first_name }} {{ $user->last_name }},</h2>

    <p>Votre compte a été créé avec succès.</p>
    <p>Votre login : <strong>{{ $user->login }}</strong></p>
    <p>Votre mot de passe temporaire : <strong>{{ $temporaryPassword }}</strong></p>

    <p>Nous vous recommandons de changer votre mot de passe dès votre première connexion.</p>

    <p><a href="{{ route('admin.password.reset', ['token' => $user->createToken(name: 'password-reset')->plainTextToken]) }}">Réinitialiser votre mot de passe</a></p>

    <p>Merci,</p>
    <p>L'équipe</p>
</body>
</html>
