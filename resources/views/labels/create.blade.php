@extends('layouts.app')

@section('content')
<main class="container">

    <h1 class="mb-3">{{ __("Create tag") }}</h1>

    <form method="POST" action="/labels" accept-charset="UTF-8" class="w-50">
        @csrf

        <div class="form-group">
            <label for="name">{{ __("Name") }}</label>
            <input class="form-control" name="name" type="text" id="name">
        </div>

        <div class="form-group">
            <label for="description">{{ __("Description") }}</label>
            <textarea class="form-control" name="description" cols="50" rows="10" id="description"></textarea>
        </div>

        <input class="btn btn-primary" type="submit" value="{{ __("Create") }}">
        
    </form>

</main>
@endsection