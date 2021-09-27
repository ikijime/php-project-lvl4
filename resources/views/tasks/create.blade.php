@extends('layouts.app')

@section('content')
<main class="container">

    <h1 class="mb-5">Создать задачу</h1>

    <form method="POST" action="https://php-l4-task-manager.herokuapp.com/tasks" accept-charset="UTF-8" class="w-50">
        @csrf
        <div class="form-group">
            <label for="name">Имя</label>
            <input class="form-control" name="name" type="text" id="name">
        </div>

        <div class="form-group">
            <label for="description">Описание</label>
            <textarea class="form-control" name="description" cols="50" rows="10" id="description"></textarea>
        </div>

        <div class="form-group">
            <label for="status_id">Статус</label>
            <select class="form-control"  id="status_id" name="status_id"><option selected="selected" valueoption></select>
        </div>

        <div class="form-group">
            <label for="assigned_to_id">Исполнитель</label>
            <select class="form-control"  id="assigned_to_id" name="assigned_to_id"><option selected="selected" valueoption></select>
        </div>

        <div class="form-group">
            <label for="labels">Метки</label>
            <select class="form-control" multiple name="labels[]"><option value=""></option><option value="0"></option></select>
        </div>

        <input class="btn btn-primary" type="submit" value="Создать">
    </form>

</main>
@endsection