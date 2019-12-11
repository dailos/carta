@component('mail::message')
## Hola {{ $user->name }},

Bienvenido a la gestión de Carta Etnográfica.

Puede gestionar los siguientes municipios:
@foreach ($user->municipios as $municipio)
	- {{ $municipio->nombre }}
@endforeach

@component('mail::panel')
Contraseña: {{ $password }}
@endcomponent

@component('mail::button', ['url' => url('login')])
Acceso a la carta
@endcomponent

Gracias,<br>
{{ config('app.name') }}
@endcomponent
