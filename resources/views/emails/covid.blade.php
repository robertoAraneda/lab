@component('mail::message')
# {{ $details['title'] }}

Estimad@ usuario:<br>
<br>
<br>

{{ $details['body'] }}

@component('mail::table')
| Estado | Cantidad |
| :-------------|:--------|
| Muestras en espera | {{$details['current_stock'] }}|
| Muestras recepcionadas| {{$details['received'] }}|
| Muestras procesadas| {{$details['notified'] }}|
| Muestras positivas |{{ $details['positive']}} |
| Muestras stock final |{{$details['final_stock']}} |
| Muestras procesadas acumuladas | {{$details['sum_notified'] }}|
| Muestras positivas acumuladas | {{$details['sum_positive']}} |
@endcomponent

@component('mail::subcopy')
{{$details['observations']}}
@endcomponent

@component('mail::promotion')
ESTE ES UN CORREO DE PRUEBA
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent