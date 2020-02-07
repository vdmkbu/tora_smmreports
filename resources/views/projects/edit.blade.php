@extends('layouts.app')

@section('content')


    <div class="container">
        <h3>Редактировать проект {{$project->name}}</h3>



        <div class="row">
            <div class="col-md-12">
                <form method="POST" action="{{ route('projects.update', [$project->id]) }}">
                    @csrf
                    @method('PUT')
                <div class="form-group">
                    <input type="text" class="form-control" required="required" name="name" value="{{$project->name}}">
                    <br>
                    <input type="text" class="form-control" required="required" name="url" value="{{$project->url}}">
                    <br>
                    <button class="btn btn-warning">Редактировать</button>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection