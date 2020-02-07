@extends('layouts.app')

@section('content')
    <p></p><a href="{{route('projects.create')}}" class="btn btn-success">Добавить новый</a></p>
    <div class="container">
        <div class="row">
            <h3>Список проектов</h3>
            <div class="col-md-12">
                <table class="table">
                    <thead>
                    <tr>
                        <td>ID</td>
                        <td>Название</td>
                        <td>URL</td>
                        <td>Действия</td>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($projects as $project)
                        <tr>
                            <td>{{$project->id}}</td>
                            <td>{{$project->name}}</td>
                            <td>{{$project->url}}</td>
                            <td>
                                <a href="{{route('projects.show',$project->id)}}">
                                    Сформировать отчёт
                                </a>
                                <br>
                                <a href="{{route('projects.edit', $project->id)}}">
                                    Редактировать проект
                                </a>
                                <br>

                                <form method="POST" action="{{ route('projects.destroy', $project->id) }}">
                                    @csrf
                                    @method('DELETE')
                                <button onclick="return confirm('Подтверждаете удаление?')">
                                    Удалить
                                </button>
                                </form>

                            </td>
                        </tr>
                    @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div>
@endsection