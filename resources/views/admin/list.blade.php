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

                @if(isset($files))
                    <div class="alert alert-dark" role="alert">
                        Всего файлов: {{$files->total()}}
                    </div>
                @endif
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Пользователь</th>
                        <th scope="col">Email</th>
                        <th scope="col">Файл</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(isset($files))
                    @foreach($files as $file)
                    <tr>
                        <th scope="row">
                            <a class="" href="{{route('admin.edit', ['id' => $file->id])}}">{{$file->id}}</a>
                        </th>
                        <td>{{$file->user}}</td>
                        <td>{{$file->email}}</td>
                        <td>
                            <!-- <a href="#">{{$file->filename}}</a> -->
                            {{$file->path}}
                        </td>

                        <td>
                            <div class="btn-group btn-group-sm">
                                <a class="btn btn-sm btn-dark" href="{{route('admin.edit', ['id' => $file->id])}}">Изменить</a>
                                <form action="" method="POST">
                                    <input name="_method" type="hidden" value="DELETE">
                                    <button class="btn btn-danger btn-sm" type="submit"  onclick="confirm('Точно удалить?'); return false">Удалить</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    @endif
                    </tbody>
                </table>
                @if(isset($files))
                {{ $files->links() }}
                @endif
            </div>
        </div>
    </div>
@endsection

