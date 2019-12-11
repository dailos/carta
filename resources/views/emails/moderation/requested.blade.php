@component('mail::message')

El usuario <strong>{{ $moderableRecord->user->name }}</strong> ha solicitado una petición de {{ __('carta.' . $moderableRecord->action) }} ficha @if($moderableRecord->model) [ Nº: {{ $moderableRecord->model->cod_ficha }} ] @endif

@component('mail::button', ['url' => route('admin.moderacion.show', $moderableRecord->id)])
Ver petición
@endcomponent

@component('mail::panel')
Acceda con su usuario para ver las peticiones pendientes.
@endcomponent

Datos de la ficha:
@component('mail::table')
| Nombre     | Valor        |
|------------|--------------|
@if($moderableRecord->model)| Nº ficha   | {{ $moderableRecord->model->cod_ficha }} |@endif
| @lang('validation.attributes.denominacion') | {{ $moderableRecord->getField('denominacion') }} |
| @lang('validation.attributes.municipio_id') | {{ $moderableRecord->getRelatedField('municipio_id') }} |
| @lang('validation.attributes.localidad_id') | {{ $moderableRecord->getRelatedField('localidad_id') }} |
| @lang('validation.attributes.actividad_id') | {{ $moderableRecord->getRelatedField('actividad_id') }} |
@endcomponent

{{ config('app.name') }}
@endcomponent