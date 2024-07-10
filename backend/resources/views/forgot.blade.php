@component('mail::message')
Hello {{ $user->nom }} {{ $user->prenom }}

<p>Nous comprenons que cela arrive.</p>

@component('mail::button', ['url' => 'http://localhost:5173/reset/'. $user->remember_token])
Réinitialisez votre mot de passe
@endcomponent

<p>Si vous rencontrez des problèmes pour récupérer votre mot de passe, veuillez nous contacter.</p>
Merci, <br>

{{ config('app.name') }}

@endcomponent
