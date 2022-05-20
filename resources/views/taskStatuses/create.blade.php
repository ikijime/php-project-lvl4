@extends('layouts.app')

@section('content')

<main class="container">
    <h1 class="mb-4">{{ __("Create status") }}</h1>
    <form method="POST" action="/task_statuses" accept-charset="UTF-8" class="w-50">
        @CSRF
        <div class="form-group">
            <label for="name">{{ __("Name") }}</label>
            <input class="form-control" name="name" type="text" id="name">
        </div>
        <input class="btn btn-primary mt-1" type="submit" value={{ __("Create") }}>
    </form>
</main>
@endsection