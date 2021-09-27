@extends('layouts.app')

@section('content')
<main class="container">
    <h1 class="mb-5">Метки</h1>

    @if (Auth::User())
    <a href="/labels/create" class="btn btn-primary ml-auto">Создать Метку</a>
    @endif

    <table class="table mt-2">
        <thead>
            <tr>
                <th>ID</th>
                <th>Имя</th>
                <th>Описание</th>
                <th>Дата создания</th>
            </tr>
        </thead>
            <tr>
                <td>1</td>
                <td>Name</td>
                <td>Description</td>
                <td>10.10.1994</td>
            </tr>
    </table>
</main>
@endsection