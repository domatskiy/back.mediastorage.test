@component('mail::message')

@if(isset($description))
<br><p>{{$description}}</p><br>
@endif

@component('mail::button', ['url' => $file])
Скачать файл
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
