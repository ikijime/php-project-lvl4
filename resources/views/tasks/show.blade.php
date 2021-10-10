@extends('layouts.app')

@section('content')
<main class="container">
    <h1 class="mb-5">Задачи</h1>
    <div class="d-flex">
        @if (Auth::User()) 
            <a href="/tasks/create" class="btn btn-primary ml-auto">Создать задачу</a>
        @endif
    </div>
    <p>Имя: {{ $task->name }}</p>
    <p>Статус: {{ $task->status->name }}</p>
    <p>Исполнитель: {{ $task->executor->name }}</p>
    <p>Описание: {{ $task->description }}</p>
    <p>Метки: </p>
    <ul>
        @foreach ($labels as $label)
        <li>{{ $label->name }}</li>
        @endforeach
    </ul>

</main>
@endsection