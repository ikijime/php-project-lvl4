@extends('layouts.app')

@section('content')
<main class="container">
    <h1 class="mb-5">Задачи</h1>
    <div class="d-flex">
            <div>
                <form method="GET" action="/tasks" accept-charset="UTF-8" class="form-inline">
                <select class="form-control mr-2" name="filter[status_id]"><option selected="selected" value="">Статус</option></select>
                    <select class="form-control mr-2" name="filter[created_by_id]"><option selected="selected" value="">Автор</option></select>
                    <select class="form-control mr-2" name="filter[assigned_to_id]"><option selected="selected" value="">Исполнитель</option></select>
                    <input class="btn btn-outline-primary mr-2" type="submit" value="Применить">
                </form>
            </div>
    </div>
        <table class="table mt-2">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Статус</th>
                    <th>Имя</th>
                    <th>Автор</th>
                    <th>Исполнитель</th>
                    <th>Дата создания</th>
                                </tr>
            </thead>
                @foreach($tasks as $task)
                    <td>$task->id</td>
                    <td>$task->status</td>
                    <td>
                        <a href="https://php-l4-task-manager.herokuapp.com/tasks/{{ $task->id }}">
                            $task->name
                        </a>
                    </td>
                    <td>$task->author</td>
                    <td>$task->executor</td>
                    <td>$task->created_at</td>
                @endforeach
        </table>
</main>
@endsection