@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                <form method="POST" action="{{route('admin.destroy', ['id' => $data->id])}}">
                    {{ csrf_field() }}
                    <input name="_method" type="hidden" value="DELETE">

                    <button type="submit" class="btn btn-danger" onclick="return confirm('Точно удалить?');">Удалить</button>
                </form>
                    <br>
                <div class="card">
                    <div class="card-header">Редактирвание {{$data->id}}</div>
                    <div class="card-body">

                        <form method="POST" action="{{route('admin.update', ['id' => $data->id])}}">
                            {{ csrf_field() }}
                            <input name="_method" type="hidden" value="PUT">

                            <div class="form-group">
                                <label for="inputEmail1">Уникальный индетификатор пользователя</label>
                                <input name="email" type="email" class="form-control" id="inputEmail1" aria-describedby="emailHelp" placeholder="uuid" value="{{$data->user}}" disabled>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1">Email</label>
                                <input class="form-control" id="inputEmail1" aria-describedby="emailHelp" value="{{$data->email}}" disabled>
                                <small id="emailHelp" class="form-text text-muted">На него выслана ссылка на файл</small>
                            </div>

                            <div class="form-group">
                                <label for="inputFile">Файл</label>
                                <input class="form-control" id="inputEmail1" aria-describedby="emailHelp" placeholder="email" value="{{$data->path}}" disabled>
                            </div>

                            <div class="form-group">
                                <label for="inputDesc">Описание</label>
                                <textarea name="description" class="form-control" id="inputDesc" aria-describedby="descHelp">{{$data->description}}</textarea>
                                <small id="descHelp" class="form-text text-muted">Кратко не более 250 символов</small>
                            </div>

                            <button type="submit" class="btn btn-primary">Сохранить</button>

                            <a href="javascript:history.back()" class="btn btn-dark">Отмена</a>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
