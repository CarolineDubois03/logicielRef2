<!DOCTYPE html>
<html>
<head>
    <title>Réinitialisation du mot de passe</title>
</head>
<body>
    <h2>Bonjour {{ $user->first_name }} {{ $user->last_name }},</h2>

    <p>Vous avez demandé la réinitialisation de votre mot de passe.</p>

    <p>Cliquez sur le lien suivant pour le réinitialiser :</p>

    <p><a href="{{ $resetUrl }}">Réinitialiser mon mot de passe</a></p>

    <p>Si vous n'avez pas fait cette demande, ignorez cet email.</p>

    <p>Merci,</p>
    <p>L'équipe</p>
</body>
</html>
