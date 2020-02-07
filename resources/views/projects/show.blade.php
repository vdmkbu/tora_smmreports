@extends('layouts.app')




@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
            <h3>Управление проектом "{{$project->name}}"</h3>

            <p><h4>Загрузить данные за интервал</h4></p>
            <form method="GET" action="{{ route('projects.report', [$project->id]) }}">
            <label for="from">с</label>
            <input type="text" id="from" name="from" required="required">
            <label for="to">до</label>
            <input type="text" id="to" name="to" required="required">

            <button class="btn btn-success">Получить PDF</button>
            </form>


        </div>
    </div>
    </div>


@endsection