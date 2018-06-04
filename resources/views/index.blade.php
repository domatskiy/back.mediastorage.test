@extends('layouts.app')

@section('content')
    <div class="container">
        Welcom to <a href="http://mediastorage.test" target="_blank">mediastorage.test</a>
        <br>
        <br>
        <br>
        You admin?<br>
        <a href="{{route('admin.index')}}">admin interface</a>
    </div>
@endsection

