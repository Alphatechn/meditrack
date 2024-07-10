<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MediTrack</title>
</head>
<body>
    <h1>{{ $password['title'] }}</h1>
    <p>Madame, Monsieur <b>{{ $password['noms'] }},</b></p>
    <p>{{ $password['body'] }}</p>
    <p>Date : <b>{{ $password['date'] }}</b></p>
    <p>Motif : <b>{{ $password['motif'] }}</b></p>
    <p>Medecin : <b>{{ $password['nomspers'] }}</b></p>
    <p>N'hésitez pas à nous contacter si vous avez besoin de modifier ou d'annuler ce rendez-vous. Nous restons à votre disposition pour toute question complémentaire.</p>
    <p><center>Votre santé notre priorité</center></p>
</body>
</html>
