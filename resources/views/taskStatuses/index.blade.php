@extends('layouts.app')

@section('content')

@include('flash::message')

<main class="container">
    <h1 class="mb-5">Статусы Задач</h1>
    <table class="table mt-2">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Имя</th>
                    <th>Дата создания</th>
                </tr>
            </thead>
                <tr>
                @foreach($taskStatuses as $taskStatus)
                    <td> {{ $taskStatus->id }} </td>
                    <td> {{ $taskStatus->name }} </td>
                    <td> {{ $taskStatus->created_at }} </td>
                </tr>
                @endforeach
        </table>
</main>
@endsection