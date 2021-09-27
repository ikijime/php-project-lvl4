@extends('layouts.app')

@section('content')

<main class="container">
    <h1 class="mb-4">Создать статус</h1>
    <form method="POST" action="{{ route('store_task_status') }}" accept-charset="UTF-8" class="w-50">
        @CSRF
    <div class="form-group">
        <label for="name">Имя</label>
        <input class="form-control" name="name" type="text" id="name">
    </div>
        <input class="btn btn-primary mt-1" type="submit" value="Создать">
    </form>
</main>
@endsection