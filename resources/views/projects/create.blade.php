@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Добавить новый проект</h3>



        <div class="row">
            <div class="col-md-12">
                <form method="POST" action="{{ route('projects.store') }}">
                    @csrf
                <div class="form-group">
                    <input type="text" required="required" class="form-control" name="name" placeholder="Название" value="{{old('name')}}">
                    <br>
                    <input type="text" required="required" class="form-control" name="url" placeholder="Ссылка на группу VK" value="{{old('url')}}">
                    <br>
                    <button class="btn btn-success">Добавить</button>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection