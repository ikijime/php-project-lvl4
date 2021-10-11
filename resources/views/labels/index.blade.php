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
            @foreach ($labels as $label)
            <tr>
                <td>{{ $label->id }}</td>
                <td>{{ $label->name }}</td>
                <td>{{ $label->description }}</td>
                <td>{{ $label->created_at }}</td>
                
                <td>
                    <div class="btn-group">
                        <a class="text-black" href="/labels/{{ $label->id }}/edit">Изменить</a>

                        <form action="/labels/{{ $label->id }}" method="POST">
                            @method('delete')
                            @csrf
                            <button type="submit" class="btn btn-link text-danger pt-0">Удалить</button>
                        </form>

                </div>
                </td>
                
            </tr>
            @endforeach
    </table>
</main>
@endsection