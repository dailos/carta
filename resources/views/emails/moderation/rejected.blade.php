@component('mail::message')

{{ $moderableRecord->user->name }},

La petición de {{ __('carta.' . $moderableRecord->action) }} ficha ha sido rechazada.
Razón: {{$moderableRecord->comment}}

@component('mail::button', ['url' => route('collaborator.historial.show', $moderableRecord->id)])
Ver ficha
@endcomponent

@component('mail::panel', ['url' => ''])
Acceda con su usuario para ver el historial de peticiones.
@endcomponent

Datos de la ficha:
@component('mail::table')
| Nombre     | Valor        |
|------------|--------------|
| Nº ficha   | @if($moderableRecord->model){{ $moderableRecord->model->cod_ficha }}@endif |
| @lang('validation.attributes.denominacion') | {{ $moderableRecord->getField('denominacion') }} |
| @lang('validation.attributes.municipio_id') | {{ $moderableRecord->getRelatedField('municipio_id') }} |
| @lang('validation.attributes.localidad_id') | {{ $moderableRecord->getRelatedField('localidad_id') }} |
| @lang('validation.attributes.actividad_id') | {{ $moderableRecord->getRelatedField('actividad_id') }} |
@endcomponent

{{ config('app.name') }}
@endcomponent
