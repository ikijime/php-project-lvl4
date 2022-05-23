@extends('layouts.app')

@section('content')
<main class="container">

    <h1 class="mb-3">{{ __("Create tag") }}</h1>

    <form method="POST" action="{{ route('labels.index') }}" accept-charset="UTF-8" class="w-50">
        @csrf

        <div class="form-group">
            <label for="name">{{ __("Name") }}</label>
            <input class="form-control  @error('name') is-invalid @enderror" value="{{ old('name') }}" name="name" type="text" id="name">
            @error('name')
            <div class="invalid-feedback d-block" role="alert" >
                <strong>{{ __($message, ['entity' => 'метка']) }}</strong>
            </div>
            @enderror
        </div>

        <div class="form-group">
            <label for="description">{{ __("Description") }}</label>
            <textarea class="form-control @error('description') is-invalid @enderror" name="description" cols="50" rows="10" id="description"></textarea>
            @error('description')
            <div class="invalid-feedback d-block" role="alert" >
                <strong>{{ __($message, ['entity' => 'метка']) }}</strong>
            </div>
            @enderror
        </div>

        <input class="btn btn-primary" type="submit" value="{{ __("Create") }}">

    </form>

</main>
@endsection