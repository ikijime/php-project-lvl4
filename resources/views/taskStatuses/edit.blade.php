@extends('layouts.app')

@section('content')

<main class="container">
    <h1 class="mb-4">{{ __("Change status") }}</h1>
    <form method="POST" action="{{ route('task_statuses.update', $status) }}" accept-charset="UTF-8" class="w-50">
        @method('PATCH')
        @CSRF
    <div class="form-group">
        <label for="name">{{ __("Name") }}</label>
        <input class="form-control" name="name" type="text" id="name" value="{{ $status->name }}">
    </div>
        <input class="btn btn-primary mt-1" type="submit" value={{ __("Change") }}>
    </form>
</main>
@endsection