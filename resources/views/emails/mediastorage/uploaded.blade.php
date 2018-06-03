@component('mail::message')

@component('mail::button', ['url' => $file])
Скачать
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
