@extends('layouts.app')

@section('content')

<main class="container py-2">
    <h1 class="mb-4">{{ __("Change status") }}</h1>
    <form method="POST" action="{{ route('task_statuses.update', $status) }}" accept-charset="UTF-8" class="w-50">
        @method('PATCH')
        @CSRF
        <div class="form-group">
            <label for="name">{{ __("Name") }}</label>
            <input class="form-control" name="name" type="text" id="name" value="{{ $status->name }}">
            @error('name')
            <div class="invalid-feedback d-block" role="alert" >
                <strong>{{ __($message, ['entity' => 'статус']) }}</strong>
            </div>
            @enderror
        </div>
        <input class="btn btn-primary mt-1" type="submit" value={{ __("Update") }}>
    </form>
</main>
@endsection