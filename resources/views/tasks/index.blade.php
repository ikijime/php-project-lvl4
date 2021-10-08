@extends('layouts.app')

@section('content')
<main class="container">
    <h1 class="mb-5">Задачи</h1>
    <div class="d-flex">
        <div>
            <form method="GET" action="/tasks" accept-charset="UTF-8" class="form-inline">
                <select class="form-control mr-2" name="filter[status_id]">
                    <option selected="selected" value="">Статус</option>
                    @foreach (\App\Models\TaskStatus::all() as $status)
                    <option value={{ $status->id }}>{{ $status->name }}</option>
                    @endforeach
                </select>
                <select class="form-control mr-2" name="filter[author_id]">
                    <option selected="selected" value="">Автор</option>
                    @foreach (\App\Models\User::all() as $user)
                    <option value=" {{ $user->id }} "> {{ $user->name }} </option>
                    @endforeach
                </select>
                <select class="form-control mr-2" name="filter[assigned_to_id]">
                    <option selected="selected" value="">Исполнитель</option>
                    @foreach (\App\Models\User::all() as $user)
                    <option value=" {{ $user->id }} "> {{ $user->name }} </option>
                    @endforeach
                </select>
                <input class="btn btn-outline-primary mr-2" type="submit" value="Применить">
            </form>
        </div>
        @if (Auth::User())
        <a href="/tasks/create" class="btn btn-primary ml-auto">Создать задачу</a>
        @endif
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
        <tr>
            <td>{{ $task->id }}</td>
            <td>{{ $task->status->name }}</td>
            <td>
                <a href="/tasks/{{ $task->id }}">
                    {{ $task->name }}
                </a>
            </td>
            <td>{{ $task->creator->name }}</td>
            <td>{{ $task->executor->name }}</td>
            <td>{{ $task->created_at }}</td>

            @if (Auth::id() === $task->author_id)
            <td>
            <div class="btn-group">
                <a class="text-black" href="/tasks/{{ $task->id }}/edit">Изменить</a>
                <form action="/tasks/{{ $task->id }}" method="POST">
                    @method('delete')
                    @csrf
                    <button type="submit" class="btn btn-link text-danger pt-0">Удалить</button>               
                </form>
            </div>
            </td>
            @endif

            @endforeach
        </tr>
    </table>
</main>
@endsection